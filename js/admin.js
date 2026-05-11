// ============================================================
//  admin.js — Admin Dashboard, Table Rendering & Tab Switching
// ============================================================

// ── Dashboard Data Loading ───────────────────────────────────
async function loadAdminDashboard() {
    let donors, requests, inventory;
    try {
        const [donorsRes, requestsRes, invRes] = await Promise.all([
            fetch(API.donors),
            fetch(API.requests),
            fetch(API.inventory),
        ]);
        donors    = await donorsRes.json();
        requests  = await requestsRes.json();
        inventory = await invRes.json();
    } catch (err) {
        console.error('Admin dashboard load failed:', err);
        return;
    }

    const el = id => document.getElementById(id);
    if (el('stat-donors'))   el('stat-donors').textContent   = donors.count || 0;
    if (el('stat-requests')) el('stat-requests').textContent = (requests.requests || []).filter(r => r.status === 'Pending').length;
    if (el('stat-units'))    el('stat-units').textContent    = (inventory.inventory || []).reduce((s, i) => s + Number(i.units), 0);

    renderAdminRequestsTable(requests.requests || []);
    renderAdminDonorsTable(donors.donors || []);
}

// ── Table Renderers ──────────────────────────────────────────
function renderAdminRequestsTable(rows) {
    const statusClass = {
        Pending:   'pill-warning',
        Approved:  'pill-success',
        Fulfilled: 'pill-info',
        Rejected:  'pill-danger',
    };

    const buildRow = r => `
        <tr>
            <td>${r.patient_name}</td>
            <td><strong>${r.blood_group}</strong></td>
            <td>${r.units_required}</td>
            <td>${r.hospital}</td>
            <td>${r.required_by}</td>
            <td><span class="pill ${statusClass[r.status] || ''}">${r.status}</span></td>
            <td>
                ${r.status === 'Pending' ? `
                <button class="btn btn-sm btn-primary" onclick="updateRequestStatus(${r.id},'Approved')">Approve</button>
                <button class="btn btn-sm btn-danger"  onclick="updateRequestStatus(${r.id},'Rejected')" style="margin-left:4px">Reject</button>
                ` : '—'}
            </td>
        </tr>`;

    // Overview tab — latest 10
    const overview = document.getElementById('admin-req-tbody');
    if (overview) overview.innerHTML = rows.slice(0, 10).map(buildRow).join('');

    // Requests tab — all rows
    const full = document.getElementById('admin-req-tbody2');
    if (full) full.innerHTML = rows.length
        ? rows.map(buildRow).join('')
        : '<tr><td colspan="7" class="text-muted" style="padding:20px">No requests found.</td></tr>';
}

function renderAdminDonorsTable(rows) {
    const tbody = document.getElementById('admin-donors-tbody');
    if (!tbody) return;

    tbody.innerHTML = rows.slice(0, 15).map(d => `
        <tr>
            <td>${d.first_name} ${d.last_name}</td>
            <td><strong>${d.blood_group}</strong></td>
            <td>${d.city}</td>
            <td>${d.phone}</td>
            <td><span class="pill ${d.availability === 'Not Available' ? 'pill-danger' : 'pill-success'}">${d.availability}</span></td>
        </tr>
    `).join('');
}

// ── Request Status Update ────────────────────────────────────
async function updateRequestStatus(id, status) {
    if (!confirm(`Set request #${id} to "${status}"?`)) return;

    const res  = await fetch(API.requests, {
        method:  'PUT',
        headers: { 'Content-Type': 'application/json' },
        body:    JSON.stringify({ id, status }),
    });
    const data = await res.json();

    if (data.success) {
        alert('Status updated!');
        loadAdminDashboard();
    } else {
        alert('Error: ' + data.message);
    }
}

// ── Tab Switching ────────────────────────────────────────────
function switchAdminTab(tabId) {
    $$('.admin-tab-content').forEach(t => t.classList.add('hidden'));
    $$('.admin-nav-item').forEach(b => b.classList.remove('active'));

    const tab = document.getElementById('tab-' + tabId);
    const btn = document.querySelector(`[data-tab="${tabId}"]`);
    if (tab) tab.classList.remove('hidden');
    if (btn) btn.classList.add('active');
}
