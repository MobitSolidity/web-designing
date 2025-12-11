// Wait for the DOM to be fully loaded before running the script
document.addEventListener('DOMContentLoaded', function () {
    // --- Cart Functionality ---
    const cartCountElement = document.getElementById('cart-count');
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    const addedToCartModalElement = document.getElementById('addedToCartModal');
    let addedToCartModal;
    if (addedToCartModalElement) {
        addedToCartModal = new bootstrap.Modal(addedToCartModalElement);
    }
    const modalProductNameElement = document.getElementById('modalProductName');
    let currentCartCount = 0; 

    if (localStorage.getItem('mshCartItemCount')) {
        currentCartCount = parseInt(localStorage.getItem('mshCartItemCount'));
    }
    
    if (cartCountElement) {
        cartCountElement.textContent = currentCartCount;
    }

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault(); 
            
            currentCartCount++; 
            if (cartCountElement) {
                cartCountElement.textContent = currentCartCount; 
            }
            
            localStorage.setItem('mshCartItemCount', currentCartCount.toString());

            if (addedToCartModal && modalProductNameElement) {
                const productName = this.dataset.productName || 'محصول انتخاب شده'; 
                modalProductNameElement.textContent = productName; 
                addedToCartModal.show(); 
            }

            const originalButtonText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-check me-1"></i> اضافه شد';
            this.classList.add('btn-success');
            this.classList.remove('btn-primary');
            this.disabled = true; 

            setTimeout(() => {
              this.innerHTML = originalButtonText;
              this.classList.remove('btn-success');
              this.classList.add('btn-primary');
              this.disabled = false; 
            }, 2000);
        });
    });

    // --- Back to Top Button Functionality ---
    const backToTopButton = document.getElementById('back-to-top-btn');

    if (backToTopButton) {
        window.onscroll = function() {
            if (document.body.scrollTop > 0 || document.documentElement.scrollTop > 0) {
                backToTopButton.classList.add('show');
            } else {
                backToTopButton.classList.remove('show');
            }
        };

        backToTopButton.addEventListener('click', function() {
            window.scrollTo({top: 0, behavior: 'smooth'});
        });
    }

    // --- Theme Toggle Functionality (Custom Class Method) ---
    const themeToggleButton = document.getElementById('theme-toggle-btn');
    const bodyElement = document.body; 
    const moonIcon = document.getElementById('theme-icon-moon');
    const sunIcon = document.getElementById('theme-icon-sun');

    function applyTheme(theme) {
        if (theme === 'dark') {
            bodyElement.classList.add('dark-mode');
            if(moonIcon) moonIcon.style.display = 'none';
            if(sunIcon) sunIcon.style.display = 'inline-block';
        } else {
            bodyElement.classList.remove('dark-mode');
            if(moonIcon) moonIcon.style.display = 'inline-block';
            if(sunIcon) sunIcon.style.display = 'none';
        }
    }

    const savedTheme = localStorage.getItem('mshCustomTheme'); 
    if (savedTheme) {
        applyTheme(savedTheme);
    } else {
        // Default to light theme or check system preference
        // if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        //    applyTheme('dark');
        // } else {
           applyTheme('light'); 
        // }
    }

    if (themeToggleButton) {
        themeToggleButton.addEventListener('click', function() {
            if (bodyElement.classList.contains('dark-mode')) {
                applyTheme('light');
                localStorage.setItem('mshCustomTheme', 'light');
            } else {
                applyTheme('dark');
                localStorage.setItem('mshCustomTheme', 'dark');
            }
        });
    }
});
