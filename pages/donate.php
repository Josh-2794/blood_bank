<!-- ══════════════════════════════════════════════════════════
     PAGE: DONOR REGISTRATION
══════════════════════════════════════════════════════════ -->
<div id="page-donate" class="page hidden">
    <div class="page-header">
        <h2>Donor Registration</h2>
        <p>Register as a blood donor and help save lives in your community</p>
    </div>
    <div class="content-area">
        <div class="form-card">
            <form id="donor-form" onsubmit="submitDonorRegistration(event)">
                <div class="form-grid">
                    <div class="form-group">
                        <label>First Name *</label>
                        <input type="text" id="d-fname" placeholder="Enter first name" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name *</label>
                        <input type="text" id="d-lname" placeholder="Enter last name" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address *</label>
                        <input type="email" id="d-email" placeholder="your@email.com" required>
                    </div>
                    <div class="form-group">
                        <label>Phone Number *</label>
                        <input type="tel" id="d-phone" placeholder="+880 1XXX XXXXXX" required>
                    </div>
                    <div class="form-group">
                        <label>Date of Birth *</label>
                        <input type="date" id="d-dob" required>
                    </div>
                    <div class="form-group">
                        <label>Gender *</label>
                        <select id="d-gender" required>
                            <option value="">Select gender</option>
                            <option>Male</option>
                            <option>Female</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="form-group full">
                        <label>Blood Group *</label>
                        <div class="blood-group-selector" id="donor-bg-selector">
                            <button type="button" class="bg-btn" data-bg="A+">A+</button>
                            <button type="button" class="bg-btn" data-bg="A-">A−</button>
                            <button type="button" class="bg-btn" data-bg="B+">B+</button>
                            <button type="button" class="bg-btn" data-bg="B-">B−</button>
                            <button type="button" class="bg-btn" data-bg="AB+">AB+</button>
                            <button type="button" class="bg-btn" data-bg="AB-">AB−</button>
                            <button type="button" class="bg-btn" data-bg="O+">O+</button>
                            <button type="button" class="bg-btn" data-bg="O-">O−</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>City / District *</label>
                        <input type="text" id="d-city" placeholder="Dhaka, Chittagong..." required>
                    </div>
                    <div class="form-group">
                        <label>Weight (kg)</label>
                        <input type="number" id="d-weight" placeholder="Minimum 50 kg" min="50" max="200">
                    </div>
                    <div class="form-group">
                        <label>Last Donation Date</label>
                        <input type="date" id="d-lastdon">
                    </div>
                    <div class="form-group">
                        <label>Availability</label>
                        <select id="d-avail">
                            <option>Available Now</option>
                            <option>Available this Week</option>
                            <option>Not Available</option>
                        </select>
                    </div>
                    <div class="form-group full">
                        <label>Medical Notes (Optional)</label>
                        <textarea id="d-notes" placeholder="Any medical conditions, medications, or relevant health information..."></textarea>
                    </div>
                </div>
                <button type="submit" id="donor-submit-btn" class="btn btn-primary mt-3" data-label="Register as Donor">
                    Register as Donor
                </button>
                <div id="donor-alert" class="alert hidden"></div>
            </form>
        </div>
    </div>
</div>
