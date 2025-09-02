// Global variables
let bookings = [];
let selectedPackage = null;

// Static package data
const packages = [
    {
        id: 1,
        name: "Normal Darshan",
        price: 100,
        features: [
            { icon: "🎁", text: "Free Prasad" },
            { icon: "👔", text: "Free Guide" },
            { icon: "👟", text: "Shoes Holding" },
            { icon: "📱", text: "Mobile Facility" }
        ]
    },
    {
        id: 2,
        name: "VIP Darshan",
        price: 600,
        features: [
            { icon: "👔", text: "Free Guide" },
            { icon: "🍪", text: "Ladoo Prasad (₹200)" },
            { icon: "🎫", text: "Free Ticket (₹350)" },
            { icon: "🚀", text: "Quick Entry" }
        ]
    },
    {
        id: 3,
        name: "Premium Darshan",
        price: 1200,
        features: [
            { icon: "👑", text: "Priority Access" },
            { icon: "🍽️", text: "Special Prasad" },
            { icon: "🙏", text: "Personal Aarti" },
            { icon: "🚗", text: "Parking Facility" }
        ]
    },
    {
        id: 4,
        name: "Royal Darshan",
        price: 2500,
        features: [
            { icon: "💎", text: "Exclusive Entry" },
            { icon: "⭐", text: "VIP Seating" },
            { icon: "🎵", text: "Special Bhajan" },
            { icon: "🏨", text: "Accommodation" }
        ]
    }
];

// Initialize the application
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
    setupEventListeners();
    loadBookings();
    createFloatingElements();
    setupInteractiveAnimations();
});

// Initialize the application
function initializeApp() {
    // Set minimum date to today
    const dateInput = document.getElementById('date');
    if (dateInput) {
        const today = new Date().toISOString().split('T')[0];
        dateInput.min = today;
    }
}

// Setup event listeners
function setupEventListeners() {
    // Mobile navigation
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    
    if (hamburger) {
        hamburger.addEventListener('click', function() {
            navMenu.classList.toggle('active');
        });
    }

    // Close mobile menu when clicking on links
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            navMenu.classList.remove('active');
        });
    });

    // Booking form submission
    const bookingForm = document.getElementById('bookingForm');
    if (bookingForm) {
        bookingForm.addEventListener('submit', handleBookingSubmission);
    }

    // Contact form submission
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', handleContactSubmission);
    }

    // Close modals when clicking outside
    window.addEventListener('click', function(event) {
        const successModal = document.getElementById('successModal');
        
        if (event.target === successModal) {
            closeSuccessModal();
        }
    });
}

// Select package function
function selectPackage(packageId) {
    const package = packages.find(p => p.id === packageId);
    if (package) {
        selectedPackage = package;
        
        // Update the package input field
        const packageInput = document.getElementById('package');
        if (packageInput) {
            packageInput.value = `${package.name} - ₹${package.price}`;
        }
        
        // Scroll to booking section
        scrollToSection('booking');
        
        // Add visual feedback
        const packageCards = document.querySelectorAll('.package-card');
        packageCards.forEach(card => card.classList.remove('selected'));
        
        const selectedCard = document.querySelector(`[onclick="selectPackage(${packageId})"]`);
        if (selectedCard) {
            selectedCard.classList.add('selected');
        }
    }
}

// Scroll to section smoothly
function scrollToSection(sectionId) {
    const section = document.getElementById(sectionId);
    if (section) {
        section.scrollIntoView({ behavior: 'smooth' });
    }
}

// Handle booking form submission
function handleBookingSubmission(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const bookingData = {
        id: Date.now(),
        name: formData.get('name'),
        mobile: formData.get('mobile'),
        date: formData.get('date'),
        time: formData.get('time'),
        package: formData.get('package'),
        guests: parseInt(formData.get('guests')),
        timestamp: new Date().toISOString()
    };

    // Validate package selection
    if (!selectedPackage) {
        alert('Please select a package first');
        return;
    }

    // Add booking to array
    bookings.push(bookingData);
    saveBookings();

    // Show success modal
    showSuccessModal();

    // Reset form
    event.target.reset();
    selectedPackage = null;
    document.getElementById('package').value = '';
}

// Handle contact form submission
function handleContactSubmission(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const contactData = {
        name: formData.get('contactName'),
        email: formData.get('contactEmail'),
        message: formData.get('contactMessage'),
        timestamp: new Date().toISOString()
    };

    // Simulate sending message
    alert('Thank you for your message! We will get back to you soon.');
    
    // Reset form
    event.target.reset();
}

// Load bookings from localStorage
function loadBookings() {
    const savedBookings = localStorage.getItem('darshanBookings');
    if (savedBookings) {
        bookings = JSON.parse(savedBookings);
    }
}

// Save bookings to localStorage
function saveBookings() {
    localStorage.setItem('darshanBookings', JSON.stringify(bookings));
}

// Show success modal
function showSuccessModal() {
    const modal = document.getElementById('successModal');
    if (modal) {
        modal.style.display = 'block';
    }
}

// Close success modal
function closeSuccessModal() {
    const modal = document.getElementById('successModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

// Send WhatsApp message
function sendWhatsAppMessage() {
    const lastBooking = bookings[bookings.length - 1];
    if (lastBooking) {
        const message = `Namaste! Your Shreenath Ji Darshan booking has been confirmed.\n\nDetails:\nName: ${lastBooking.name}\nDate: ${lastBooking.date}\nTime: ${lastBooking.time}\nPackage: ${lastBooking.package}\nGuests: ${lastBooking.guests}\n\nJai Shree Krishna! 🙏`;
        const whatsappUrl = `https://wa.me/919876543210?text=${encodeURIComponent(message)}`;
        window.open(whatsappUrl, '_blank');
    }
}

// Create floating elements for visual effects
function createFloatingElements() {
    const body = document.body;
    
    // Create floating lotus petals
    for (let i = 0; i < 5; i++) {
        const lotus = document.createElement('div');
        lotus.className = 'floating-lotus';
        lotus.style.left = Math.random() * 100 + '%';
        lotus.style.animationDelay = Math.random() * 10 + 's';
        lotus.style.animationDuration = (Math.random() * 10 + 15) + 's';
        body.appendChild(lotus);
    }
    
    // Create floating cow elements
    for (let i = 0; i < 3; i++) {
        const cow = document.createElement('div');
        cow.className = 'floating-cow';
        cow.style.left = Math.random() * 100 + '%';
        cow.style.animationDelay = Math.random() * 15 + 's';
        cow.style.animationDuration = (Math.random() * 20 + 25) + 's';
        body.appendChild(cow);
    }
}

// Setup interactive animations
function setupInteractiveAnimations() {
    // Add hover effects to package cards
    const packageCards = document.querySelectorAll('.package-card');
    packageCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // Add click effects to buttons
    const buttons = document.querySelectorAll('.submit-btn, .book-btn');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    });
}

// Export functions for global access
window.scrollToSection = scrollToSection;
window.selectPackage = selectPackage;
window.sendWhatsAppMessage = sendWhatsAppMessage;
window.closeSuccessModal = closeSuccessModal; 