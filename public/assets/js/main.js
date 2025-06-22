// Update waktu real-time
function updateTime() {
    const now = new Date();
    const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    };
    document.getElementById('current-time').textContent = now.toLocaleDateString('id-ID', options);
}

// Update waktu setiap detik
setInterval(updateTime, 1000);
updateTime(); // Panggil sekali saat halaman dimuat

// Animasi scroll smooth untuk menu navigasi
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        
        if (target) {
            // Close mobile menu if open
            navMenu.classList.remove('active');
            menuToggle.classList.remove('active');
            
            // Smooth scroll to target
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Animasi untuk feature cards
const cards = document.querySelectorAll('.feature-card');
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = 1;
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, {
    threshold: 0.1
});

cards.forEach(card => {
    card.style.opacity = 0;
    card.style.transform = 'translateY(20px)';
    card.style.transition = 'all 0.5s ease-out';
    observer.observe(card);
});

// Mobile menu toggle
const menuToggle = document.querySelector('.menu-toggle');
const navMenu = document.querySelector('.nav-menu');
let isMenuOpen = false;

function toggleMenu() {
    isMenuOpen = !isMenuOpen;
    
    if (isMenuOpen) {
        navMenu.classList.add('active');
        menuToggle.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    } else {
        navMenu.classList.remove('active');
        menuToggle.classList.remove('active');
        document.body.style.overflow = ''; // Restore scrolling
    }
}

menuToggle.addEventListener('click', (e) => {
    e.stopPropagation();
    toggleMenu();
});

// Close menu when clicking outside
document.addEventListener('click', (e) => {
    if (isMenuOpen && !menuToggle.contains(e.target) && !navMenu.contains(e.target)) {
        toggleMenu();
    }
});

// Navbar Scroll Effect
const header = document.querySelector('.header');
let lastScroll = 0;
let scrollTimer;

window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;
    
    // Clear the timer
    clearTimeout(scrollTimer);
    
    // Add scrolled class immediately
    if (currentScroll > 100) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
    
    // Set a timer to handle scroll end
    scrollTimer = setTimeout(() => {
        header.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
    }, 100);
    
    lastScroll = currentScroll;
});

// Tab functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabPanes = document.querySelectorAll('.tab-pane');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons and panes
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));

            // Add active class to clicked button
            button.classList.add('active');

            // Show corresponding tab pane
            const tabId = button.getAttribute('data-tab');
            const tabPane = document.getElementById(tabId);
            if (tabPane) {
                tabPane.classList.add('active');
                // Scroll to the tab content
                tabPane.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
});

// Show More Pegawai
document.addEventListener('DOMContentLoaded', function() {
    const showMoreBtn = document.getElementById('showMoreBtn');
    const pegawaiGridMore = document.querySelector('.pegawai-grid-more');
    
    if (showMoreBtn && pegawaiGridMore) {
        showMoreBtn.addEventListener('click', function() {
            pegawaiGridMore.style.display = pegawaiGridMore.style.display === 'none' ? 'grid' : 'none';
            this.classList.toggle('active');
            this.innerHTML = this.classList.contains('active') 
                ? '<i class="fas fa-chevron-up"></i> Tampilkan Sedikit' 
                : '<i class="fas fa-chevron-down"></i> Tampilkan Lainnya';
        });
    }
});

// Smooth scroll with offset for fixed header
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        
        if (target) {
            // Close mobile menu if open
            if (isMenuOpen) {
                toggleMenu();
            }
            
            // Calculate offset for fixed header
            const headerHeight = header.offsetHeight;
            const targetPosition = target.getBoundingClientRect().top + window.pageYOffset;
            const offsetPosition = targetPosition - headerHeight;
            
            // Smooth scroll to target
            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }
    });
});

// Add padding to body to prevent content from hiding under fixed header
document.addEventListener('DOMContentLoaded', () => {
    const headerHeight = header.offsetHeight;
    document.body.style.paddingTop = `${headerHeight}px`;
}); 