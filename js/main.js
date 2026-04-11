// ============================================================
//  main.js  — LifeFlow Blood Bank Management System
//  Main JavaScript — API calls, UI logic
// ============================================================

const API = {
    donors:    'api/donors.php',
    requests:  'api/requests.php',
    inventory: 'api/inventory.php',
    login:     'api/admin_login.php',
};

// ── Utility ─────────────────────────────────────────────────
const $  = (sel, ctx = document) => ctx.querySelector(sel);
const $$ = (sel, ctx = document) => [...ctx.querySelectorAll(sel)];

function showAlert(id, msg, type = 'success') {
    const el = document.getElementById(id);
    if (!el) return;
    el.textContent = msg;
    el.className = `alert alert-${type}`;
    el.classList.remove('hidden');
    setTimeout(() => el.classList.add('hidden'), 5000);
}

function setLoading(btn, loading) {
    if (!btn) return;
    btn.disabled = loading;
    btn.textContent = loading ? 'Please wait...' : btn.dataset.label;
}

// ── Blood Group Selector ─────────────────────────────────────
let selectedBloodGroup = '';

function initBloodGroupBtns(containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;
    $$('.bg-btn', container).forEach(btn => {
        btn.addEventListener('click', () => {
            $$('.bg-btn', container).forEach(b => b.classList.remove('selected'));
            btn.classList.add('selected');
            selectedBloodGroup = btn.dataset.bg;
        });
    });
}

// ── DONOR REGISTRATION ───────────────────────────────────────
async function submitDonorRegistration(e) {
    e.preventDefault();

    if (!selectedBloodGroup) {
        showAlert('donor-alert', 'Please select a blood group.', 'danger');
        return;
    }

    const btn = document.getElementById('donor-submit-btn');
    setLoading(btn, true);

    const payload = {
        first_name:     document.getElementById('d-fname').value.trim(),
        last_name:      document.getElementById('d-lname').value.trim(),
        email:          document.getElementById('d-email').value.trim(),
        phone:          document.getElementById('d-phone').value.trim(),
        date_of_birth:  document.getElementById('d-dob').value,
        gender:         document.getElementById('d-gender').value,
        blood_group:    selectedBloodGroup,
        city:           document.getElementById('d-city').value.trim(),
        weight_kg:      document.getElementById('d-weight').value,
        last_donation:  document.getElementById('d-lastdon').value,
        availability:   document.getElementById('d-avail').value,
        medical_notes:  document.getElementById('d-notes').value.trim(),
    };

    try {
        const res  = await fetch(API.donors, {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify(payload),
        });
        const data = await res.json();

        if (data.success) {
            showAlert('donor-alert', '✓ ' + data.message, 'success');
            document.getElementById('donor-form').reset();
            selectedBloodGroup = '';
            $$('.bg-btn').forEach(b => b.classList.remove('selected'));
        } else {
            showAlert('donor-alert', '✗ ' + data.message, 'danger');
        }
    } catch (err) {
        showAlert('donor-alert', 'Network error. Please try again.', 'danger');
    } finally {
        setLoading(btn, false);
    }
}

// ── DONOR SEARCH ─────────────────────────────────────────────
async function searchDonors() {
    const bg    = document.getElementById('s-bg')?.value    || '';
    const city  = document.getElementById('s-city')?.value  || '';
    const avail = document.getElementById('s-avail')?.value || '';

    const params = new URLSearchParams();
    if (bg)    params.append('blood_group',   bg);
    if (city)  params.append('city',          city);
    if (avail) params.append('availability',  avail);

    const grid = document.getElementById('donor-results');
    if (!grid) return;
    grid.innerHTML = '<p class="text-muted" style="padding:8px 0">Searching...</p>';

    try {
        const res  = await fetch(`${API.donors}?${params}`);
        const data = await res.json();
        renderDonorCards(data.donors || []);
    } catch {
        grid.innerHTML = '<p class="text-muted">Could not load donors. Check your connection.</p>';
    }
}

