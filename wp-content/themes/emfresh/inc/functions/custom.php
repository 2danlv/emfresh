<?php

function site_admin_notices()
{
	if (function_exists('the_field') == false):
?>
		<div class="notice notice-success is-dismissible">
			<p><b><?php _e('Please install and active `Advanced Custom Fields` plugin!', 'site'); ?></b></p>
		</div>
	<?php
	endif;
}
// add_action( 'admin_notices', 'site_admin_notices' );

function site_the_custom_field($key = '', $term_alias = '', $default = null)
{
	if (function_exists('the_field')) {
		return the_field($key, $term_alias, $default);
	}

	echo site_get_custom_field($key, $term_alias, $default);
}

function site_get_custom_field($key = '', $term_alias = '', $default = '')
{
	if (function_exists('get_field')) {
		return get_field($key, $term_alias, $default);
	}

	if ($key  == '' || $term_alias  == '') return $default;

	$value = $default;

	$term_alias = explode('_', $term_alias);

	if (count($term_alias) == 2) {
		$term_id = (int) end($term_alias);
	} else {
		$term_id = (int) $term_alias[0];
	}

	$single = is_array($default) == false;

	if ($term_id > 0) {
		$value = get_term_meta($term_id, $key, $single);
	}

	if (is_numeric($default)) {
		$value = intval($value);
	}

	return $value;
}

function site_check_empty__get()
{
	if (count($_GET)) {
		foreach ($_GET as $value) {
			$value = sanitize_text_field($value);
			if ($value != '') {
				return false;
			}
		}
	}

	return true;
}

function site__get($name = '', $default = '')
{
	$value = $default;

	if (isset($_GET[$name])) {
		$value = sanitize_text_field($_GET[$name]);
		if (is_numeric($default)) {
			$value = (int) $value;
		}
	}

	return $value;
}

function site__post($name = '', $default = '')
{
	$value = $default;

	if (isset($_POST[$name])) {
		$value = sanitize_text_field($_POST[$name]);
		if (is_numeric($default)) {
			$value = (int) $value;
		}
	}

	return $value;
}

function site__post_e($name = '', $default = '')
{
	echo site__post($name, $default);
}

function site_remove_to_tel($value = '')
{
	return str_replace(array('+', '-', '(', ')', ' ', '[', ']'), '', $value);
}

function site_get_pagination($page_active = 0, $total = 0, $limit = 9, $link = '#')
{
	if ($page_active == 0) {
		$page_active = 1;
	}
	$end 	= round($total / $limit + 0.4, 0);

	if ($end < 2) {
		return '';
	}

	$number_pages = 5; // 10 page - set max: 9;


	$start 	= $page_active - intval($number_pages / 2);
	if ($start + $number_pages > $end) {
		$start = $end - $number_pages + 1;
	}
	if ($start < 1) {
		$start = 1;
	}

	$prev	= $page_active - 1;
	if ($prev < 1) {
		$prev = 1;
	}
	$next	= $page_active + 1;
	if ($next > $end) {
		$next = $end;
	}
	$stop 	= $start + $number_pages - 1;
	if ($stop > $end) {
		$stop = $end;
	}

	$sp = '?';
	if (count($_GET)) {
		$parts = array();
		foreach ($_GET as $k => $v) {
			if ($v != '' && in_array($k, array('list', 'act')) == false) {
				$parts[] = $k . '=' . $v;
			}
		}
		if (count($parts)) {
			$link .= '?' . implode('&', $parts);
			$sp = '&';
		}
	}

	$html = '';

	$html .= '<nav aria-label="Page navigation">';
	$html .= '<ul class="pagination justify-content-center">';

	if ($end > $number_pages && $page_active > 1) {
		$html .= '<li class="item"><a class="link" href="' . $link . '" aria-label="Start"><i class="fas fa-long-arrow-alt-left color-arrow"></i></a></li>';

		// $html .= '<li class="item"><a class="link" href="'.$link.$sp.'list='.$prev.'" aria-label="Previous"><i class="fas fa-long-arrow-alt-left color-arrow"></i></a></li>';
	}

	for ($page = $start; $page <= $stop; $page++) {
		$html .= '<li class="item' . ($page == $page_active ? ' active' : '') . '"><a class="link" href="' . $link . ($page > 1 ? $sp . 'list=' . $page : '') . '">' . $page . '</a></li>';
	}

	if ($end > $number_pages && $end > $page_active) {
		//$html .= '<li class="item"><a class="link" href="'.$link.$sp.'list='.$next.'" aria-label="Next"><i class="fas fa-long-arrow-alt-right color-arrow"></i></a></li>';

		$html .= '<li class="item"><a class="link" href="' . $link . $sp . 'list=' . $end . '" aria-label="End"><i class="fas fa-long-arrow-alt-right color-arrow"></i></a></li>';
	}

	$html .= '</ul>';
	$html .= '</nav>';

	// $html .= '<span class="page-in-total">Page '.$page_active.'/'.$end.'</span>';

	return $html;
}

