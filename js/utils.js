// ============================================================
//  utils.js — API endpoints & shared helper functions
// ============================================================

const API = {
    donors:    'api/donors.php',
    requests:  'api/requests.php',
    inventory: 'api/inventory.php',
    login:     'api/admin_login.php',
};

// Shorthand selectors
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
