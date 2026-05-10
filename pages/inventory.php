<!-- ══════════════════════════════════════════════════════════
     PAGE: BLOOD INVENTORY
══════════════════════════════════════════════════════════ -->
<div id="page-inventory" class="page hidden">
    <div class="page-header">
        <h2>Blood Inventory</h2>
        <p>Real-time blood stock levels across all blood groups</p>
    </div>
    <div class="content-area">

        <!-- Inventory Cards -->
        <div id="inv-grid" style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:40px">
            <p class="text-muted">Loading inventory...</p>
        </div>

        <!-- Recent Donations Log -->
        <h3 style="margin-bottom:16px">Recent Donations Log</h3>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Donor</th>
                        <th>Blood Group</th>
                        <th>Units</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Md. Alamin</td>   <td><strong>A+</strong></td>  <td>1</td><td>2026-04-03</td><td><span class="pill pill-success">Completed</span></td></tr>
                    <tr><td>Sharmin Akter</td><td><strong>B+</strong></td>  <td>1</td><td>2026-04-02</td><td><span class="pill pill-success">Completed</span></td></tr>
                    <tr><td>Jahangir Alam</td><td><strong>O-</strong></td>  <td>1</td><td>2026-04-01</td><td><span class="pill pill-success">Completed</span></td></tr>
                    <tr><td>Ritu Begum</td>   <td><strong>A-</strong></td>  <td>1</td><td>2026-03-30</td><td><span class="pill pill-success">Completed</span></td></tr>
                    <tr><td>Tania Akter</td>  <td><strong>AB-</strong></td> <td>1</td><td>2026-03-28</td><td><span class="pill pill-success">Completed</span></td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
