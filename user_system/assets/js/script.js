document.addEventListener('DOMContentLoaded', function() {
    // القائمة المتنقلة
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const mobileMenu = document.querySelector('.mobile-menu');
    const closeMenuBtn = document.querySelector('.close-menu-btn');
    
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.add('show');
        });
        
        closeMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.remove('show');
        });
    }
    
    // إغلاق القائمة عند النقر على رابط
    const mobileLinks = document.querySelectorAll('.mobile-menu a');
    mobileLinks.forEach(link => {
        link.addEventListener('click', function() {
            mobileMenu.classList.remove('show');
        });
    });
    
    // القائمة المنسدلة للمستخدم
    const userBtn = document.querySelector('.user-btn');
    if (userBtn) {
        userBtn.addEventListener('click', function() {
            const dropdown = this.nextElementSibling;
            dropdown.classList.toggle('show');
        });
        
        // إغلاق عند النقر خارج القائمة
        window.addEventListener('click', function(e) {
            if (!e.target.matches('.user-btn') && !e.target.closest('.user-dropdown')) {
                const dropdowns = document.querySelectorAll('.dropdown-content');
                dropdowns.forEach(dropdown => {
                    dropdown.classList.remove('show');
                });
            }
        });
    }
    
    // إظهار رسائل التنبيه لمدة 5 ثواني
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.style.display = 'none';
            }, 500);
        }, 5000);
    });
});