function site_cache($type = 'get', $key = '', $value = '')
{
	global $site_cache;

	if ($key == '') return $value;

	if (is_object($key)) {
		$key = get_object_vars($key);
	}

	if (is_array($key)) {
		ksort($key);
		$key = md5(json_encode($key));
	} else if (is_string($key) == false) {
		return $value;
	}

	if ($type == 'set') {
		$site_cache[$key] = $value;
	} else if (is_array($site_cache) && isset($site_cache[$key])) {
		return $site_cache[$key];
	}

	return $value;
}

function site_check_duplicate_meta($key = '', $value = '')
{
	if ($key == '' ||  $value == '') return $value;

	global $wpdb;

	$count = (int) $wpdb->get_var(" SELECT count(*) "
		. " FROM `$wpdb->postmeta` "
		. " WHERE `meta_key` = '$key' "
		. " AND `meta_value` LIKE '{$value}%' ");
	if ($count > 0) {
		$value .= '-' . ($count + 1);
		return site_check_duplicate_meta($key, $value);
	}

	return $value;
}

function get_all_custom_fields($post)
{
	$custom_field_keys = get_post_custom_keys($post->ID);
	if (is_array($custom_field_keys) && count($custom_field_keys)) {
		foreach ($custom_field_keys as $i => $meta_key) {
			$valuet = trim($meta_key);
			if ('_' == substr($valuet, 0, 1))
				continue;

			$post->$meta_key = get_post_meta($post->ID, $meta_key, true);
		}
	}

	return $post;
}

function site_category_pagination()
{
	global $wp_query, $wp_rewrite;

	// Don't print empty markup if there's only one page.
	if ($wp_query->max_num_pages < 2) {
		return;
	}

	$paged        = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
	$pagenum_link = html_entity_decode(get_pagenum_link());
	$query_args   = array();
	$url_parts    = explode('?', $pagenum_link);

	if (isset($url_parts[1])) {
		wp_parse_str($url_parts[1], $query_args);
	}

	$pagenum_link = remove_query_arg(array_keys($query_args), $pagenum_link);

	$total = (int) $wp_query->found_posts;

	$limit = (int) $wp_query->get('posts_per_page');

	$html = site_get_pagination($paged, $total, $limit, $pagenum_link);

	$html = str_replace('?list=', 'page/', $html);

	echo $html;
}

function site_post_link($permalink = '', $post = null)
{
	if ($post != null && function_exists('get_field')) {
		$external_url = get_field('external_url', $post);
		if ($external_url != '') {
			return $external_url;
		}
	}

	return $permalink;
}
// add_filter( 'post_link', 'site_post_link', 10, 99 );

function site_get_placeimage_url($width = 400, $height = 300, $color = '000', $bg = 'fff')
{
	// Random image
	// $src = "https://placeimg.com/{$width}/{$height}/{$text}";

	// Image - Color - Background;
	$src = "https://dummyimage.com/{$width}x{$height}/{$color}/{$bg}&text=+";

	return $src;
}

