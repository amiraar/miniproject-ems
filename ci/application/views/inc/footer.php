<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <!-- Bootstrap 5 JavaScript Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Global Theme Manager -->
    <script>
        // Global Theme Manager for all pages
        class GlobalThemeManager {
            constructor() {
                this.theme = localStorage.getItem('theme') || 'light';
                this.init();
            }
            
            init() {
                this.applyTheme(this.theme);
                
                // Listen for theme toggle events from any page
                document.addEventListener('themeChanged', (event) => {
                    this.theme = event.detail.theme;
                    this.applyTheme(this.theme);
                    localStorage.setItem('theme', this.theme);
                });
            }
            
            applyTheme(theme) {
                document.documentElement.setAttribute('data-bs-theme', theme);
                
                // Update any theme toggle buttons on the page
                const toggleBtns = document.querySelectorAll('#themeToggle');
                const themeIcons = document.querySelectorAll('#themeIcon');
                
                toggleBtns.forEach(btn => {
                    if (theme === 'dark') {
                        btn.title = 'Switch to Light Mode';
                    } else {
                        btn.title = 'Switch to Dark Mode';
                    }
                });
                
                themeIcons.forEach(icon => {
                    if (theme === 'dark') {
                        icon.className = 'fas fa-sun';
                    } else {
                        icon.className = 'fas fa-moon';
                    }
                });
            }
            
            toggleTheme() {
                this.theme = this.theme === 'light' ? 'dark' : 'light';
                this.applyTheme(this.theme);
                localStorage.setItem('theme', this.theme);
                
                // Dispatch custom event for other components
                document.dispatchEvent(new CustomEvent('themeChanged', {
                    detail: { theme: this.theme }
                }));
            }
        }
        
        // Initialize global theme manager
        document.addEventListener('DOMContentLoaded', function() {
            window.themeManager = new GlobalThemeManager();
            
            // Setup theme toggle buttons
            const toggleBtns = document.querySelectorAll('#themeToggle');
            toggleBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    window.themeManager.toggleTheme();
                });
            });
            
            // Add smooth loading animations for better UX
            const elements = document.querySelectorAll('.card, .btn, .alert');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(10px)';
                
                setTimeout(() => {
                    el.style.transition = 'all 0.3s ease';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, 50 * index);
            });
        });
        
        // Add loading states for forms
        document.addEventListener('submit', function(e) {
            const form = e.target;
            const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
            
            if (submitBtn) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
                
                // Add spinner
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
                
                // Re-enable after 5 seconds (fallback)
                setTimeout(() => {
                    submitBtn.classList.remove('loading');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }, 5000);
            }
        });
    </script>
</body>
</html>