function renderDonorCards(donors) {
    const grid = document.getElementById('donor-results');
    if (!grid) return;

    if (!donors.length) {
        grid.innerHTML = '<p class="text-muted" style="padding:8px 0">No donors found matching your criteria.</p>';
        return;
    }

    grid.innerHTML = donors.map(d => {
        const isAvail = d.availability !== 'Not Available';
        return `
        <div class="card fade-in" style="padding:20px">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:14px">
                <div style="background:var(--red);color:white;font-size:18px;font-weight:700;
                            padding:8px 14px;border-radius:10px;font-family:var(--font-head)">${d.blood_group}</div>
                <span class="pill ${isAvail ? 'pill-success' : 'pill-danger'}">
                    ${isAvail ? d.availability : 'Unavailable'}
                </span>
            </div>
            <div style="font-size:15px;font-weight:600;margin-bottom:3px">${d.first_name} ${d.last_name}</div>
            <div style="font-size:13px;color:var(--gray-400)">${d.city} &nbsp;·&nbsp; ${d.phone}</div>
            ${d.last_donation ? `<div style="font-size:12px;color:var(--gray-400);margin-top:4px">Last donated: ${d.last_donation}</div>` : ''}
            <button class="btn btn-outline btn-sm" style="width:100%;margin-top:14px;justify-content:center"
                onclick="contactDonor('${d.first_name} ${d.last_name}','${d.phone}')">
                Contact Donor
            </button>
        </div>`;
    }).join('');
}

function contactDonor(name, phone) {
    alert(`Contacting ${name}\nPhone: ${phone}\n\nIn production this would send an SMS/email notification.`);
}

// ── BLOOD REQUEST SUBMISSION ─────────────────────────────────
async function submitBloodRequest(e) {
    e.preventDefault();

    const btn = document.getElementById('req-submit-btn');
    setLoading(btn, true);

    const payload = {
        patient_name:     document.getElementById('r-patient').value.trim(),
        contact_number:   document.getElementById('r-contact').value.trim(),
        blood_group:      document.getElementById('r-bg').value,
        units_required:   document.getElementById('r-units').value,
        hospital:         document.getElementById('r-hospital').value.trim(),
        required_by:      document.getElementById('r-date').value,
        additional_notes: document.getElementById('r-notes').value.trim(),
    };

    try {
        const res  = await fetch(API.requests, {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify(payload),
        });
        const data = await res.json();
        if (data.success) {
            showAlert('req-alert', '✓ ' + data.message, 'success');
            document.getElementById('request-form').reset();
        } else {
            showAlert('req-alert', '✗ ' + data.message, 'danger');
        }
    } catch {
        showAlert('req-alert', 'Network error. Please try again.', 'danger');
    } finally {
        setLoading(btn, false);
    }
}

// ── INVENTORY ────────────────────────────────────────────────
async function loadInventory() {
    const grid = document.getElementById('inv-grid');
    if (!grid) return;

    try {
        const res  = await fetch(API.inventory);
        const data = await res.json();
        renderInventoryCards(data.inventory || []);
    } catch {
        grid.innerHTML = '<p class="text-muted">Could not load inventory.</p>';
    }
}

function renderInventoryCards(inventory) {
    const grid = document.getElementById('inv-grid');
    if (!grid) return;

    const statusClass = { Critical: 'pill-danger', Low: 'pill-warning', OK: 'pill-success' };

    grid.innerHTML = inventory.map(i => `
        <div class="card" style="text-align:center;position:relative;overflow:hidden;padding:24px 20px">
            <div style="position:absolute;top:0;left:0;right:0;height:4px;background:var(--red)"></div>
            <div style="font-family:var(--font-head);font-size:26px;font-weight:700">${i.blood_group}</div>
            <div style="font-size:32px;font-weight:700;color:var(--red);margin:6px 0">${i.units}</div>
            <div style="font-size:11px;color:var(--gray-400);text-transform:uppercase;letter-spacing:.5px">Units Available</div>
            <span class="pill ${statusClass[i.status] || 'pill-info'}" style="margin-top:10px">${i.status}</span>
            <div style="background:var(--gray-200);border-radius:4px;height:6px;margin-top:12px;overflow:hidden">
                <div style="height:6px;background:var(--red);width:${Math.min(100,i.stock_pct)}%;border-radius:4px;transition:.5s"></div>
            </div>
            <div style="font-size:11px;color:var(--gray-400);margin-top:5px">${i.stock_pct}% capacity</div>
        </div>
    `).join('');
}

