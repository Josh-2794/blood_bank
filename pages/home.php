<!-- ══════════════════════════════════════════════════════════
     PAGE: HOME
══════════════════════════════════════════════════════════ -->
<div id="page-home" class="page active">

    <!-- Hero -->
    <section style="background:linear-gradient(135deg,#fff8f8 0%,#fdecea 100%);padding:80px 48px 70px;
                    display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center">
        <div>
            <div style="display:inline-flex;align-items:center;gap:8px;background:#fce4e4;color:var(--red-dark);
                        font-size:12px;font-weight:700;padding:5px 14px;border-radius:999px;
                        letter-spacing:.6px;text-transform:uppercase;margin-bottom:20px">
                <span class="pulse" style="width:7px;height:7px;background:var(--red);border-radius:50%;display:inline-block"></span>
                Saving Lives Every Day
            </div>
            <h1 style="margin-bottom:16px">
                Donate Blood,<br>
                <span style="color:var(--red)">Give Hope</span><br>
                &amp; Save Lives
            </h1>
            <p style="font-size:16px;margin-bottom:32px;max-width:460px">
                LifeFlow connects blood donors with patients in need. Every donation counts.
                Be the reason someone gets to see tomorrow.
            </p>
            <div style="display:flex;gap:12px;flex-wrap:wrap">
                <button class="btn btn-primary" onclick="showPage('donate')">Register as Donor</button>
                <button class="btn btn-outline" onclick="showPage('request')">Request Blood</button>
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
            <div class="card" style="text-align:center;background:var(--red);border-color:var(--red)">
                <div style="font-family:var(--font-head);font-size:30px;color:white;font-weight:700">12,400+</div>
                <div style="font-size:12px;color:#ffb3ae;text-transform:uppercase;letter-spacing:.5px;margin-top:3px">Total Donors</div>
            </div>
            <div class="card" style="text-align:center">
                <div style="font-family:var(--font-head);font-size:30px;color:var(--red);font-weight:700">8</div>
                <div style="font-size:12px;color:var(--gray-400);text-transform:uppercase;letter-spacing:.5px;margin-top:3px">Blood Types</div>
            </div>
            <div class="card" style="text-align:center">
                <div style="font-family:var(--font-head);font-size:30px;color:var(--red);font-weight:700">3,200</div>
                <div style="font-size:12px;color:var(--gray-400);text-transform:uppercase;letter-spacing:.5px;margin-top:3px">Lives Saved</div>
            </div>
            <div class="card" style="text-align:center">
                <div style="font-family:var(--font-head);font-size:30px;color:var(--red);font-weight:700">24/7</div>
                <div style="font-size:12px;color:var(--gray-400);text-transform:uppercase;letter-spacing:.5px;margin-top:3px">Emergency Ready</div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section style="padding:70px 48px">
        <div class="section-title">Everything You Need</div>
        <div class="section-sub">A complete blood bank management platform for donors, patients and administrators</div>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px">

            <div class="card" style="cursor:pointer" onclick="showPage('donate')">
                <div style="width:46px;height:46px;background:var(--red-light);border-radius:10px;
                            display:flex;align-items:center;justify-content:center;margin-bottom:14px">
                    <svg width="22" height="22" fill="var(--red)" viewBox="0 0 24 24"><path d="M12 2C8.5 2 4 7.5 4 13a8 8 0 0016 0c0-5.5-4.5-11-8-11z"/></svg>
                </div>
                <h4 style="margin-bottom:6px">Donor Registration</h4>
                <p style="font-size:13px">Register with your blood group, contact details, and availability status easily.</p>
            </div>

            <div class="card" style="cursor:pointer" onclick="showPage('request')">
                <div style="width:46px;height:46px;background:var(--red-light);border-radius:10px;
                            display:flex;align-items:center;justify-content:center;margin-bottom:14px">
                    <svg width="22" height="22" fill="var(--red)" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27A6.47 6.47 0 0016 9.5a6.5 6.5 0 10-6.5 6.5c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0A4.5 4.5 0 115 9.5 4.5 4.5 0 019.5 14z"/></svg>
                </div>
                <h4 style="margin-bottom:6px">Find Blood</h4>
                <p style="font-size:13px">Search available donors and blood units by blood group, location and availability.</p>
            </div>

            <div class="card" style="cursor:pointer" onclick="showPage('inventory')">
                <div style="width:46px;height:46px;background:var(--red-light);border-radius:10px;
                            display:flex;align-items:center;justify-content:center;margin-bottom:14px">
                    <svg width="22" height="22" fill="var(--red)" viewBox="0 0 24 24"><path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zm-7 3a4 4 0 110 8 4 4 0 010-8zm-7 13c0-2.7 4.7-4 7-4s7 1.3 7 4H5z"/></svg>
                </div>
                <h4 style="margin-bottom:6px">Blood Inventory</h4>
                <p style="font-size:13px">Real-time blood stock levels with alerts for critical and low inventory.</p>
            </div>

            <div class="card" style="cursor:pointer" onclick="showPage('admin')">
                <div style="width:46px;height:46px;background:var(--red-light);border-radius:10px;
                            display:flex;align-items:center;justify-content:center;margin-bottom:14px">
                    <svg width="22" height="22" fill="var(--red)" viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                </div>
                <h4 style="margin-bottom:6px">Admin Dashboard</h4>
                <p style="font-size:13px">Manage donors, requests and inventory from a centralized admin panel.</p>
            </div>

            <div class="card">
                <div style="width:46px;height:46px;background:var(--red-light);border-radius:10px;
                            display:flex;align-items:center;justify-content:center;margin-bottom:14px">
                    <svg width="22" height="22" fill="var(--red)" viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                </div>
                <h4 style="margin-bottom:6px">Emergency Alerts</h4>
                <p style="font-size:13px">Instant notifications for critical blood shortage to matching donors.</p>
            </div>

            <div class="card" style="cursor:pointer" onclick="showPage('about')">
                <div style="width:46px;height:46px;background:var(--red-light);border-radius:10px;
                            display:flex;align-items:center;justify-content:center;margin-bottom:14px">
                    <svg width="22" height="22" fill="var(--red)" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                </div>
                <h4 style="margin-bottom:6px">Contact &amp; Support</h4>
                <p style="font-size:13px">24/7 helpline and support for urgent requirements and donation inquiries.</p>
            </div>

        </div>
    </section>
</div>
