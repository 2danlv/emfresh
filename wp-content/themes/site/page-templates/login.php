<?php

/**
 * Template Name: Login
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

if (get_current_user_id() > 0) {
    wp_redirect(home_url());
    exit();
}

get_header('login');

$referer = home_url();
if (!empty($_GET['referer'])) {
    $referer = $_GET['referer'];
}

// Start the Loop.
while (have_posts()) : the_post();
?>
    <div class="login-page">
        <!-- Content Header (Page header) -->
         

        <!-- Main content -->

     <div class="text-center">
        <p><img src="/assets/dist/img/emfresh_logo.jpg" width="100px" alt=""></p>
     </div>
        
            <div class="login-box">

                <div class="card card-outline card-primary">
                    <div class="card-header text-center">
                        <h1 class="h1">Login to <b class="text-success">em.fresh</b></h1>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_GET['login']) && trim($_GET['login']) == 'error') : ?>
                            <div class="auto-hide login-box-msg" style="color: red; line-height: 22px;">Vui lòng nhập đúng thông tin</div>
                            <?php endif; ?>
                        <form action="<?php the_permalink() ?>" method="post" id="quickForm">
                            <div class="input-group mb-3">
                                <input type="email" name="uname" class="form-control" id="uname" placeholder="Nhập email" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" name="upass" class="form-control" id="upass" placeholder="Mật khẩu">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-7">
                                    <!-- <div class="icheck-primary">
                                        <input type="checkbox" id="remember">
                                        <label for="remember">
                                            Remember Me
                                        </label>
                                    </div> -->
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                                </div>
                                <?php wp_nonce_field('logtoken', 'logtoken', false); ?>
                                <input type="hidden" name="_wp_http_referer" value="<?php echo esc_url($referer); ?>" />
                            </div>
                        </form>
                        

                        <p class="mb-1">
                            <!-- <a href="forgot-password.html">I forgot my password</a> -->
                        </p>
                        
                    </div>

                </div>

            </div>


            


     
        
        
    </div>
<?php
endwhile;

get_footer('login');
