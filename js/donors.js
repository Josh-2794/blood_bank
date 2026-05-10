// ============================================================
//  donors.js — Donor Registration, Search & Card Rendering
// ============================================================

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

// ── Registration ─────────────────────────────────────────────
async function submitDonorRegistration(e) {
    e.preventDefault();

    if (!selectedBloodGroup) {
        showAlert('donor-alert', 'Please select a blood group.', 'danger');
        return;
    }

    const btn = document.getElementById('donor-submit-btn');
    setLoading(btn, true);

    const payload = {
        first_name:    document.getElementById('d-fname').value.trim(),
        last_name:     document.getElementById('d-lname').value.trim(),
        email:         document.getElementById('d-email').value.trim(),
        phone:         document.getElementById('d-phone').value.trim(),
        date_of_birth: document.getElementById('d-dob').value,
        gender:        document.getElementById('d-gender').value,
        blood_group:   selectedBloodGroup,
        city:          document.getElementById('d-city').value.trim(),
        weight_kg:     document.getElementById('d-weight').value,
        last_donation: document.getElementById('d-lastdon').value,
        availability:  document.getElementById('d-avail').value,
        medical_notes: document.getElementById('d-notes').value.trim(),
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
    } catch {
        showAlert('donor-alert', 'Network error. Please try again.', 'danger');
    } finally {
        setLoading(btn, false);
    }
}

// ── Search ───────────────────────────────────────────────────
async function searchDonors() {
    const bg    = document.getElementById('s-bg')?.value    || '';
    const city  = document.getElementById('s-city')?.value  || '';
    const avail = document.getElementById('s-avail')?.value || '';

    const params = new URLSearchParams();
    if (bg)    params.append('blood_group',  bg);
    if (city)  params.append('city',         city);
    if (avail) params.append('availability', avail);

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
