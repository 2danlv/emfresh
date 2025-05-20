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

$data = wp_unslash($_GET);

$list = [
    'customer',
    'order',
];

$data_name = !empty($data['data_name']) ? trim($data['data_name']) : 'customer';
if(!in_array($data_name, $list)) {
    $url = home_url();

    wp_redirect($url);
    exit();
}

get_header();

// Start the Loop.
// while (have_posts()) : the_post();

// endwhile;
?>
<div class="content-import">
    <!-- Main content -->
    <section class="card-import">
        <div class="card-header">
            <form class="em-importer" data-name="<?Php echo $data_name ?>" action="<?php the_permalink() ?>" method="post">
                <div class="form-group">
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="file" class="custom-file-input js-file" id="exampleInputFile" accept="xls, xlsx">
                            <label class="custom-file-label" for="exampleInputFile">Chọn file .xlsx hoặc .csv</label>
                        </div>
                        <div class="input-group-append">
                            <button type="button" name="action" value="import" class="js-import input-group-text"><img src="<?php echo site_get_template_directory_assets(); ?>img/icon/upload.svg" alt=""> Import</button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <!-- <button type="button" name="action" value="export" class="btn btn-success js-export">Export</button> -->
                </div>
                <?php wp_nonce_field('importoken', 'importoken', false); ?>
            </form>
        </div>
    </section>
    <section class="content">
        <table class="table table-striped js-table-excel">
        </table>
    </section>
</div>
<?php

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