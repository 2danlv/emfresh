<?php

/**
 * Template Name: Login
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

if(get_current_user_id() > 0) {
    wp_redirect(home_url());
    exit();
}

get_header("customer");

$referer = home_url();
if(!empty($_GET['referer'])) {
    $referer = $_GET['referer'];
}

// Start the Loop.
while (have_posts()) : the_post();
?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><?php the_title(); ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active"><?php the_title(); ?></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="form-login">
                <h2>Đăng nhập</h2>
                <form action="./" method="post">
                    <?php if (isset($_GET['login']) && trim($_GET['login']) == 'error') : ?>
                        <div class="auto-hide" style="color: red; line-height: 22px;">Vui lòng nhập đúng thông tin</div>
                    <?php endif; ?>
                    <div class="item-form">
                        <label for="">Tên đăng nhập</label>
                        <input type="text" name="uname" required>
                    </div>
                    <div class="item-form">
                        <label for="">Mật khẩu</label>
                        <input type="password" name="upass" required>
                    </div>
                    <div class="btn-form">
                        <button type="submit">Login</button>
                    </div>
                    <?php wp_nonce_field('logtoken', 'logtoken', false); ?>
                    <input type="hidden" name="_wp_http_referer" value="<?php echo esc_url($referer); ?>" />
                </form>
            </div>
        </section>
    </div>
<?php
endwhile;

get_footer('customer');
