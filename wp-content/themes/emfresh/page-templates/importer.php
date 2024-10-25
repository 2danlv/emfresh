<?php

/**
 * Template Name: Import Export
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

// add_action('wp_enqueue_scripts', function(){
//     wp_enqueue_script('importer', get_template_directory_uri() . '/assets/js/importer.js', ['jquery'], time(), true);
// });

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
                    <div class="card-body">
                        <div class="form-login">
                            <form class="em-importer" data-name="customer" action="<?php the_permalink() ?>" method="post">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="file" class="custom-file-input js-file" id="exampleInputFile" accept="xls, xlsx">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" name="action" value="import" class="btn btn-primary js-import"><i class="fas fa-file-import"></i> Import</button>
                                    <!-- <button type="button" name="action" value="export" class="btn btn-success js-export">Export</button> -->
                                </div>
                                <?php wp_nonce_field('importoken', 'importoken', false); ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <table class="table table-striped js-table-excel">
            </table>
        </section>
    </div>
<?php
endwhile;

global $site_scripts;

if (empty($site_scripts)) $site_scripts = [];

$site_scripts[] = "https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js";
$site_scripts[] = get_template_directory_uri() . '/assets/js/importer.js';

get_footer('customer'); ?>
<script src="/assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
    $(function() {
        bsCustomFileInput.init();
    });
</script>