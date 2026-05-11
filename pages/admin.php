<!-- ══════════════════════════════════════════════════════════
     PAGE: ADMIN DASHBOARD
══════════════════════════════════════════════════════════ -->
<div id="page-admin" class="page hidden">
    <div class="page-header">
        <h2>Admin Dashboard</h2>
        <p>Manage donors, blood requests and inventory</p>
    </div>
    <div class="content-area">
        <div style="display:grid;grid-template-columns:220px 1fr;min-height:580px;
                    border:1.5px solid var(--gray-200);border-radius:var(--radius-lg);
                    overflow:hidden;background:var(--white)">

            <!-- Sidebar -->
            <div style="background:var(--gray-50);border-right:1.5px solid var(--gray-200);padding:20px 0">
                <div style="font-size:11px;font-weight:700;color:var(--gray-400);
                            padding:0 20px 12px;text-transform:uppercase;letter-spacing:.6px">Management</div>
                <div class="admin-nav-item active" data-tab="overview"     onclick="switchAdminTab('overview')">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                    Overview
                </div>
                <div class="admin-nav-item" data-tab="donors"         onclick="switchAdminTab('donors')">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                    Donors
                </div>
                <div class="admin-nav-item" data-tab="requests"       onclick="switchAdminTab('requests')">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M20 6h-2.18c.07-.44.18-.88.18-1.35C18 2.06 15.94 0 13.35 0c-1.4 0-2.47.75-3.35 1.9C9.12.75 8.05 0 6.65 0 4.06 0 2 2.06 2 4.65c0 .47.11.91.18 1.35H0v2h20V6zm0 2H0v12a2 2 0 002 2h16a2 2 0 002-2V8z"/></svg>
                    Requests
                </div>
                <div class="admin-nav-item" data-tab="inventory-a"    onclick="switchAdminTab('inventory-a')">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z"/></svg>
                    Inventory
                </div>
                <div class="admin-nav-item" data-tab="reports"        onclick="switchAdminTab('reports')">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4zm2.5 2.1h-15V5h15v14.1zm0-16.1h-15C3.12 3 2 4.12 2 5.5v13C2 19.88 3.12 21 4.5 21h15c1.38 0 2.5-1.12 2.5-2.5v-13C22 4.12 20.88 3 19.5 3z"/></svg>
                    Reports
                </div>
            </div>

            <!-- Tab Content -->
            <div style="padding:28px;overflow:auto">

                <!-- Overview Tab -->
                <div id="tab-overview" class="admin-tab-content">
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:24px">
                        <div style="background:var(--gray-50);border-radius:10px;padding:18px;border:1px solid var(--gray-200)">
                            <div id="stat-donors" style="font-size:28px;font-weight:700;color:var(--red);font-family:var(--font-head)">—</div>
                            <div style="font-size:12px;color:var(--gray-400);text-transform:uppercase;letter-spacing:.4px;margin-top:3px">Total Donors</div>
                        </div>
                        <div style="background:var(--gray-50);border-radius:10px;padding:18px;border:1px solid var(--gray-200)">
                            <div id="stat-requests" style="font-size:28px;font-weight:700;color:var(--red);font-family:var(--font-head)">—</div>
                            <div style="font-size:12px;color:var(--gray-400);text-transform:uppercase;letter-spacing:.4px;margin-top:3px">Pending Requests</div>
                        </div>
                        <div style="background:var(--gray-50);border-radius:10px;padding:18px;border:1px solid var(--gray-200)">
                            <div id="stat-units" style="font-size:28px;font-weight:700;color:var(--red);font-family:var(--font-head)">—</div>
                            <div style="font-size:12px;color:var(--gray-400);text-transform:uppercase;letter-spacing:.4px;margin-top:3px">Total Units</div>
                        </div>
                    </div>
                    <div style="font-size:12px;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px">Recent Blood Requests</div>
                    <div class="table-wrap">
                        <table>
                            <thead><tr><th>Patient</th><th>Blood</th><th>Units</th><th>Hospital</th><th>Required By</th><th>Status</th><th>Action</th></tr></thead>
                            <tbody id="admin-req-tbody"><tr><td colspan="7" class="text-muted" style="padding:20px">Loading...</td></tr></tbody>
                        </table>
                    </div>
                </div>

                <!-- Donors Tab -->
                <div id="tab-donors" class="admin-tab-content hidden">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
                        <div style="font-size:12px;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.5px">Registered Donors</div>
                        <input type="text" placeholder="Search donors..." style="width:220px;padding:8px 12px;font-size:13px">
                    </div>
                    <div class="table-wrap">
                        <table>
                            <thead><tr><th>Name</th><th>Blood Group</th><th>City</th><th>Phone</th><th>Availability</th></tr></thead>
                            <tbody id="admin-donors-tbody"><tr><td colspan="5" class="text-muted" style="padding:20px">Loading...</td></tr></tbody>
                        </table>
                    </div>
                </div>

                <!-- Requests Tab -->
                <div id="tab-requests" class="admin-tab-content hidden">
                    <div style="font-size:12px;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px">All Blood Requests</div>
                    <div class="table-wrap">
                        <table>
                            <thead><tr><th>Patient</th><th>Blood</th><th>Hospital</th><th>Required By</th><th>Status</th><th>Action</th></tr></thead>
                            <tbody id="admin-req-tbody2">
                                <tr><td colspan="7" class="text-muted" style="padding:20px">Loading...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Inventory Admin Tab -->
                <div id="tab-inventory-a" class="admin-tab-content hidden">
                    <div style="font-size:12px;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.5px;margin-bottom:16px">Update Blood Inventory</div>
                    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px">
                        <div style="background:var(--gray-50);border:1.5px solid var(--gray-200);border-radius:10px;padding:16px;text-align:center">
                            <div style="font-weight:700;font-size:18px;font-family:var(--font-head)">A+</div>
                            <input type="number" value="45" style="width:80px;text-align:center;margin-top:8px">
                            <div style="font-size:11px;color:var(--gray-400);margin-top:4px">units</div>
                        </div>
                        <div style="background:var(--gray-50);border:1.5px solid var(--gray-200);border-radius:10px;padding:16px;text-align:center">
                            <div style="font-weight:700;font-size:18px;font-family:var(--font-head)">A−</div>
                            <input type="number" value="12" style="width:80px;text-align:center;margin-top:8px">
                            <div style="font-size:11px;color:var(--gray-400);margin-top:4px">units</div>
                        </div>
                        <div style="background:var(--gray-50);border:1.5px solid var(--gray-200);border-radius:10px;padding:16px;text-align:center">
                            <div style="font-weight:700;font-size:18px;font-family:var(--font-head)">B+</div>
                            <input type="number" value="38" style="width:80px;text-align:center;margin-top:8px">
                            <div style="font-size:11px;color:var(--gray-400);margin-top:4px">units</div>
                        </div>
                        <div style="background:var(--gray-50);border:1.5px solid var(--gray-200);border-radius:10px;padding:16px;text-align:center">
                            <div style="font-weight:700;font-size:18px;font-family:var(--font-head)">O+</div>
                            <input type="number" value="6" style="width:80px;text-align:center;margin-top:8px">
                            <div style="font-size:11px;color:var(--gray-400);margin-top:4px">units</div>
                        </div>
                    </div>
                    <button class="btn btn-primary mt-3" onclick="alert('Inventory updated! (Connect to DB to persist)')">Save Changes</button>
                </div>

                <!-- Reports Tab -->
                <div id="tab-reports" class="admin-tab-content hidden">
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:24px">
                        <div style="background:var(--gray-50);border-radius:10px;padding:18px;border:1px solid var(--gray-200)">
                            <div style="font-size:28px;font-weight:700;color:var(--red);font-family:var(--font-head)">248</div>
                            <div style="font-size:12px;color:var(--gray-400);text-transform:uppercase;letter-spacing:.4px;margin-top:3px">Donations This Month</div>
                        </div>
                        <div style="background:var(--gray-50);border-radius:10px;padding:18px;border:1px solid var(--gray-200)">
                            <div style="font-size:28px;font-weight:700;color:var(--red);font-family:var(--font-head)">186</div>
                            <div style="font-size:12px;color:var(--gray-400);text-transform:uppercase;letter-spacing:.4px;margin-top:3px">Requests Fulfilled</div>
                        </div>
                        <div style="background:var(--gray-50);border-radius:10px;padding:18px;border:1px solid var(--gray-200)">
                            <div style="font-size:28px;font-weight:700;color:var(--red);font-family:var(--font-head)">96%</div>
                            <div style="font-size:12px;color:var(--gray-400);text-transform:uppercase;letter-spacing:.4px;margin-top:3px">Fulfillment Rate</div>
                        </div>
                    </div>
                    <div style="font-size:12px;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px">Monthly Summary — April 2026</div>
                    <div class="table-wrap">
                        <table>
                            <thead><tr><th>Blood Group</th><th>Donations</th><th>Requests</th><th>Fulfilled</th><th>Stock Status</th></tr></thead>
                            <tbody>
                                <tr><td><strong>O+</strong></td>  <td>68</td><td>72</td><td>66</td><td><span class="pill pill-warning">Low</span></td></tr>
                                <tr><td><strong>A+</strong></td>  <td>55</td><td>48</td><td>48</td><td><span class="pill pill-success">OK</span></td></tr>
                                <tr><td><strong>B+</strong></td>  <td>42</td><td>38</td><td>38</td><td><span class="pill pill-success">OK</span></td></tr>
                                <tr><td><strong>AB-</strong></td> <td>8</td> <td>14</td><td>8</td> <td><span class="pill pill-danger">Critical</span></td></tr>
                                <tr><td><strong>O-</strong></td>  <td>15</td><td>18</td><td>14</td><td><span class="pill pill-danger">Critical</span></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div><!-- end tab content -->
        </div><!-- end admin grid -->
    </div>
</div>
