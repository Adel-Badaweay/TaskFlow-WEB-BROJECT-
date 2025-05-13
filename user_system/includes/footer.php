        </main>

        <footer class="main-footer">
            <div class="container">
                <div class="footer-grid">
                    <div class="footer-col">
                        <div class="footer-logo">
                            <img src="<?php echo SITE_URL; ?>/assets/images/logo.png" alt="<?php echo SITE_NAME; ?>">
                            <h3><?php echo SITE_NAME; ?></h3>
                        </div>
                        <p class="footer-slogan"><?php echo SITE_SLOGAN; ?></p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    
                    <div class="footer-col">
                        <h4>روابط سريعة</h4>
                        <ul>
                            <li><a href="<?php echo SITE_URL; ?>">الرئيسية</a></li>
                            <li><a href="<?php echo TASKS_PAGE; ?>">المهام</a></li>
                            <li><a href="<?php echo TIMER_PAGE; ?>">المؤقت</a></li>
                            <li><a href="<?php echo TEAM_PAGE; ?>">فريق العمل</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-col">
                        <h4>حسابك</h4>
                        <ul>
                            <?php if (isLoggedIn()): ?>
                                <li><a href="<?php echo SITE_URL; ?>/profile.php">الملف الشخصي</a></li>
                                <li><a href="<?php echo SITE_URL; ?>/auth/logout.php">تسجيل الخروج</a></li>
                            <?php else: ?>
                                <li><a href="<?php echo SITE_URL; ?>/auth/login.php">تسجيل الدخول</a></li>
                                <li><a href="<?php echo SITE_URL; ?>/auth/register.php">إنشاء حساب</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    
                    <div class="footer-col">
                        <h4>تواصل معنا</h4>
                        <ul class="contact-info">
                            <li><i class="fas fa-map-marker-alt"></i>العنوان: علوم حاسب سكشن 6 </li>
                            <li><i class="fas fa-phone"></i> 0</li>
                            <li><i class="fas fa-envelope"></i> 0</li>
                        </ul>
                    </div>
                </div>
                
                <div class="footer-bottom">
                    <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>.  جميع الحقوق محفوظة. لسكشن 6 </p>
                </div>
            </div>
        </footer>
    </div>

    <script src="<?php echo SITE_URL; ?>/assets/js/script.js"></script>
    <?php if (basename($_SERVER['PHP_SELF']) == 'timer.php'): ?>
        <script src="<?php echo SITE_URL; ?>/assets/js/timer.js"></script>
    <?php endif; ?>
</body>
</html>