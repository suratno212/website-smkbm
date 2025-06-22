// PWA Installation and Management
class PWA {
    constructor() {
        this.deferredPrompt = null;
        this.isInstalled = false;
        this.init();
    }

    init() {
        this.registerServiceWorker();
        this.setupInstallPrompt();
        this.checkInstallation();
        this.setupNotifications();
    }

    // Register Service Worker
    async registerServiceWorker() {
        if ('serviceWorker' in navigator) {
            try {
                const registration = await navigator.serviceWorker.register('/sw.js');
                console.log('Service Worker registered successfully:', registration);
                
                // Check for updates
                registration.addEventListener('updatefound', () => {
                    const newWorker = registration.installing;
                    newWorker.addEventListener('statechange', () => {
                        if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                            this.showUpdateNotification();
                        }
                    });
                });
            } catch (error) {
                console.error('Service Worker registration failed:', error);
            }
        }
    }

    // Setup Install Prompt
    setupInstallPrompt() {
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            this.deferredPrompt = e;
            this.showInstallButton();
        });

        window.addEventListener('appinstalled', () => {
            this.isInstalled = true;
            this.hideInstallButton();
            this.showInstallSuccess();
        });
    }

    // Show Install Button
    showInstallButton() {
        if (this.isInstalled) return;

        const installButton = document.createElement('div');
        installButton.id = 'pwa-install-button';
        installButton.innerHTML = `
            <div class="pwa-install-banner">
                <div class="pwa-install-content">
                    <div class="pwa-install-icon">
                        <i class="fas fa-download"></i>
                    </div>
                    <div class="pwa-install-text">
                        <h4>Install SIAKAD SMK</h4>
                        <p>Install aplikasi untuk akses yang lebih cepat</p>
                    </div>
                    <div class="pwa-install-actions">
                        <button class="btn-install" onclick="pwa.installApp()">
                            <i class="fas fa-download"></i> Install
                        </button>
                        <button class="btn-dismiss" onclick="pwa.hideInstallButton()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;

        // Add CSS for install button
        const style = document.createElement('style');
        style.textContent = `
            .pwa-install-banner {
                position: fixed;
                bottom: 20px;
                left: 20px;
                right: 20px;
                background: linear-gradient(135deg, #1a237e, #283593);
                color: white;
                border-radius: 15px;
                padding: 1rem;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
                z-index: 9999;
                animation: slideUp 0.3s ease;
            }

            @keyframes slideUp {
                from { transform: translateY(100%); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }

            .pwa-install-content {
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .pwa-install-icon {
                width: 50px;
                height: 50px;
                background: rgba(255, 255, 255, 0.2);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
            }

            .pwa-install-text {
                flex: 1;
            }

            .pwa-install-text h4 {
                margin: 0 0 0.25rem 0;
                font-size: 1.1rem;
            }

            .pwa-install-text p {
                margin: 0;
                font-size: 0.9rem;
                opacity: 0.9;
            }

            .pwa-install-actions {
                display: flex;
                gap: 0.5rem;
            }

            .btn-install, .btn-dismiss {
                padding: 0.5rem 1rem;
                border: none;
                border-radius: 25px;
                cursor: pointer;
                font-size: 0.9rem;
                transition: all 0.3s ease;
            }

            .btn-install {
                background: #F7D117;
                color: #1a237e;
                font-weight: 600;
            }

            .btn-install:hover {
                background: #f0c800;
                transform: translateY(-2px);
            }

            .btn-dismiss {
                background: rgba(255, 255, 255, 0.2);
                color: white;
            }

            .btn-dismiss:hover {
                background: rgba(255, 255, 255, 0.3);
            }

            @media (max-width: 768px) {
                .pwa-install-content {
                    flex-direction: column;
                    text-align: center;
                }
                
                .pwa-install-actions {
                    justify-content: center;
                }
            }
        `;

        document.head.appendChild(style);
        document.body.appendChild(installButton);
    }

    // Hide Install Button
    hideInstallButton() {
        const installButton = document.getElementById('pwa-install-button');
        if (installButton) {
            installButton.style.animation = 'slideDown 0.3s ease';
            setTimeout(() => {
                installButton.remove();
            }, 300);
        }
    }

    // Install App
    async installApp() {
        if (this.deferredPrompt) {
            this.deferredPrompt.prompt();
            const { outcome } = await this.deferredPrompt.userChoice;
            
            if (outcome === 'accepted') {
                console.log('User accepted the install prompt');
            } else {
                console.log('User dismissed the install prompt');
            }
            
            this.deferredPrompt = null;
        }
    }

    // Check Installation Status
    checkInstallation() {
        if (window.matchMedia('(display-mode: standalone)').matches) {
            this.isInstalled = true;
            this.hideInstallButton();
        }
    }

    // Show Update Notification
    showUpdateNotification() {
        const updateNotification = document.createElement('div');
        updateNotification.innerHTML = `
            <div class="pwa-update-notification">
                <div class="update-content">
                    <i class="fas fa-sync-alt"></i>
                    <span>Update tersedia. Refresh halaman untuk memperbarui aplikasi.</span>
                    <button onclick="location.reload()">Refresh</button>
                </div>
            </div>
        `;

        const style = document.createElement('style');
        style.textContent = `
            .pwa-update-notification {
                position: fixed;
                top: 20px;
                right: 20px;
                background: #28a745;
                color: white;
                padding: 1rem;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
                z-index: 9999;
                animation: slideIn 0.3s ease;
            }

            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }

            .update-content {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .update-content button {
                background: rgba(255, 255, 255, 0.2);
                border: none;
                color: white;
                padding: 0.25rem 0.5rem;
                border-radius: 5px;
                cursor: pointer;
                font-size: 0.8rem;
            }

            .update-content button:hover {
                background: rgba(255, 255, 255, 0.3);
            }
        `;

        document.head.appendChild(style);
        document.body.appendChild(updateNotification);

        // Auto hide after 10 seconds
        setTimeout(() => {
            updateNotification.remove();
        }, 10000);
    }

    // Show Install Success
    showInstallSuccess() {
        const successNotification = document.createElement('div');
        successNotification.innerHTML = `
            <div class="pwa-success-notification">
                <div class="success-content">
                    <i class="fas fa-check-circle"></i>
                    <span>Aplikasi berhasil diinstall!</span>
                </div>
            </div>
        `;

        const style = document.createElement('style');
        style.textContent = `
            .pwa-success-notification {
                position: fixed;
                top: 20px;
                right: 20px;
                background: #28a745;
                color: white;
                padding: 1rem;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
                z-index: 9999;
                animation: slideIn 0.3s ease;
            }

            .success-content {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
        `;

        document.head.appendChild(style);
        document.body.appendChild(successNotification);

        // Auto hide after 5 seconds
        setTimeout(() => {
            successNotification.remove();
        }, 5000);
    }

    // Setup Push Notifications
    async setupNotifications() {
        if ('Notification' in window) {
            if (Notification.permission === 'default') {
                this.showNotificationPermission();
            }
        }
    }

    // Show Notification Permission Request
    showNotificationPermission() {
        const permissionBanner = document.createElement('div');
        permissionBanner.innerHTML = `
            <div class="notification-permission-banner">
                <div class="permission-content">
                    <i class="fas fa-bell"></i>
                    <div class="permission-text">
                        <h4>Notifikasi</h4>
                        <p>Dapatkan notifikasi terbaru dari SIAKAD SMK</p>
                    </div>
                    <div class="permission-actions">
                        <button onclick="pwa.requestNotificationPermission()">Izinkan</button>
                        <button onclick="pwa.hideNotificationPermission()">Nanti</button>
                    </div>
                </div>
            </div>
        `;

        const style = document.createElement('style');
        style.textContent = `
            .notification-permission-banner {
                position: fixed;
                top: 20px;
                right: 20px;
                background: white;
                border: 1px solid #e9ecef;
                border-radius: 10px;
                padding: 1rem;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                z-index: 9999;
                max-width: 300px;
                animation: slideIn 0.3s ease;
            }

            .permission-content {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .permission-text {
                flex: 1;
            }

            .permission-text h4 {
                margin: 0 0 0.25rem 0;
                font-size: 1rem;
                color: #333;
            }

            .permission-text p {
                margin: 0;
                font-size: 0.8rem;
                color: #666;
            }

            .permission-actions {
                display: flex;
                gap: 0.5rem;
            }

            .permission-actions button {
                padding: 0.25rem 0.5rem;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 0.8rem;
                transition: all 0.3s ease;
            }

            .permission-actions button:first-child {
                background: #1a237e;
                color: white;
            }

            .permission-actions button:last-child {
                background: #f8f9fa;
                color: #666;
            }

            .permission-actions button:hover {
                transform: translateY(-1px);
            }
        `;

        document.head.appendChild(style);
        document.body.appendChild(permissionBanner);

        // Auto hide after 15 seconds
        setTimeout(() => {
            permissionBanner.remove();
        }, 15000);
    }

    // Request Notification Permission
    async requestNotificationPermission() {
        try {
            const permission = await Notification.requestPermission();
            if (permission === 'granted') {
                this.hideNotificationPermission();
                this.showNotificationSuccess();
            }
        } catch (error) {
            console.error('Error requesting notification permission:', error);
        }
    }

    // Hide Notification Permission
    hideNotificationPermission() {
        const permissionBanner = document.querySelector('.notification-permission-banner');
        if (permissionBanner) {
            permissionBanner.remove();
        }
    }

    // Show Notification Success
    showNotificationSuccess() {
        const successNotification = document.createElement('div');
        successNotification.innerHTML = `
            <div class="notification-success">
                <i class="fas fa-check-circle"></i>
                <span>Notifikasi diaktifkan!</span>
            </div>
        `;

        const style = document.createElement('style');
        style.textContent = `
            .notification-success {
                position: fixed;
                top: 20px;
                right: 20px;
                background: #28a745;
                color: white;
                padding: 0.75rem 1rem;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
                z-index: 9999;
                animation: slideIn 0.3s ease;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
        `;

        document.head.appendChild(style);
        document.body.appendChild(successNotification);

        // Auto hide after 3 seconds
        setTimeout(() => {
            successNotification.remove();
        }, 3000);
    }
}

// Initialize PWA
const pwa = new PWA(); 