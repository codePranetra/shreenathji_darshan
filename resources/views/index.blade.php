@extends('layouts.app')

@section('meta-tags')
    <!-- Meta Tags for SEO -->
    <meta name="description" content="Welcome to the Home Page of My Laravel Application.">
    <meta name="keywords" content="home, Laravel, Blade template, web development">
    <meta name="author" content="Your Name">
    <meta property="og:title" content="Home Page - Laravel App">
    <meta property="og:description" content="Welcome to the Home Page of My Laravel Application.">
    <meta property="og:image" content="URL_to_an_image.jpg">
    <meta property="og:url" content="{{ url()->current() }}">
    {{-- <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Home Page - Laravel App">
    <meta name="twitter:description" content="Welcome to the Home Page of My Laravel Application.">
    <meta name="twitter:image" content="URL_to_an_image.jpg"> --}}
@endsection

@section('css')
    <!-- Custom CSS (if needed for this page) -->
    <style>
       
    </style>
@endsection

@section('content')
       <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-background">
            <div class="pichwai-pattern"></div>
        </div>
        <div class="hero-content">
            <div class="hero-text">
                <h1>Shree ji Seva</h1>
                <p>बोल श्री गिरिराज  धरण की जय,
                    बोल श्री राधे ,
                    पूछड़ी के लोटा की हूप हूप  प्यारे</p>
                <button class="cta-button" onclick="scrollToSection('packages')">
                    <svg class="cta-icon" width="20" height="20" viewBox="0 0 20 20">
                        <path d="M 10 2 L 10 18 M 2 10 L 18 10" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    Seva packages
                </button>
            </div>
            <div class="hero-visual">
                <div class="hero-timings">
                    <div class="hero-timings-header">
                        <svg width="20" height="20" viewBox="0 0 20 20" aria-hidden="true">
                            <circle cx="10" cy="10" r="8" fill="none" stroke="#1B3C5D" stroke-width="2" />
                            <path d="M 10 6 L 10 10 L 13 10" stroke="#E37CA6" stroke-width="2" fill="none" />
                        </svg>
                        <span id="heroTimingsDate">आज के दर्शन समय</span>
                    </div>
                    <ul class="hero-timings-list" id="heroTimingsList">
                        <li><span class="t-time">06:00 AM</span><span class="t-label">मंगला दर्शन</span></li>
                        <li><span class="t-time">07:30 AM</span><span class="t-label">श्रृंगार दर्शन</span></li>
                        <li><span class="t-time">09:15 AM</span><span class="t-label">ग्वाल दर्शन</span></li>
                        <li><span class="t-time">11:15 AM</span><span class="t-label">राजभोग दर्शन</span></li>
                        <li><span class="t-time">03:45 PM</span><span class="t-label">उत्थापन दर्शन</span></li>
                        <li><span class="t-time">04:45 PM</span><span class="t-label">भोग दर्शन</span></li>
                        <li><span class="t-time">05:15 PM</span><span class="t-label">आरती</span></li>
                        <li><span class="t-time">-</span><span class="t-label">शयन दर्शन नहीं खुलेंगे</span></li>
                    </ul>
                    <a href="#timings" class="hero-timings-link">Full schedule</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Pichwai Section Divider -->
    <div class="section-divider">
        <svg width="100%" height="60" viewBox="0 0 400 60">
            <path d="M 0 30 Q 50 10 100 30 Q 150 50 200 30 Q 250 10 300 30 Q 350 50 400 30" stroke="#FFD700" stroke-width="2" fill="none"/>
            <circle cx="200" cy="30" r="8" fill="#FFD700"/>
        </svg>
    </div>

     <!-- Packages Section -->
    <section id="packages" class="packages">
        <div class="container">
            <h2>वैष्णवसेवायां सदा तत्परः</h2>
            <div class="packages-grid" id="packagesGrid">
                <!-- Packages will be populated dynamically -->
                <div class="package-card">
                    <div class="package-header">
                        <h3>Loading...</h3>
                    </div>
                    <div class="package-content">
                        <p>Please wait</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pichwai Section Divider -->
    <div class="section-divider">
        <svg width="100%" height="60" viewBox="0 0 400 60">
            <path d="M 0 30 Q 50 10 100 30 Q 150 50 200 30 Q 250 10 300 30 Q 350 50 400 30" stroke="#E37CA6" stroke-width="2" fill="none"/>
            <circle cx="200" cy="30" r="8" fill="#E37CA6"/>
        </svg>
    </div>

    <!-- Darshan Timing Section -->
    <section id="timings" class="timings">
        <div class="container">
            <h2 id="timingsHeading">Darshan Timings</h2>
            <div class="timing-content">
                <div class="timing-icon">
                    <svg width="80" height="80" viewBox="0 0 80 80">
                        <circle cx="40" cy="40" r="35" fill="none" stroke="#1B3C5D" stroke-width="3"/>
                        <path d="M 40 20 L 40 40 L 55 40" stroke="#FFD700" stroke-width="3" fill="none"/>
                        <circle cx="40" cy="40" r="3" fill="#FFD700"/>
                    </svg>
                </div>
                <div class="timing-slots" id="timingSlots">
                    <!-- Timing slots will be populated dynamically -->
                    <div class="timing-slot">
                        <span class="time">Loading...</span>
                        <span class="description">Please wait</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pichwai Section Divider -->
    <div class="section-divider">
        <svg width="100%" height="60" viewBox="0 0 400 60">
            <path d="M 0 30 Q 50 10 100 30 Q 150 50 200 30 Q 250 10 300 30 Q 350 50 400 30" stroke="#FFD700" stroke-width="2" fill="none"/>
            <circle cx="200" cy="30" r="8" fill="#FFD700"/>
        </svg>
    </div>

    <!-- Booking Form Section -->
    <!-- <section id="booking" class="booking">
        <div class="container">
            <h2>Book Your Darshan</h2>
            <div class="booking-form-container">
                <form id="bookingForm" class="booking-form">
                    <div class="form-group">
                        <label for="name">
                            <svg class="form-icon" width="20" height="20" viewBox="0 0 20 20">
                                <circle cx="10" cy="6" r="3" fill="none" stroke="#1B3C5D" stroke-width="2" />
                                <path d="M 3 18 C 3 14 6 11 10 11 C 14 11 17 14 17 18" fill="none" stroke="#1B3C5D"
                                    stroke-width="2" />
                            </svg>
                            Full Name *
                        </label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="mobile">
                            <svg class="form-icon" width="20" height="20" viewBox="0 0 20 20">
                                <rect x="4" y="2" width="12" height="16" rx="2" fill="none" stroke="#1B3C5D"
                                    stroke-width="2" />
                                <circle cx="10" cy="14" r="1" fill="#1B3C5D" />
                            </svg>
                            Mobile Number *
                        </label>
                        <input type="tel" id="mobile" name="mobile" required pattern="[0-9]{10,15}" title="Please enter a valid mobile number (10-15 digits)" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    </div>
                    <div class="form-group">
                        <label for="date">
                            <svg class="form-icon" width="20" height="20" viewBox="0 0 20 20">
                                <rect x="3" y="4" width="14" height="14" rx="2" fill="none" stroke="#1B3C5D"
                                    stroke-width="2" />
                                <path d="M 3 8 L 17 8" stroke="#1B3C5D" stroke-width="2" />
                                <circle cx="7" cy="11" r="1" fill="#1B3C5D" />
                                <circle cx="10" cy="11" r="1" fill="#1B3C5D" />
                                <circle cx="13" cy="11" r="1" fill="#1B3C5D" />
                                <circle cx="7" cy="14" r="1" fill="#1B3C5D" />
                                <circle cx="10" cy="14" r="1" fill="#1B3C5D" />
                                <circle cx="13" cy="14" r="1" fill="#1B3C5D" />
                            </svg>
                            Darshan Date *
                        </label>
                        <input type="date" id="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="time">
                            <svg class="form-icon" width="20" height="20" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="8" fill="none" stroke="#1B3C5D" stroke-width="2" />
                                <path d="M 10 6 L 10 10 L 13 10" stroke="#1B3C5D" stroke-width="2" fill="none" />
                            </svg>
                            Preferred Time *
                        </label>
                        <select id="time" name="time" required>
                            <option value="">Select Time</option>
                            <!-- Time options will be populated dynamically from API -->
                        <!-- </select>
                    </div>
                    <div class="form-group">
                        <label for="package">
                            <svg class="form-icon" width="20" height="20" viewBox="0 0 20 20">
                                <rect x="3" y="3" width="14" height="14" rx="2" fill="none" stroke="#1B3C5D"
                                    stroke-width="2" />
                                <path d="M 7 7 L 13 7 M 7 10 L 13 10 M 7 13 L 13 13" stroke="#1B3C5D"
                                    stroke-width="2" />
                            </svg>
                            Selected Package *
                        </label>
                        <select id="package" name="package" required>
                            <option value="">Select a Package</option> -->
                            <!-- Package options will be populated dynamically -->
                        <!-- </select>
                    </div>
                    <div class="form-group">
                        <label for="guests">
                            <svg class="form-icon" width="20" height="20" viewBox="0 0 20 20">
                                <circle cx="10" cy="6" r="3" fill="none" stroke="#1B3C5D" stroke-width="2" />
                                <path d="M 3 18 C 3 14 6 11 10 11 C 14 11 17 14 17 18" fill="none" stroke="#1B3C5D"
                                    stroke-width="2" />
                                <circle cx="7" cy="8" r="2" fill="none" stroke="#1B3C5D" stroke-width="1" />
                                <circle cx="13" cy="8" r="2" fill="none" stroke="#1B3C5D" stroke-width="1" />
                            </svg>
                            Number of Guests
                        </label>
                        <input type="number" id="guests" name="guests" min="1" max="50" value="1">
                    </div>
                    <div class="form-group booking-buttons">
                        <button type="submit" class="submit-btn">
                            <svg class="whatsapp-icon" width="20" height="20" viewBox="0 0 20 20">
                                <path
                                    d="M 10 2 C 5.6 2 2 5.6 2 10 C 2 12.4 3 14.6 4.6 16.2 L 2 18 L 3.8 15.4 C 5.4 17 7.6 18 10 18 C 14.4 18 18 14.4 18 10 C 18 5.6 14.4 2 10 2 Z"
                                    fill="none" stroke="currentColor" stroke-width="2" />
                                <path d="M 7 8 L 13 8 M 7 11 L 11 11" stroke="currentColor" stroke-width="2" fill="none" />
                            </svg>
                            Submit Booking
                        </button>
                        <button type="button" class="advance-payment-btn" id="advancePaymentButton">
                            <svg class="payment-icon" width="20" height="20" viewBox="0 0 20 20">
                                <path d="M 2 6 L 18 6 L 18 14 L 2 14 Z" fill="none" stroke="currentColor" stroke-width="2"/>
                                <path d="M 6 10 L 8 8 L 11 11 L 14 9" stroke="currentColor" stroke-width="2" fill="none"/>
                            </svg>
                            Advance Payment
                        </button>
                    </div>
                </form>
            </div>
        </div> -->
    <!-- </section>  -->

    <!-- About Section -->
    <section id="about" class="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>About Shreenath Ji</h2>
                    <p>“Balihaaran balihar jai sarkar Shreeji saany karenge Goverdhan Nath<br>
                        Jai ho bansi wale, khama Brij Raaj khama 🙏🏻🙏🏻”</p>
                    <p>“Badi mauj hai tere darbar me, chakachak hai<br>
                        Chakra Sudarshan dhari, tera bharosa bhari<br>
                        Bade sharan Girdhari, rakho laaj hamari — beth Giriraj shikhar pe, khabar lo hamari”</p>
                    <p>“Mathe pe tera har nakhra — le aagye tere gaiyan ke bachra<br>
                        Le aagye tere bachra”</p>
                    <div class="about-features">
                        <div class="feature">
                            <svg class="feature-icon" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M 12 2 L 12 22 M 8 6 L 16 6" stroke="#FFD700" stroke-width="2" fill="none" />
                                <circle cx="12" cy="12" r="6" fill="none" stroke="#FFD700" stroke-width="2" />
                            </svg>
                            <span>Traditional Pichwai Art</span>
                        </div>
                        <div class="feature">
                            <svg class="feature-icon" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M 12 2 L 12 22 M 8 6 L 16 6" stroke="#FFD700" stroke-width="2" fill="none" />
                                <circle cx="12" cy="12" r="6" fill="none" stroke="#FFD700" stroke-width="2" />
                            </svg>
                            <span>Sacred Darshan Experience</span>
                        </div>
                        <div class="feature">
                            <svg class="feature-icon" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M 12 2 L 12 22 M 8 6 L 16 6" stroke="#FFD700" stroke-width="2" fill="none" />
                                <circle cx="12" cy="12" r="6" fill="none" stroke="#FFD700" stroke-width="2" />
                            </svg>
                            <span>Divine Blessings</span>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <img src="images/shrinathji-or-lord-krishna-as-pichwai-folk-painting-vector (1).jpg"
                        alt="Shrinathji Pichwai Art"
                        style="max-width:60%;height:auto;display:block;margin:0 auto 18px auto;border-radius:16px;box-shadow:0 4px 24px rgba(27,60,93,0.08);">

                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <div class="container">
            <h2>Contact Us</h2>
            <div class="contact-content">
                <div class="contact-info">
                    <div class="contact-item">
                        <svg class="contact-icon" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M 12 2 C 4.1 2 1 5.1 1 9 C 1 10.9 1.8 12.6 3.1 13.9 L 1 15 L 2.1 13.9 C 3.4 15.2 5.1 16 7 16 C 10.9 16 14 12.9 14 9 C 14 5.1 10.9 2 8 2 Z" fill="none" stroke="#1B3C5D" stroke-width="2"/>
                            <path d="M 8 12 L 11 15 L 16 10" stroke="#FFD700" stroke-width="2" fill="none"/>
                        </svg>
                        <div>
                            <h3>WhatsApp</h3>
                            <p>+91 93766 95545</p>
                            <a href="https://wa.me/919376695545" class="whatsapp-btn" target="_blank">
                                <svg class="whatsapp-icon" width="16" height="16" viewBox="0 0 16 16">
                                    <path d="M 8 2 C 4.1 2 1 5.1 1 9 C 1 10.9 1.8 12.6 3.1 13.9 L 1 15 L 2.1 13.9 C 3.4 15.2 5.1 16 7 16 C 10.9 16 14 12.9 14 9 C 14 5.1 10.9 2 8 2 Z" fill="none" stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M 6 7 L 10 7 M 6 9 L 8 9" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                </svg>
                                Send Message
                            </a>
                        </div>
                    </div>
                    <div class="contact-item">
                        <svg class="contact-icon" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M 12 2 C 8.1 2 5 5.1 5 9 C 5 14.2 12 22 12 22 S 19 14.2 19 9 C 19 5.1 15.9 2 12 2 Z" fill="none" stroke="#1B3C5D" stroke-width="2"/>
                            <circle cx="12" cy="9" r="3" fill="none" stroke="#FFD700" stroke-width="2"/>
                        </svg>
                        <div>
                            <h3>Location</h3>
                            <p>Nathdwara, Rajasthan, India</p>
                            <a href="https://maps.google.com/?q=Nathdwara,Rajasthan" class="map-btn" target="_blank">
                                <svg class="map-icon" width="16" height="16" viewBox="0 0 16 16">
                                    <path d="M 8 2 C 5.4 2 3 4.4 3 7 C 3 11.5 8 15 8 15 S 13 11.5 13 7 C 13 4.4 10.6 2 8 2 Z" fill="none" stroke="currentColor" stroke-width="1.5"/>
                                    <circle cx="8" cy="7" r="2" fill="none" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                                View on Map
                            </a>
                        </div>
                    </div>
                    <div class="contact-item">
                        <svg class="contact-icon" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M 2 6 L 12 12 L 22 6 M 2 6 L 2 18 C 2 19.1 2.9 20 4 20 L 20 20 C 21.1 20 22 19.1 22 18 L 22 6 M 2 6 L 14 6 M 2 6 L 12 12 M 22 6 L 12 12" fill="none" stroke="#1B3C5D" stroke-width="2"/>
                            <circle cx="12" cy="9" r="3" fill="none" stroke="#007bff" stroke-width="2"/>
                        </svg>
                        <div>
                            <h3>Email</h3>
                            <p>Shreejikdarshan@gmail.com</p>
                            <a href="mailto:Shreejikdarshan@gmail.com" class="email-btn" target="_blank">
                                <svg class="email-icon" width="16" height="16" viewBox="0 0 16 16">
                                    <path d="M 2 4 L 8 8 L 14 4 M 2 4 L 2 12 C 2 13.1 2.9 14 4 14 L 12 14 C 13.1 14 14 13.1 14 12 L 14 4 M 2 4 L 14 4" fill="none" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                                Send Email
                            </a>
                        </div>
                    </div>
                </div>
                <div class="contact-form">
                    <h3>Send us a Message</h3>
                    <form id="contactForm">
                        <div class="form-group">
                            <label for="contactName">Name</label>
                            <input type="text" id="contactName" name="contactName" required>
                        </div>
                        <div class="form-group">
                            <label for="contactEmail">Email</label>
                            <input type="email" id="contactEmail" name="contactEmail" required>
                        </div>
                        <div class="form-group">
                            <label for="contactMessage">Message</label>
                            <textarea id="contactMessage" name="contactMessage" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="submit-btn">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Booking Confirmed!</h2>
                <span class="close" onclick="closeSuccessModal()">&times;</span>
            </div>
            <div class="modal-body">
                <div class="success-icon">
                    <svg width="60" height="60" viewBox="0 0 60 60">
                        <circle cx="30" cy="30" r="25" fill="none" stroke="#4CAF50" stroke-width="3"/>
                        <path d="M 20 30 L 27 37 L 40 24" stroke="#4CAF50" stroke-width="3" fill="none"/>
                    </svg>
                </div>
                <p>Your darshan booking has been successfully confirmed!</p>
                <p>We will send you a confirmation message on WhatsApp shortly.</p>
                <button class="whatsapp-btn" onclick="sendWhatsAppMessage()">
                    <svg class="whatsapp-icon" width="20" height="20" viewBox="0 0 20 20">
                        <path d="M 10 2 C 5.6 2 2 5.6 2 10 C 2 12.4 3 14.6 4.6 16.2 L 2 18 L 3.8 15.4 C 5.4 17 7.6 18 10 18 C 14.4 18 18 14.4 18 10 C 18 5.6 14.4 2 10 2 Z" fill="none" stroke="currentColor" stroke-width="2"/>
                        <path d="M 7 8 L 13 8 M 7 11 L 11 11" stroke="currentColor" stroke-width="2" fill="none"/>
                    </svg>
                    Send WhatsApp Confirmation
                </button>
            </div>
        </div>
    </div>

    <!-- QR Code Modal -->
    <div id="qrCodeModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Scan QR Code for Payment</h2>
                <span class="close" onclick="closeQrCodeModal()">&times;</span>
            </div>
            <div class="modal-body text-center">
                <p>Scan the QR code below to make your advance payment:</p>
                <img id="qrCodeImage" src="" alt="QR Code for Payment" style="max-width: 300px; height: auto; margin: 20px auto; display: block;">
                
                <button class="submit-btn" onclick="closeQrCodeModal()">Close</button>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // Function to convert 24-hour time to 12-hour format with AM/PM
        function convertTo12HourFormat(time24) {
            const [hours, minutes] = time24.split(':');
            let hoursInt = parseInt(hours);
            const ampm = hoursInt >= 12 ? 'PM' : 'AM';
            hoursInt = hoursInt % 12 || 12; // Convert 0 to 12
            return `${hoursInt}:${minutes} ${ampm}`;
        }
        
        // Function to format current date as DD/MM/YYYY
        function getCurrentDateFormatted() {
            const now = new Date();
            const day = String(now.getDate()).padStart(2, '0');
            const month = String(now.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
            const year = now.getFullYear();
            return `${day}/${month}/${year}`;
        }
        
        // Function to update the timings heading with current date
        function updateTimingsHeading() {
            const heading = document.getElementById('timingsHeading');
            const currentDate = getCurrentDateFormatted();
            heading.textContent = `Darshan Timings (${currentDate})`;
        }
        
        // Function to update the hero timings date
        function updateHeroTimingsDate() {
            const heroDateSpan = document.getElementById('heroTimingsDate');
            const currentDate = getCurrentDateFormatted();
            heroDateSpan.textContent = `आज के दर्शन समय (${currentDate})`;
        }
        
        // Function to format description with bullet points
        function formatDescriptionAsBulletPoints(description) {
            if (!description) return '';
            
            // Split by newlines and filter out empty lines
            const lines = description.split('\n').filter(line => line.trim() !== '');
            
            // If no lines or only one line, return as is
            if (lines.length <= 1) return description;
            
            // Format as bullet points
            return '<ul>' + lines.map(line => `<li>${line.trim()}</li>`).join('') + '</ul>';
        }

        // Function to fetch packages from API and populate the select dropdown
        async function fetchPackagesForBooking() {
            try {
                const response = await fetch('/api/package');
                const result = await response.json();
                
                // Get the package select element
                const packageSelect = document.getElementById('package');
                
                // Clear existing options except the first one
                packageSelect.innerHTML = '<option value="">Select a Package</option>';
                
                // Check if we have packages data
                if (result && result.data && result.data.length > 0) {
                    // Add packages to the select dropdown
                    result.data.forEach(packageItem => {
                        const option = document.createElement('option');
                        option.value = packageItem.id;
                        option.textContent = `${packageItem.name} - ₹${parseFloat(packageItem.price).toFixed(0)}`;
                        packageSelect.appendChild(option);
                    });
                }
            } catch (error) {
                console.error('Error fetching packages for booking:', error);
            }
        }

        // Function to fetch packages from API for display
        async function fetchPackages() {
            try {
                const response = await fetch('/api/package');
                const result = await response.json();
                
                // Get the packages grid container
                const packagesGrid = document.getElementById('packagesGrid');
                
                // Clear the loading message
                packagesGrid.innerHTML = '';
                
                // Check if we have packages data
                if (result && result.data && result.data.length > 0) {
                    // Display all packages
                    result.data.forEach(packageItem => {
                        const packageCard = document.createElement('div');
                        packageCard.className = 'package-card';
                        packageCard.innerHTML = `
                            <div class="package-header">
                                <h3>${packageItem.name}</h3>
                                <div class="package-price">₹${parseFloat(packageItem.price).toFixed(0)} <small>per person</small></div>
                            </div>
                            <div class="package-content">
                                ${formatDescriptionAsBulletPoints(packageItem.description)}
                            </div>
                            <div class="package-buttons">
                                <button class="book-btn" onclick="selectPackage(${packageItem.id})">Book Now</button>
                                <a href="tel:+9193766 95545" class="call-btn">
                                    <svg class="call-icon" width="16" height="16" viewBox="0 0 16 16">
                                        <path d="M 3 6 C 3 2 6 1 9 2 C 12 3 14 5 13 8 C 12 11 10 12 7 11 C 4 10 2 8 3 6 Z" fill="none" stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M 8 4 L 8 7 L 11 7" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                    </svg>
                                    Call Now
                                </a>
                            </div>
                        `;
                        packagesGrid.appendChild(packageCard);
                    });
                } else {
                    // Show no packages message
                    packagesGrid.innerHTML = `
                        <div class="package-card">
                            <div class="package-header">
                                <h3>No Packages Available</h3>
                            </div>
                            <div class="package-content">
                                <p>Please check back later</p>
                            </div>
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Error fetching packages:', error);
                // Show error message
                const packagesGrid = document.getElementById('packagesGrid');
                packagesGrid.innerHTML = `
                    <div class="package-card">
                        <div class="package-header">
                            <h3>Error Loading Packages</h3>
                        </div>
                        <div class="package-content">
                            <p>Failed to load packages. Please try again later.</p>
                        </div>
                    </div>
                `;
            }
        }
        
        // Function to fetch darshan timings from API
        async function fetchDarshanTimings() {
            try {
                const response = await fetch('/api/darshantiming');
                const result = await response.json();
                
                // Get the timing slots container
                const timingSlotsContainer = document.getElementById('timingSlots');
                
                // Clear the loading message
                timingSlotsContainer.innerHTML = '';
                
                // Check if we have timings data
                if (result && result.data && result.data.length > 0) {
                    // Display all timings
                    result.data.forEach(timing => {
                        // Extract just the time part (HH:MM) from the datetime string
                        const timePart24 = timing.time.split(' ')[1].substring(0, 5);
                        
                        // Convert to 12-hour format
                        const timePart12 = convertTo12HourFormat(timePart24);
                        
                        const timingSlot = document.createElement('div');
                        timingSlot.className = 'timing-slot';
                        timingSlot.innerHTML = `
                            <span class="time">${timePart12}</span>
                            <span class="description">${timing.title}</span>
                        `;
                        timingSlotsContainer.appendChild(timingSlot);
                    });
                } else {
                    // Show no timings message
                    timingSlotsContainer.innerHTML = `
                        <div class="timing-slot">
                            <span class="time">-</span>
                            <span class="description">No timings available</span>
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Error fetching darshan timings:', error);
                // Show error message
                const timingSlotsContainer = document.getElementById('timingSlots');
                timingSlotsContainer.innerHTML = `
                    <div class="timing-slot">
                        <span class="time">Error</span>
                        <span class="description">Failed to load timings</span>
                    </div>
                `;
            }
        }
        
        // Function to fetch darshan timings for hero section
        async function fetchHeroTimings() {
            try {
                const response = await fetch('/api/darshantiming');
                const result = await response.json();
                
                // Get the hero timings list container
                const heroTimingsList = document.getElementById('heroTimingsList');
                
                // Clear the existing timings
                heroTimingsList.innerHTML = '';
                
                // Check if we have timings data
                if (result && result.data && result.data.length > 0) {
                    // Display all timings
                    result.data.forEach(timing => {
                        // Extract just the time part (HH:MM) from the datetime string
                        const timePart24 = timing.time.split(' ')[1].substring(0, 5);
                        
                        // Convert to 12-hour format
                        const timePart12 = convertTo12HourFormat(timePart24);
                        
                        const timingItem = document.createElement('li');
                        timingItem.innerHTML = `
                            <span class="t-time">${timePart12}</span>
                            <span class="t-label">${timing.title}</span>
                        `;
                        heroTimingsList.appendChild(timingItem);
                    });
                } else {
                    // Show no timings message
                    heroTimingsList.innerHTML = `
                        <li><span class="t-time">-</span><span class="t-label">No timings available</span></li>
                    `;
                }
            } catch (error) {
                console.error('Error fetching hero darshan timings:', error);
                // Keep the default timings in case of error
            }
        }
        
        // Function to fetch darshan timings for the Preferred Time select field
        async function fetchPreferredTimeOptions() {
            try {
                const response = await fetch('/api/darshantiming');
                const result = await response.json();
                
                // Get the time select element
                const timeSelect = document.getElementById('time');
                
                // Clear existing options except the first one
                timeSelect.innerHTML = '<option value="">Select Time</option>';
                
                // Check if we have timings data
                if (result && result.data && result.data.length > 0) {
                    // Add timings to the select dropdown
                    result.data.forEach(timing => {
                        // Extract just the time part (HH:MM) from the datetime string
                        const timePart24 = timing.time.split(' ')[1].substring(0, 5);
                        
                        // Convert to 12-hour format
                        const timePart12 = convertTo12HourFormat(timePart24);
                        
                        const option = document.createElement('option');
                        option.value = timePart24;
                        option.textContent = `${timePart12} - ${timing.title}`;
                        timeSelect.appendChild(option);
                    });
                }
            } catch (error) {
                console.error('Error fetching preferred time options:', error);
            }
        }
        
        // Function to handle form submission
        async function submitBookingForm(event) {
            event.preventDefault();
            
            // Get form data
            const formData = new FormData(event.target);
            const bookingData = {
                name: formData.get('name'),
                mobile: formData.get('mobile'),
                date: formData.get('date'),
                time: formData.get('time'),
                package_id: formData.get('package'),
                guests: formData.get('guests')
            };
            
            // Show loading message
            const submitButton = event.target.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            submitButton.innerHTML = 'Submitting...';
            submitButton.disabled = true;
            
            try {
                // Submit booking data to API
                const response = await fetch('/api/booking', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(bookingData)
                });
                
                const result = await response.json();
                
                if (response.ok) {
                    // Show success popup
                    showBookingSuccessPopup();
                    // Reset form
                    event.target.reset();
                } else {
                    // Show error message
                    let errorMessage = 'Error submitting booking';
                    if (result.message) {
                        errorMessage += ': ' + result.message;
                    } else if (result.errors) {
                        // Handle validation errors
                        errorMessage += ': ' + Object.values(result.errors).join(', ');
                    }
                    errorMessage += '. Please try again.';
                    showErrorMessage(errorMessage);
                }
            } catch (error) {
                console.error('Error submitting booking:', error);
                showErrorMessage('Network error. Please check your connection and try again.');
            } finally {
                // Restore submit button
                submitButton.innerHTML = originalButtonText;
                submitButton.disabled = false;
            }
        }
        
        // Function to show booking success popup
        function showBookingSuccessPopup() {
            // Get the success modal
            const successModal = document.getElementById('successModal');
            
            // Update the message in the modal
            const modalBody = successModal.querySelector('.modal-body');
            if (modalBody) {
                modalBody.innerHTML = `
                    <div class="success-icon">
                        <svg width="60" height="60" viewBox="0 0 60 60">
                            <circle cx="30" cy="30" r="25" fill="none" stroke="#4CAF50" stroke-width="3"/>
                            <path d="M 20 30 L 27 37 L 40 24" stroke="#4CAF50" stroke-width="3" fill="none"/>
                        </svg>
                    </div>
                    <p>Booking submitted successfully!</p>
                    <p>We will send you a confirmation message on WhatsApp shortly.</p>
                    <button class="whatsapp-btn" onclick="sendWhatsAppMessage()">
                        <svg class="whatsapp-icon" width="20" height="20" viewBox="0 0 20 20">
                            <path d="M 10 2 C 5.6 2 2 5.6 2 10 C 2 12.4 3 14.6 4.6 16.2 L 2 18 L 3.8 15.4 C 5.4 17 7.6 18 10 18 C 14.4 18 18 14.4 18 10 C 18 5.6 14.4 2 10 2 Z" fill="none" stroke="currentColor" stroke-width="2"/>
                            <path d="M 7 8 L 13 8 M 7 11 L 11 11" stroke="currentColor" stroke-width="2" fill="none"/>
                        </svg>
                        Send WhatsApp Confirmation
                    </button>
                `;
            }
            
            // Show the modal
            successModal.style.display = 'block';
        }
        
        // Function to close the success modal
        function closeSuccessModal() {
            const successModal = document.getElementById('successModal');
            successModal.style.display = 'none';
        }
        
        // Function to show error message
        function showErrorMessage(message) {
            showMessage(message, 'error');
        }
        
        // Function to show message (success or error)
        function showMessage(message, type) {
            // Remove any existing message
            const existingMessage = document.getElementById('form-message');
            if (existingMessage) existingMessage.remove();
            
            // Create message element
            const messageDiv = document.createElement('div');
            messageDiv.id = 'form-message';
            messageDiv.textContent = message;
            messageDiv.style.padding = '10px';
            messageDiv.style.margin = '10px 0';
            messageDiv.style.borderRadius = '4px';
            messageDiv.style.textAlign = 'center';
            
            if (type === 'success') {
                messageDiv.style.backgroundColor = '#d4edda';
                messageDiv.style.color = '#155724';
                messageDiv.style.borderColor = '#c3e6cb';
            } else {
                messageDiv.style.backgroundColor = '#f8d7da';
                messageDiv.style.color = '#721c24';
                messageDiv.style.borderColor = '#f5c6cb';
            }
            
            // Insert message before the form
            const form = document.getElementById('bookingForm');
            form.parentNode.insertBefore(messageDiv, form);
            
            // Remove message after 5 seconds
            setTimeout(() => {
                if (messageDiv.parentNode) {
                    messageDiv.remove();
                }
            }, 5000);
        }
        
        // Function to select a package (for the Book Now buttons)
        function selectPackage(packageId) {
            // Set the package select value to the selected package
            document.getElementById('package').value = packageId;
            
            // Scroll to the booking form
            document.getElementById('booking').scrollIntoView({ behavior: 'smooth' });
        }
        
        // Function to handle scanner button click
        function handleScannerClick() {
            // Show a message indicating scanner functionality
            alert('QR Code scanner would open here in a mobile application. This is a demonstration of the UI element.');
            
            // In a real implementation, you might use:
            // 1. Browser's MediaDevices API for camera access
            // 2. A library like jsQR for QR code scanning
            // 3. Or redirect to a mobile app that can handle QR scanning
        }
        
        // Function to handle advance payment button click
        function handleAdvancePaymentClick() {
            // Get the QR code modal
            const qrModal = document.getElementById('qrCodeModal');
            const qrImage = document.getElementById('qrCodeImage');
            
            // Set the QR code image source (using the scanner booking image)
            qrImage.src = '/images/shreenath ji Scanner.jpeg';
            
            // Show the modal
            qrModal.style.display = 'block';
        }
        
        // Function to close the QR code modal
        function closeQrCodeModal() {
            const qrModal = document.getElementById('qrCodeModal');
            qrModal.style.display = 'none';
        }
        
        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const successModal = document.getElementById('successModal');
            const qrModal = document.getElementById('qrCodeModal');
            
            if (event.target === successModal) {
                successModal.style.display = 'none';
            }
            
            if (event.target === qrModal) {
                qrModal.style.display = 'none';
            }
        }
        
        // Fetch all data when page loads
        document.addEventListener('DOMContentLoaded', function() {
            updateTimingsHeading();
            updateHeroTimingsDate();
            fetchPackages();
            fetchPackagesForBooking();
            fetchDarshanTimings();
            fetchHeroTimings();
            fetchPreferredTimeOptions();
            
            // Add event listener to the booking form
            const bookingForm = document.getElementById('bookingForm');
            if (bookingForm) {
                bookingForm.addEventListener('submit', submitBookingForm);
            }
            
            // Add event listener to the advance payment button
            const advancePaymentButton = document.getElementById('advancePaymentButton');
            if (advancePaymentButton) {
                advancePaymentButton.addEventListener('click', handleAdvancePaymentClick);
            }
        });
    </script>
@endsection
