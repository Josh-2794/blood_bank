// ============================================================
//  router.js — Single Page App routing
// ============================================================

function showPage(pageId) {
    $$('.page').forEach(p => { p.classList.remove('active'); p.classList.add('hidden'); });
    $$('.nav-link').forEach(l => l.classList.remove('active'));

    const page = document.getElementById('page-' + pageId);
    const link = document.querySelector(`[data-page="${pageId}"]`);

    if (page) {
        page.classList.remove('hidden');
        page.classList.add('active');
        page.classList.add('fade-in');
    }
    if (link) link.classList.add('active');

    window.scrollTo({ top: 0, behavior: 'smooth' });

    // Lazy-load data when a page is opened
    if (pageId === 'inventory') loadInventory();
    if (pageId === 'request')   searchDonors();
    if (pageId === 'admin')     loadAdminDashboard();
}
