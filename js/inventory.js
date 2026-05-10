// ============================================================
//  inventory.js — Blood Inventory Loading & Card Rendering
// ============================================================

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
                <div style="height:6px;background:var(--red);width:${Math.min(100, i.stock_pct)}%;border-radius:4px;transition:.5s"></div>
            </div>
            <div style="font-size:11px;color:var(--gray-400);margin-top:5px">${i.stock_pct}% capacity</div>
        </div>
    `).join('');
}
