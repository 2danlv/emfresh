<?php

/**
 * Template Name: Change Password
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

if (get_current_user_id() == 0) {
    wp_redirect(home_url('login'));
    exit();
}

$hide_errer = 'display:none;';
if (isset($_GET['change']) && trim($_GET['change']) == 'error') {
    $hide_errer = '';
}

get_header("customer");

// Start the Loop.
while (have_posts()) : the_post();
?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
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
            <div class="col-md-6 offset-md-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><?php the_title(); ?></h3>
                </div>


                <form id="change-pass-form" action="<?php the_permalink() ?>" method="post">

                    <div class="card-body">
                        <div class="auto-hide row-error" style="<?php echo $hide_errer ?>color: red; line-height: 22px;">Vui lòng nhập đúng thông tin</div>
                        <p class="error-password" style="display: none; color: red; line-height: 22px;">Mật khẩu có ít nhất 8 ký tự (bao gồm số, chữ hoa, chữ thường và ký hiệu)</p>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mật khẩu cũ</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="oldpassword" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword2">Mật khẩu mới</label>
                            <input type="password" class="form-control" id="exampleInputPassword2" placeholder="New Password" name="newpassword" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword3">Xác nhận mật khẩu mới</label>
                            <input type="password" class="form-control" id="exampleInputPassword3" placeholder="Confirm Password" name="confirmpassword" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="btn-form text-center">
                            <button type="submit" class="js-submit btn btn-primary">Cập nhật</button>
                        </div>
                        <?php wp_nonce_field('changeptoken', 'changeptoken', false); ?>
                    </div>
                </form>
            </div>
            </div>
        </section>
    </div>
    <script>
        (function() {
            document.getElementById('change-pass-form').addEventListener('submit', function(event) {
                let errors = []

                let oldpassword = document.querySelector('[name="oldpassword"]');
                let newpassword = document.querySelector('[name="newpassword"]');
                let confirmpassword = document.querySelector('[name="confirmpassword"]');
                let errorpassword = document.querySelector('.error-password');

                if (oldpassword.value == '' || newpassword.value == '' || newpassword.value != confirmpassword.value) {
                    errors.push('passwords');
                }

                document.querySelectorAll('.pattern-password').forEach(item => {
                    const valid = /^[a-zA-Z0-9!@#$%^&*]{8,20}$/.test(item.value);

                    if (valid == false) {
                        errors.push(item.name);
                    }

                    if (errorpassword) {
                        errorpassword.style.display = valid ? 'none' : '';
                    }
                })

                if (errors.length > 0) {
                    event.preventDefault();
                }

                document.querySelector('.row-error').style.display = errors.length > 0 ? '' : 'none';

            }, false);
        })();
    </script>
<?php
endwhile;

get_footer('customer');
