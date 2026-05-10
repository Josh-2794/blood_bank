// ============================================================
//  requests.js — Blood Request Form Submission
// ============================================================

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
