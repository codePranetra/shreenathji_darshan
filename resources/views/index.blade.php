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
                <h1>Shreenath Ji Darshan Booking</h1>
                <p>Experience divine darshan from the holy town of Nathdwara</p>
                <button class="cta-button" onclick="scrollToSection('packages')">
                    <svg class="cta-icon" width="20" height="20" viewBox="0 0 20 20">
                        <path d="M 10 2 L 10 18 M 2 10 L 18 10" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    View Darshan Packages
                </button>
            </div>
            <div class="hero-visual">
                
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
            <h2>Darshan Packages</h2>
            <div class="packages-grid">
                <!-- Normal Darshan -->
                <div class="package-card" onclick="selectPackage(1)">
                    <div class="package-header">
                        <h3>Normal Darshan</h3>
                        <div class="price">₹100</div>
                    </div>
                    <ul class="package-features">
                        <li>
                            <svg class="feature-icon" width="24" height="24" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" fill="none" stroke="#FFD700" stroke-width="2"/>
                                <path d="M 8 12 L 11 15 L 16 10" stroke="#FFD700" stroke-width="2" fill="none"/>
                            </svg>
                            Free Prasad
                        </li>
                        <li>
                            <svg class="feature-icon" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M 12 2 L 12 22 M 8 6 L 16 6 M 8 10 L 16 10" stroke="#FFD700" stroke-width="2" fill="none"/>
                            </svg>
                            Free Guide
                        </li>
                        <li>
                            <svg class="feature-icon" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M 6 18 L 18 18 M 8 14 L 16 14" stroke="#FFD700" stroke-width="2" fill="none"/>
                            </svg>
                            Shoes Holding
                        </li>
                        <li>
                            <svg class="feature-icon" width="24" height="24" viewBox="0 0 24 24">
                                <rect x="6" y="4" width="12" height="16" rx="2" fill="none" stroke="#FFD700" stroke-width="2"/>
                                <circle cx="12" cy="12" r="2" fill="#FFD700"/>
                            </svg>
                            Mobile Facility
                        </li>
                    </ul>
                    <button class="book-btn">Book Now</button>
                </div>

                <!-- VIP Darshan -->
                <div class="package-card" onclick="selectPackage(2)">
                    <div class="package-header">
                        <h3>VIP Darshan</h3>
                        <div class="price">₹600</div>
                    </div>
                    <ul class="package-features">
                        <li>
                            <svg class="feature-icon" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M 12 2 L 12 22 M 8 6 L 16 6 M 8 10 L 16 10" stroke="#FFD700" stroke-width="2" fill="none"/>
                            </svg>
                            Free Guide
                        </li>
                        <li>
                            <svg class="feature-icon" width="24" height="24" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="8" fill="none" stroke="#FFD700" stroke-width="2"/>
                                <path d="M 8 12 L 11 15 L 16 10" stroke="#FFD700" stroke-width="2" fill="none"/>
                            </svg>
                            Ladoo Prasad (₹200)
                        </li>
                        <li>
                            <svg class="feature-icon" width="24" height="24" viewBox="0 0 24 24">
                                <rect x="4" y="6" width="16" height="12" rx="2" fill="none" stroke="#FFD700" stroke-width="2"/>
                                <path d="M 8 10 L 16 10" stroke="#FFD700" stroke-width="2"/>
                            </svg>
                            Free Ticket (₹350)
                        </li>
                        <li>
                            <svg class="feature-icon" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M 12 2 L 12 22 M 8 6 L 16 6" stroke="#FFD700" stroke-width="2" fill="none"/>
                                <path d="M 6 18 L 18 18" stroke="#FFD700" stroke-width="2" fill="none"/>
                            </svg>
                            Quick Entry
                        </li>
                    </ul>
                    <button class="book-btn">Book Now</button>
                </div>

                <!-- Premium Darshan -->
                <div class="package-card" onclick="selectPackage(3)">
                    <div class="package-header">
                        <h3>Premium Darshan</h3>
                        <div class="price">₹1200</div>
                    </div>
                    <ul class="package-features">
                        <li>
                            <svg class="feature-icon" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M 12 2 L 12 22 M 8 6 L 16 6" stroke="#FFD700" stroke-width="2" fill="none"/>
                                <circle cx="12" cy="12" r="4" fill="#FFD700"/>
                            </svg>
                            Priority Access
                        </li>
                        <li>
                            <svg class="feature-icon" width="24" height="24" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="8" fill="none" stroke="#FFD700" stroke-width="2"/>
                                <path d="M 8 12 L 11 15 L 16 10" stroke="#FFD700" stroke-width="2" fill="none"/>
                            </svg>
                            Special Prasad
                        </li>
                        <li>
                            <svg class="feature-icon" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M 12 2 L 12 22 M 8 6 L 16 6" stroke="#FFD700" stroke-width="2" fill="none"/>
                                <circle cx="12" cy="12" r="6" fill="none" stroke="#FFD700" stroke-width="2"/>
                            </svg>
                            Personal Aarti
                        </li>
                        <li>
                            <svg class="feature-icon" width="24" height="24" viewBox="0 0 24 24">
                                <rect x="4" y="8" width="16" height="8" rx="2" fill="none" stroke="#FFD700" stroke-width="2"/>
                                <path d="M 8 12 L 16 12" stroke="#FFD700" stroke-width="2"/>
                            </svg>
                            Parking Facility
                        </li>
                    </ul>
                    <button class="book-btn">Book Now</button>
                </div>

                <!-- Royal Darshan -->
                <div class="package-card" onclick="selectPackage(4)">
                    <div class="package-header">
                        <h3>Royal Darshan</h3>
                        <div class="price">₹2500</div>
                    </div>
                    <ul class="package-features">
                        <li>
                            <svg class="feature-icon" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M 12 2 L 12 22 M 8 6 L 16 6" stroke="#FFD700" stroke-width="2" fill="none"/>
                                <polygon points="12,2 15,8 22,8 16,12 18,18 12,14 6,18 8,12 2,8 9,8" fill="#FFD700"/>
                            </svg>
                            Exclusive Entry
                        </li>
                        <li>
                            <svg class="feature-icon" width="24" height="24" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="8" fill="none" stroke="#FFD700" stroke-width="2"/>
                                <path d="M 8 12 L 11 15 L 16 10" stroke="#FFD700" stroke-width="2" fill="none"/>
                            </svg>
                            VIP Seating
                        </li>
                        <li>
                            <svg class="feature-icon" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M 12 2 L 12 22 M 8 6 L 16 6" stroke="#FFD700" stroke-width="2" fill="none"/>
                                <path d="M 6 18 Q 12 12 18 18" stroke="#FFD700" stroke-width="2" fill="none"/>
                            </svg>
                            Special Bhajan
                        </li>
                        <li>
                            <svg class="feature-icon" width="24" height="24" viewBox="0 0 24 24">
                                <rect x="4" y="8" width="16" height="12" rx="2" fill="none" stroke="#FFD700" stroke-width="2"/>
                                <path d="M 8 12 L 16 12 M 8 16 L 16 16" stroke="#FFD700" stroke-width="2"/>
                            </svg>
                            Accommodation
                        </li>
                    </ul>
                    <button class="book-btn">Book Now</button>
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
            <h2>Darshan Timings</h2>
            <div class="timing-content">
                <div class="timing-icon">
                    <svg width="80" height="80" viewBox="0 0 80 80">
                        <circle cx="40" cy="40" r="35" fill="none" stroke="#1B3C5D" stroke-width="3"/>
                        <path d="M 40 20 L 40 40 L 55 40" stroke="#FFD700" stroke-width="3" fill="none"/>
                        <circle cx="40" cy="40" r="3" fill="#FFD700"/>
                    </svg>
                </div>
                <div class="timing-slots">
                    <div class="timing-slot">
                        <span class="time">6:00 AM</span>
                        <span class="description">Morning Aarti</span>
                    </div>
                    <div class="timing-slot">
                        <span class="time">9:00 AM</span>
                        <span class="description">Regular Darshan</span>
                    </div>
                    <div class="timing-slot">
                        <span class="time">12:00 PM</span>
                        <span class="description">Rajbhog</span>
                    </div>
                    <div class="timing-slot">
                        <span class="time">4:00 PM</span>
                        <span class="description">Evening Darshan</span>
                    </div>
                    <div class="timing-slot">
                        <span class="time">7:00 PM</span>
                        <span class="description">Shayan Aarti</span>
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
    <section id="booking" class="booking">
        <div class="container">
            <h2>Book Your Darshan</h2>
            <div class="booking-form-container">
                <form id="bookingForm" class="booking-form">
                    <div class="form-group">
                        <label for="name">
                            <svg class="form-icon" width="20" height="20" viewBox="0 0 20 20">
                                <circle cx="10" cy="6" r="3" fill="none" stroke="#1B3C5D" stroke-width="2"/>
                                <path d="M 3 18 C 3 14 6 11 10 11 C 14 11 17 14 17 18" fill="none" stroke="#1B3C5D" stroke-width="2"/>
                            </svg>
                            Full Name *
                        </label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="mobile">
                            <svg class="form-icon" width="20" height="20" viewBox="0 0 20 20">
                                <rect x="4" y="2" width="12" height="16" rx="2" fill="none" stroke="#1B3C5D" stroke-width="2"/>
                                <circle cx="10" cy="14" r="1" fill="#1B3C5D"/>
                            </svg>
                            Mobile Number *
                        </label>
                        <input type="tel" id="mobile" name="mobile" required>
                    </div>
                    <div class="form-group">
                        <label for="date">
                            <svg class="form-icon" width="20" height="20" viewBox="0 0 20 20">
                                <rect x="3" y="4" width="14" height="14" rx="2" fill="none" stroke="#1B3C5D" stroke-width="2"/>
                                <path d="M 3 8 L 17 8" stroke="#1B3C5D" stroke-width="2"/>
                                <circle cx="7" cy="11" r="1" fill="#1B3C5D"/>
                                <circle cx="10" cy="11" r="1" fill="#1B3C5D"/>
                                <circle cx="13" cy="11" r="1" fill="#1B3C5D"/>
                                <circle cx="7" cy="14" r="1" fill="#1B3C5D"/>
                                <circle cx="10" cy="14" r="1" fill="#1B3C5D"/>
                                <circle cx="13" cy="14" r="1" fill="#1B3C5D"/>
                            </svg>
                            Darshan Date *
                        </label>
                        <input type="date" id="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="time">
                            <svg class="form-icon" width="20" height="20" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="8" fill="none" stroke="#1B3C5D" stroke-width="2"/>
                                <path d="M 10 6 L 10 10 L 13 10" stroke="#1B3C5D" stroke-width="2" fill="none"/>
                            </svg>
                            Preferred Time *
                        </label>
                        <select id="time" name="time" required>
                            <option value="">Select Time</option>
                            <option value="06:00">6:00 AM - Morning Aarti</option>
                            <option value="09:00">9:00 AM - Regular Darshan</option>
                            <option value="12:00">12:00 PM - Rajbhog</option>
                            <option value="16:00">4:00 PM - Evening Darshan</option>
                            <option value="19:00">7:00 PM - Shayan Aarti</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="package">
                            <svg class="form-icon" width="20" height="20" viewBox="0 0 20 20">
                                <rect x="3" y="3" width="14" height="14" rx="2" fill="none" stroke="#1B3C5D" stroke-width="2"/>
                                <path d="M 7 7 L 13 7 M 7 10 L 13 10 M 7 13 L 13 13" stroke="#1B3C5D" stroke-width="2"/>
                            </svg>
                            Selected Package *
                        </label>
                        <select id="package" name="package" required>
                            <option value="">Select a Package</option>
                            <option value="Normal Darshan - ₹100">Normal Darshan - ₹100</option>
                            <option value="VIP Darshan - ₹600">VIP Darshan - ₹600</option>
                            <option value="Premium Darshan - ₹1200">Premium Darshan - ₹1200</option>
                            <option value="Royal Darshan - ₹2500">Royal Darshan - ₹2500</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="guests">
                            <svg class="form-icon" width="20" height="20" viewBox="0 0 20 20">
                                <circle cx="10" cy="6" r="3" fill="none" stroke="#1B3C5D" stroke-width="2"/>
                                <path d="M 3 18 C 3 14 6 11 10 11 C 14 11 17 14 17 18" fill="none" stroke="#1B3C5D" stroke-width="2"/>
                                <circle cx="7" cy="8" r="2" fill="none" stroke="#1B3C5D" stroke-width="1"/>
                                <circle cx="13" cy="8" r="2" fill="none" stroke="#1B3C5D" stroke-width="1"/>
                            </svg>
                            Number of Guests
                        </label>
                        <input type="number" id="guests" name="guests" min="1" max="10" value="1">
                    </div>
                    <button type="submit" class="submit-btn">
                        <svg class="whatsapp-icon" width="20" height="20" viewBox="0 0 20 20">
                            <path d="M 10 2 C 5.6 2 2 5.6 2 10 C 2 12.4 3 14.6 4.6 16.2 L 2 18 L 3.8 15.4 C 5.4 17 7.6 18 10 18 C 14.4 18 18 14.4 18 10 C 18 5.6 14.4 2 10 2 Z" fill="none" stroke="currentColor" stroke-width="2"/>
                            <path d="M 7 8 L 13 8 M 7 11 L 11 11" stroke="currentColor" stroke-width="2" fill="none"/>
                        </svg>
                        Proceed to Payment
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>About Shreenath Ji</h2>
                    <p>Shreenath Ji, also known as Shrinathji, is a form of Lord Krishna worshipped in Nathdwara, Rajasthan. The deity is believed to be a 7-year-old child form of Krishna, and the temple is one of the most sacred pilgrimage sites in India.</p>
                    <p>Our booking portal is inspired by the beautiful Pichwai art tradition, which depicts scenes from Lord Krishna's life with intricate details, vibrant colors, and traditional motifs including cows (Gaay), flowers & leaves (Phool-Patti), Bel vines, and Prasad thaal.</p>
                    <div class="about-features">
                        <div class="feature">
                            <svg class="feature-icon" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M 12 2 L 12 22 M 8 6 L 16 6" stroke="#FFD700" stroke-width="2" fill="none"/>
                                <circle cx="12" cy="12" r="6" fill="none" stroke="#FFD700" stroke-width="2"/>
                            </svg>
                            <span>Traditional Pichwai Art</span>
                        </div>
                        <div class="feature">
                            <svg class="feature-icon" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M 12 2 L 12 22 M 8 6 L 16 6" stroke="#FFD700" stroke-width="2" fill="none"/>
                                <circle cx="12" cy="12" r="6" fill="none" stroke="#FFD700" stroke-width="2"/>
                            </svg>
                            <span>Sacred Darshan Experience</span>
                        </div>
                        <div class="feature">
                            <svg class="feature-icon" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M 12 2 L 12 22 M 8 6 L 16 6" stroke="#FFD700" stroke-width="2" fill="none"/>
                                <circle cx="12" cy="12" r="6" fill="none" stroke="#FFD700" stroke-width="2"/>
                            </svg>
                            <span>Divine Blessings</span>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <img src="{{ asset('images/shrinathji-or-lord-krishna-as-pichwai-folk-painting-vector (1).jpg') }}" alt="Shrinathji Pichwai Art" style="max-width:60%;height:auto;display:block;margin:0 auto 18px auto;border-radius:16px;box-shadow:0 4px 24px rgba(27,60,93,0.08);">

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
                            <path d="M 12 2 C 6.5 2 2 6.5 2 12 C 2 17.5 6.5 22 12 22 C 17.5 22 22 17.5 22 12 C 22 6.5 17.5 2 12 2 Z" fill="none" stroke="#1B3C5D" stroke-width="2"/>
                            <path d="M 8 12 L 11 15 L 16 10" stroke="#FFD700" stroke-width="2" fill="none"/>
                        </svg>
                        <div>
                            <h3>WhatsApp</h3>
                            <p>+91 98765 43210</p>
                            <a href="https://wa.me/919876543210" class="whatsapp-btn" target="_blank">
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
                            <circle cx="12" cy="12" r="10" fill="none" stroke="#1B3C5D" stroke-width="2"/>
                            <path d="M 12 6 L 12 12 L 16 12" stroke="#FFD700" stroke-width="2" fill="none"/>
                        </svg>
                        <div>
                            <h3>Darshan Timings</h3>
                            <p>Morning: 6:00 AM - 12:00 PM</p>
                            <p>Evening: 4:00 PM - 8:00 PM</p>
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
@endsection

@section('js')
    <script>
    
    </script>
@endsection