// ── ADMIN DASHBOARD ──────────────────────────────────────────
async function loadAdminDashboard() {
    // Load stats
    const [donorsRes, requestsRes, invRes] = await Promise.all([
        fetch(API.donors),
        fetch(API.requests),
        fetch(API.inventory),
    ]);
    const donors    = await donorsRes.json();
    const requests  = await requestsRes.json();
    const inventory = await invRes.json();

    const el = id => document.getElementById(id);
    if (el('stat-donors'))   el('stat-donors').textContent   = donors.count    || 0;
    if (el('stat-requests')) el('stat-requests').textContent = (requests.requests || []).filter(r => r.status === 'Pending').length;
    if (el('stat-units'))    el('stat-units').textContent    = (inventory.inventory || []).reduce((s, i) => s + Number(i.units), 0);

    // Render requests table
    renderAdminRequestsTable(requests.requests || []);
    renderAdminDonorsTable(donors.donors || []);
}

function renderAdminRequestsTable(rows) {
    const tbody = document.getElementById('admin-req-tbody');
    if (!tbody) return;

    const statusClass = { Pending: 'pill-warning', Approved: 'pill-success', Fulfilled: 'pill-info', Rejected: 'pill-danger' };

    tbody.innerHTML = rows.slice(0, 10).map(r => `
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
                <button class="btn btn-sm btn-danger" onclick="updateRequestStatus(${r.id},'Rejected')" style="margin-left:4px">Reject</button>
                ` : '—'}
            </td>
        </tr>
    `).join('');
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

// ── ADMIN TABS ───────────────────────────────────────────────
function switchAdminTab(tabId) {
    $$('.admin-tab-content').forEach(t => t.classList.add('hidden'));
    $$('.admin-nav-item').forEach(b => b.classList.remove('active'));

    const tab = document.getElementById('tab-' + tabId);
    const btn = document.querySelector(`[data-tab="${tabId}"]`);
    if (tab) tab.classList.remove('hidden');
    if (btn) btn.classList.add('active');
}

// ── PAGE ROUTING (Single Page App) ───────────────────────────
function showPage(pageId) {
    $$('.page').forEach(p => { p.classList.remove('active'); p.classList.add('hidden'); });
    $$('.nav-link').forEach(l => l.classList.remove('active'));

    const page = document.getElementById('page-' + pageId);
    const link = document.querySelector(`[data-page="${pageId}"]`);
    if (page) { page.classList.remove('hidden'); page.classList.add('active'); page.classList.add('fade-in'); }
    if (link) link.classList.add('active');

    window.scrollTo({ top: 0, behavior: 'smooth' });

    // Lazy-load data
    if (pageId === 'inventory') loadInventory();
    if (pageId === 'request')   searchDonors();
    if (pageId === 'admin')     loadAdminDashboard();
}

// ── INIT ─────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    // Blood group buttons
    initBloodGroupBtns('donor-bg-selector');

    // Donor form
    const donorForm = document.getElementById('donor-form');
    if (donorForm) donorForm.addEventListener('submit', submitDonorRegistration);

    // Request form
    const reqForm = document.getElementById('request-form');
    if (reqForm) reqForm.addEventListener('submit', submitBloodRequest);

    // Default: show home
    showPage('home');
});