function site_the_placeimage_url($width = 400, $height = 300, $color = '#000', $bg = '#fff')
{
	echo site_get_placeimage_url($width, $height, $color, $bg);
}

function site_get_template_part($slug = '', $args = array(), $arg2s = array())
{
	global $wp_query;

	if ($slug == '') return;

	$name = null;

	if (is_string($args)) {
		$name = $args;
		$args = $arg2s;
	}
	$part = $slug . ($name != null ? ',' . $name : '');

	$key = 'site_params';

	$wp_query->set($key, (array) $args);

	// Set 1 if you want show comment to dev
	$comment = WP_DEBUG && WP_DEBUG_DISPLAY;

	echo $comment ? "<!--  BEGIN OF PART ($part) -->" : '';

	// function of WP Core
	get_template_part($slug, $name);

	echo $comment ? "<!--  END OF PART ($part) -->" : '';

	$wp_query->set($key, array());
}

function site_get_current_url($has_query_string = true)
{
	$s 		  = $_SERVER;
	$ssl      = (! empty($s['HTTPS']) && $s['HTTPS'] == 'on');
	$sp       = strtolower($s['SERVER_PROTOCOL']);
	$protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
	$port     = $s['SERVER_PORT'];
	$port     = ((! $ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;
	$host     = isset($s['HTTP_X_FORWARDED_HOST']) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
	$host     = isset($host) ? $host : $s['SERVER_NAME'] . $port;

	$uri	=  $s['REQUEST_URI'];
	if ($has_query_string == false) {
		$uris = explode('?', $uri);
		$uri = $uris[0];
	}

	return esc_url($protocol . '://' . $host . $uri);
}

function site_fb_share_url($url = '')
{
	if ($url == '') {
		$url = site_get_current_url();
	}

	return 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($url) . '&amp;src=sdkpreparse';
}

function site_twitter_share_url($url = '', $args = array())
{
	if ($url == '') {
		$url = site_get_current_url();
	}

	$text = str_replace('  ', ' ', html_entity_decode(wp_title(' ', false)));

	$args = shortcode_atts(array(
		'original_referer' => $url,
		'url' 		=> $url,
		// 'via' 		=> '',
		'tw_p' 		=> 'tweetbutton',
		'ref_src' 	=> 'twsrc',
		'related' 	=> 'twitterapi',
		'text' 		=> $text,
	), (array) $args);

	return 'https://twitter.com/intent/tweet?' . http_build_query($args, '', '&amp;');
}

// remove all emojis
function disable_wp_head_core()
{
	// emoji
	remove_action('wp_head',             'print_emoji_detection_script', 7);
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');

	// wp_head_core
	remove_action('wp_head',             '_wp_render_title_tag',            1);
	// remove_action( 'wp_head',             'wp_enqueue_scripts',              1     );
	remove_action('wp_head',             'wp_resource_hints',               2);
	remove_action('wp_head',             'feed_links',                      2);
	remove_action('wp_head',             'feed_links_extra',                3);
	remove_action('wp_head',             'rsd_link');
	remove_action('wp_head',             'wlwmanifest_link');
	remove_action('wp_head',             'adjacent_posts_rel_link_wp_head', 10, 0);
	remove_action('wp_head',             'locale_stylesheet');
	remove_action('wp_head',             'noindex',                          1);
	// remove_action( 'wp_head',             'wp_print_styles',                  8    );
	// remove_action( 'wp_head',             'wp_print_head_scripts',            9    );
	remove_action('wp_head',             'wp_generator');
	// remove_action( 'wp_head',             'rel_canonical'                          );
	remove_action('wp_head',             'wp_shortlink_wp_head',            10, 0);
	remove_action('wp_head',             'wp_custom_css_cb',                101);
	remove_action('wp_head',             'wp_site_icon',                    99);

	// Disable REST API link tag
	remove_action('wp_head', 'rest_output_link_wp_head', 10);

	// Disable oEmbed Discovery Links
	remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);

	// Disable REST API link in HTTP headers
	remove_action('template_redirect', 'rest_output_link_header', 11, 0);
}
add_action('init', 'disable_wp_head_core');

// disable checked ontop category
add_filter('wp_terms_checklist_args', function ($args) {
	$args['checked_ontop'] = false;
	return $args;
});

function site_shortcode_atts_sanitize_text_field($out)
{
	$out = (array) $out;

	if (count($out)) {
		foreach ($out as $name => $value) {
			$out[$name] = sanitize_text_field($value);
		}
	}

	return $out;
}
add_filter('shortcode_atts_sanitize_text_field', 'site_shortcode_atts_sanitize_text_field', 10, 2);

function site_replace_content_has_youtube($content = '')
{
	if ($content != '' && preg_match_all('/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $content, $matches, PREG_PATTERN_ORDER) > 0) {

		// Youtube
		foreach ($matches[0] as $match) {
			if (preg_match('/(youtu\.be\/|youtube)/i', $match)) {
				$content = str_replace($match, '<div class="video-responsive">' . $match . '</div>', $content);
			}
		}
	}

	return $content;
}
add_filter('the_content', 'site_replace_content_has_youtube', 10, 1);

function site_get_target($url = '', $type = 'full')
{
	$target = '';
	if ($url != '' && preg_match('/' . $_SERVER['HTTP_HOST'] . '/', $url) == false) {
		$target = '_blank';
		if ($type == 'full') {
			$target = ' target="' . $target . '" ';
		}
	}

	return $target;
}
// rename file upload unicode to number

function sanitize_file_uploads($file)
{
	$get_file_name['name'] = sanitize_file_name($file['name']);
	$file['name'] = preg_replace("/[^a-zA-Z0-9\_\-\.]/", '', $get_file_name['name']);
	$file['name'] = strtolower($file['name']);
	$info = pathinfo($file['name']);

	add_filter('sanitize_file_name', 'remove_accents');

	if (preg_match('/[^\x20-\x7e]/', $get_file_name['name'])) {
		$file['name'] = sprintf('%s.%s', current_time('Ymd-His'), $info['extension']);
		return $file;
	} else {
		return $file;
	}
}
add_filter('wp_handle_upload_prefilter', 'sanitize_file_uploads');

// disable FullscreenMode
if (is_admin()) {
	function jba_disable_editor_fullscreen_by_default()
	{
		$script = "jQuery( window ).load(function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } });";
		wp_add_inline_script('wp-blocks', $script);
	}
	add_action('enqueue_block_editor_assets', 'jba_disable_editor_fullscreen_by_default');
}

// site_auto_update_scheduled
function site_auto_update_scheduled()
{
	$posts = get_posts(array(
		'post_type' => array('post', 'page'),
		'post_status' => 'future',
		'date_query' => array('before' => $t = current_time('mysql'))
	));
	if (count($posts)) {
		foreach ($posts as $p) {
			wp_update_post(array(
				'ID' => $p->ID,
				'post_status' => 'publish'
			));
		}
	}
}
add_action('init', 'site_auto_update_scheduled');
//
function custom_location_meta_box()
{
	add_meta_box(
		'custom_location_meta_box',
		'Information',
		'custom_location_meta_box_callback',
		'customer',
		'normal',
		'default'
	);
}
add_action('add_meta_boxes', 'custom_location_meta_box');


function custom_location_meta_box_callback($post)
{

	$post_id = get_the_ID();

	$post = get_post($post_id);
	$locations = get_post_meta($post_id, 'location', false);

	$fullname = get_post_meta($post_id, 'fullname', true);
	$phone = get_post_meta($post_id, 'phone', true);
	$gender = get_post_meta($post_id, 'gender', true);
	$status = get_post_meta($post_id, 'status', true);
	$tag = get_post_meta($post_id, 'tag', true);
	$point = get_post_meta($post_id, 'point', true);


	if (!is_array($locations)) {
		$locations = array();
	}
	?>

	<!-- Location Fields -->
	<div id="location-fields">
		<p>Full Name: <?php echo esc_html($fullname); ?></p>
		<p>Phone: <?php echo esc_html($phone); ?></p>
		<p>Gender: <?php echo esc_html($gender); ?></p>
		<p>Status: <?php echo esc_html($status); ?></p>
		<p>Tag: <?php echo esc_html($tag); ?></p>
		<p>Points: <?php echo esc_html($point); ?></p>
		<?php
		if (!empty($locations)) {
			foreach ($locations as $index => $location) {

				$address = isset($location['address']) ? esc_attr($location['address']) : '';
				$province = isset($location['province']) ? esc_attr($location['province']) : '';
				$district = isset($location['district']) ? esc_attr($location['district']) : '';
				$ward     = isset($location['ward']) ? esc_attr($location['ward']) : '';
		?>
				<div class="location-group">
					<p>Addess <?php echo $index + 1; ?>: <?php echo $address; ?>, <?php echo $ward; ?>, <?php echo $district; ?>, <?php echo $province; ?></p>
				</div>
		<?php
			}
		}
		?>
	</div>

<?php

}


function save_custom_location_meta_box($post_id)
{

	if (!isset($_POST['locations'])) {
		return;
	}


	$locations = array();
	foreach ($_POST['locations'] as $location) {
		$locations[] = array(
			'province' => sanitize_text_field($location['province']),
			'district' => sanitize_text_field($location['district']),
			'ward'     => sanitize_text_field($location['ward']),
		);
	}


	update_post_meta($post_id, 'location', $locations);
}

function custom_location_column_content($column, $post_id)
{
	if ($column === 'locations') {
		$locations = get_post_meta($post_id, 'location', true);

		if (!empty($locations)) {
			foreach ($locations as $location) {
				echo esc_html($location['province']) . ', ' . esc_html($location['district']) . ', ' . esc_html($location['ward']) . '<br>';
			}
		} else {
			echo 'No locations';
		}
	}
}
add_action('manage_post_posts_custom_column', 'custom_location_column_content', 10, 2);

function custom_ucwords_utf8($str)
{
	return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
}

function custom_get_list_cook()
{
	return ['Không', 'Chỉ Khăn Lạnh', 'Chỉ Dụng Cụ'];
}

function custom_get_list_notes()
{
	return ['Không Cà Rốt', 'Không Hành'];
}

function custom_get_list_payment_status()
{
	return [
		'Đang Chờ' => 'Đang Chờ',
		'Đang Xử Lý' => 'Đang Xử Lý',
		'Đã Thanh Toán' => 'Đã Thanh Toán',
		'Đang Vận Chuyển' => 'Đang Vận Chuyển',
		'Hoàn Thành' => 'Hoàn Thành',
		'Hủy' => 'Hủy',
	];
}

function custom_get_list_by_key($list = [], $key = '')
{
	$items = [];

	foreach ($list as $item) {
		if (isset($item[$key])) {
			$items[] = $item[$key];
		}
	}

	return $items;
}

// Allow SVG
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {

	global $wp_version;
	if ( $wp_version !== '4.7.1' ) {
	   return $data;
	}
  
	$filetype = wp_check_filetype( $filename, $mimes );
  
	return [
		'ext'             => $filetype['ext'],
		'type'            => $filetype['type'],
		'proper_filename' => $data['proper_filename']
	];
  
  }, 10, 4 );
  
  function cc_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
  }
  add_filter( 'upload_mimes', 'cc_mime_types' );
  
  function fix_svg() {
	echo '<style type="text/css">
		  .attachment-266x266, .thumbnail img {
			   width: 100% !important;
			   height: auto !important;
		  }
		  </style>';
  }
  add_action( 'admin_head', 'fix_svg' );