<!-- ══════════════════════════════════════════════════════════
     PAGE: FIND BLOOD / REQUEST
══════════════════════════════════════════════════════════ -->
<div id="page-request" class="page hidden">
    <div class="page-header">
        <h2>Find Blood / Request</h2>
        <p>Search for available donors and blood units near you</p>
    </div>
    <div class="content-area">

        <!-- Search Bar -->
        <div style="display:flex;gap:12px;margin-bottom:28px;flex-wrap:wrap">
            <select id="s-bg" style="min-width:150px">
                <option value="">All Blood Groups</option>
                <option>A+</option><option>A-</option><option>B+</option><option>B-</option>
                <option>AB+</option><option>AB-</option><option>O+</option><option>O-</option>
            </select>
            <input type="text" id="s-city" placeholder="Search by city or district..." style="flex:1;min-width:160px">
            <select id="s-avail" style="min-width:180px">
                <option value="">Any Availability</option>
                <option value="Available Now">Available Now</option>
                <option value="Available this Week">Available this Week</option>
            </select>
            <button class="btn btn-primary" onclick="searchDonors()">Search Donors</button>
        </div>

        <!-- Donor Cards Grid -->
        <div id="donor-results" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px;margin-bottom:48px">
            <p class="text-muted">Loading donors...</p>
        </div>

        <!-- Blood Request Form -->
        <div style="border-top:1.5px solid var(--gray-200);padding-top:40px">
            <h3 style="margin-bottom:6px">Submit a Blood Request</h3>
            <p style="margin-bottom:28px">Can't find a donor? Submit a formal request and we'll notify matching donors.</p>
            <div class="form-card" style="max-width:640px">
                <form id="request-form" onsubmit="submitBloodRequest(event)">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Patient Name *</label>
                            <input type="text" id="r-patient" placeholder="Full name" required>
                        </div>
                        <div class="form-group">
                            <label>Contact Number *</label>
                            <input type="tel" id="r-contact" placeholder="Phone number" required>
                        </div>
                        <div class="form-group">
                            <label>Blood Group Needed *</label>
                            <select id="r-bg" required>
                                <option value="">Select blood group</option>
                                <option>A+</option><option>A-</option><option>B+</option><option>B-</option>
                                <option>AB+</option><option>AB-</option><option>O+</option><option>O-</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Units Required *</label>
                            <input type="number" id="r-units" placeholder="Number of units" min="1" max="20" required>
                        </div>
                        <div class="form-group">
                            <label>Hospital / Location *</label>
                            <input type="text" id="r-hospital" placeholder="Hospital name and city" required>
                        </div>
                        <div class="form-group">
                            <label>Required By *</label>
                            <input type="date" id="r-date" required>
                        </div>
                        <div class="form-group full">
                            <label>Additional Notes</label>
                            <textarea id="r-notes" placeholder="Urgency level, patient condition, or other details..."></textarea>
                        </div>
                    </div>
                    <button type="submit" id="req-submit-btn" class="btn btn-primary mt-3" data-label="Submit Request">
                        Submit Request
                    </button>
                    <div id="req-alert" class="alert hidden"></div>
                </form>
            </div>
        </div>
    </div>
</div>
