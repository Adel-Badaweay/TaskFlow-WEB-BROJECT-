<?php
require_once(__DIR__ . '/includes/config.php');
require_once(__DIR__ . '/includes/functions.php');

if (!isLoggedIn()) {
    redirect(SITE_URL . '/auth/login.php');
}

$page_title = "فريق العمل";
include(__DIR__ . '/includes/header.php');
?>

<section class="team-section">
    <div class="container">
        <div class="section-header center">
            <h1>فريق العمل</h1>
            <p>تعرف على أعضاء فريقنا المتميز</p>
        </div>
        
        <div class="team-members">
            <div class="team-member">
                <div class="member-photo">
                    <img src="<?php echo SITE_URL; ?>/assets/images/team3.jpg" alt="أحمد محمد">
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
               
                </div>
            </div>
            
            <!-- ... (الكود السابق حتى عرض الفريق) ... -->

<div class="team-members">
    <div class="team-member">
        <div class="member-photo">
            <img src="<?php echo SITE_URL; ?>/assets/images/team7.jpg" alt="Adel">
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
        <div class="member-info">
            <h3>Adel</h3>
            <p class="position"> 1</p>
            <p class="bio">   سكشن 6 إشراف بشمهندس محمد أشرف    </p>
            <div class="contact-info">
                <p><i class="fas fa-phone"></i> 0</p>
                <p><i class="fas fa-envelope"></i> 0</p>
            </div>
        </div>
    </div>
    
    <div class="team-member">
        <div class="member-photo">
            <img src="<?php echo SITE_URL; ?>/assets/images/team2.jpg" alt="Mohamed">
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
        <div class="member-info">
            <h3>Mohamed</h3>
            <p class="position">2  </p>
            <p class="bio"> سكشن 6 بشمهندس محمد أشرف</p>
            <div class="contact-info">
                <p><i class="fas fa-phone"></i> 0</p>
                <p><i class="fas fa-envelope"></i> 0</p>
            </div>
        </div>
    </div>
    
    <div class="team-member">
        <div class="member-photo">
            <img src="<?php echo SITE_URL; ?>/assets/images/team5.jpg" alt="Menna">
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
        <div class="member-info">
            <h3>Menna</h3>
            <p class="position">3  </p>
            <p class="bio">   سكشن 6 إشراف بشمهندس محمد أشرف    </p>
            <div class="contact-info">
                <p><i class="fas fa-phone"></i>0</p>
                <p><i class="fas fa-envelope"></i>0</p>
            </div>
        </div>
    </div>
</div>

<!-- ... (باقي الكود) ... -->
                </div>
            </div>
        </div>
    </div>
</section>

<?php include(__DIR__ . '/includes/footer.php'); ?>