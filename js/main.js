// ============================================================
//  main.js — App Initialisation (DOMContentLoaded entry point)
//  Depends on: utils.js, router.js, donors.js, requests.js,
//              inventory.js, admin.js
// ============================================================

document.addEventListener('DOMContentLoaded', () => {
    // Wire up blood group selector on the donor form
    initBloodGroupBtns('donor-bg-selector');

    // Show the home page on first load
    showPage('home');
});
