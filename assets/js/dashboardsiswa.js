/**
 * GAMIFIKASI LMS - Dashboard JavaScript
 * Menangani interaktivitas dashboard siswa
 */

(function() {
    'use strict';

    // ============================================
    // CONFIGURATION
    // ============================================
    const CONFIG = {
        notificationDuration: 5000,
        animationDuration: 300,
        missionCompleteXP: 10
    };

    // ============================================
    // STATE
    // ============================================
    const state = {
        missions: [],
        notifications: [],
        isNotificationVisible: false
    };

    // ============================================
    // DOM REFS
    // ============================================
    const DOM = {
        notificationContainer: document.getElementById('gml-notification-container'),
        continueBtn: document.getElementById('gml-continue-btn'),
        continueLearningBtn: document.getElementById('gml-continue-learning-btn'),
        missionCheckboxes: document.querySelectorAll('.gml-mission-checkbox input[type="checkbox"]'),
        quickAccessItems: document.querySelectorAll('.gml-quick-access-item'),
        notificationClose: document.querySelectorAll('.gml-notification-close')
    };

    // ============================================
    // INIT
    // ============================================
    function init() {
        // Load data dari window object (passed from PHP)
        if (window.gmlDashboardData) {
            state.missions = window.gmlDashboardData.daily_missions || [];
            state.notifications = window.gmlDashboardData.notifications || [];
        }

        // Setup event listeners
        setupEventListeners();

        // Show initial notifications with delay
        setTimeout(() => {
            showInitialNotifications();
        }, 1500);

        console.log('✅ GML Dashboard initialized');
    }

    // ============================================
    // EVENT LISTENERS
    // ============================================
    function setupEventListeners() {
        // Continue Learning buttons
        if (DOM.continueBtn) {
            DOM.continueBtn.addEventListener('click', handleContinueLearning);
        }
        if (DOM.continueLearningBtn) {
            DOM.continueLearningBtn.addEventListener('click', handleContinueLearning);
        }

        // Mission checkboxes
        DOM.missionCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', handleMissionToggle);
        });

        // Quick Access items
        DOM.quickAccessItems.forEach(item => {
            item.addEventListener('click', handleQuickAccess);
        });

        // Notification close buttons
        DOM.notificationClose.forEach(btn => {
            btn.addEventListener('click', handleNotificationClose);
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', handleKeyboardShortcuts);

        // Page visibility - refresh data when user returns
        document.addEventListener('visibilitychange', handleVisibilityChange);
    }

    // ============================================
    // HANDLERS
    // ============================================
    
    /**
     * Handle Continue Learning button click
     */
    function handleContinueLearning(e) {
        e.preventDefault();
        
        const courseData = window.gmlDashboardData?.continue_learning;
        if (!courseData) {
            showNotification('📚', 'Belum ada course yang sedang dipelajari. Mulai course pertamamu!');
            return;
        }

        // Show loading state
        const btn = e.currentTarget;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<span class="gml-btn-icon">⏳</span> Memuat...';
        btn.disabled = true;

        // Simulate navigation
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
            
            // Navigate to course page (gunakan router)
            // window.location.href = '/course/' + courseData.course_id;
            
            // For demo, show notification
            showNotification('📖', `Melanjutkan: ${courseData.material}`);
        }, 800);
    }

    /**
     * Handle mission checkbox toggle
     */
    function handleMissionToggle(e) {
        const checkbox = e.currentTarget;
        const missionItem = checkbox.closest('.gml-mission-item');
        const missionId = parseInt(missionItem.dataset.missionId);
        const isChecked = checkbox.checked;

        // Find mission in state
        const mission = state.missions.find(m => m.id === missionId);
        if (!mission) return;

        // Update UI
        if (isChecked) {
            missionItem.classList.add('gml-mission-completed');
            
            // Show XP earned notification
            setTimeout(() => {
                showNotification('⭐', `Misi selesai! +${mission.xp} XP`);
                
                // Update total XP display
                updateMissionTotal();
            }, 300);
        } else {
            missionItem.classList.remove('gml-mission-completed');
            
            // Update total XP
            setTimeout(() => {
                updateMissionTotal();
            }, 100);
        }

        // Update mission status in state
        mission.completed = isChecked;
    }

    /**
     * Handle Quick Access item click
     */
    function handleQuickAccess(e) {
        const item = e.currentTarget;
        const route = item.dataset.route;
        
        if (!route) return;

        // Show loading feedback
        item.style.opacity = '0.6';
        
        // Simulate navigation
        setTimeout(() => {
            item.style.opacity = '1';
            
            // Navigate using router
            // window.location.href = route;
            
            // For demo, show notification
            const label = item.querySelector('.gml-quick-access-label');
            showNotification('🔗', `Membuka: ${label ? label.textContent : route}`);
        }, 400);
    }

    /**
     * Handle notification close
     */
    function handleNotificationClose(e) {
        const notification = e.currentTarget.closest('.gml-notification');
        if (notification) {
            notification.classList.add('gml-notification-hide');
            setTimeout(() => {
                notification.remove();
            }, CONFIG.animationDuration);
        }
    }

    /**
     * Handle keyboard shortcuts
     */
    function handleKeyboardShortcuts(e) {
        // Ctrl/Cmd + Shift + N = New Notification (demo)
        if (e.ctrlKey && e.shiftKey && e.key === 'N') {
            e.preventDefault();
            showNotification('🔔', 'Demo notification triggered by keyboard shortcut!');
        }
        
        // Escape = Close all notifications
        if (e.key === 'Escape') {
            document.querySelectorAll('.gml-notification').forEach(notif => {
                notif.classList.add('gml-notification-hide');
                setTimeout(() => notif.remove(), CONFIG.animationDuration);
            });
        }
    }

    /**
     * Handle page visibility change
     */
    function handleVisibilityChange() {
        if (!document.hidden) {
            // Page is visible again - refresh data
            console.log('🔄 Page became visible, refreshing data...');
            // refreshDashboardData();
        }
    }

    // ============================================
    // NOTIFICATION SYSTEM
    // ============================================
    
    /**
     * Show a notification
     */
    function showNotification(icon, message, time = 'Baru saja') {
        const notification = document.createElement('div');
        notification.className = 'gml-notification';
        notification.innerHTML = `
            <span class="gml-notification-icon">${icon}</span>
            <div class="gml-notification-content">
                <p class="gml-notification-message">${message}</p>
                <span class="gml-notification-time">${time}</span>
            </div>
            <button class="gml-notification-close" aria-label="Tutup notifikasi">×</button>
        `;

        // Add to container
        const container = DOM.notificationContainer;
        if (!container) {
            // Create container if it doesn't exist
            const newContainer = document.createElement('div');
            newContainer.id = 'gml-notification-container';
            newContainer.className = 'gml-notification-container';
            document.body.appendChild(newContainer);
        }
        
        document.getElementById('gml-notification-container').appendChild(notification);

        // Setup close button
        const closeBtn = notification.querySelector('.gml-notification-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                notification.classList.add('gml-notification-hide');
                setTimeout(() => notification.remove(), CONFIG.animationDuration);
            });
        }

        // Auto dismiss after duration
        setTimeout(() => {
            if (notification.parentNode) {
                notification.classList.add('gml-notification-hide');
                setTimeout(() => notification.remove(), CONFIG.animationDuration);
            }
        }, CONFIG.notificationDuration);

        // Add to state
        state.notifications.unshift({
            id: Date.now(),
            icon: icon,
            message: message,
            time: time,
            read: false
        });

        // Limit notifications in state
        if (state.notifications.length > 20) {
            state.notifications = state.notifications.slice(0, 20);
        }
    }

    /**
     * Show initial notifications from data
     */
    function showInitialNotifications() {
        if (state.notifications && state.notifications.length > 0) {
            // Show only unread notifications
            const unread = state.notifications.filter(n => !n.read);
            
            unread.forEach((notif, index) => {
                setTimeout(() => {
                    showNotification('📢', notif.message, notif.time);
                }, index * 800);
            });
        }
    }

    // ============================================
    // MISSION FUNCTIONS
    // ============================================
    
    /**
     * Update mission total XP display
     */
    function updateMissionTotal() {
        const totalElement = document.querySelector('.gml-mission-total strong');
        if (!totalElement) return;

        // Calculate total XP from completed missions
        const totalXP = state.missions
            .filter(m => m.completed)
            .reduce((sum, m) => sum + m.xp, 0);

        totalElement.textContent = `+${totalXP} XP`;
    }

    // ============================================
    // DATA FUNCTIONS
    // ============================================
    
    /**
     * Refresh dashboard data (mock)
     */
    function refreshDashboardData() {
        // In production, this would fetch from Firebase
        console.log('🔄 Refreshing dashboard data...');
        
        // Simulate loading
        showNotification('🔄', 'Menyegarkan data...', 'Sedang proses');
        
        setTimeout(() => {
            showNotification('✅', 'Data berhasil diperbarui!', 'Baru saja');
        }, 1000);
    }

    // ============================================
    // UTILITY FUNCTIONS
    // ============================================
    
    /**
     * Format date to readable string
     */
    function formatDate(dateString) {
        const date = new Date(dateString);
        const options = { day: 'numeric', month: 'short', year: 'numeric' };
        return date.toLocaleDateString('id-ID', options);
    }

    /**
     * Get relative time string
     */
    function getRelativeTime(dateString) {
        const now = new Date();
        const past = new Date(dateString);
        const diff = Math.floor((now - past) / 1000);

        if (diff < 60) return 'Baru saja';
        if (diff < 3600) return `${Math.floor(diff / 60)} menit lalu`;
        if (diff < 86400) return `${Math.floor(diff / 3600)} jam lalu`;
        if (diff < 604800) return `${Math.floor(diff / 86400)} hari lalu`;
        return formatDate(dateString);
    }

    /**
     * Debounce function for performance
     */
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // ============================================
    // EXPOSE TO GLOBAL (for debugging)
    // ============================================
    if (window) {
        window.GML = {
            state: state,
            showNotification: showNotification,
            refreshData: refreshDashboardData,
            CONFIG: CONFIG
        };
    }

    // ============================================
    // AUTO-INIT
    // ============================================
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();