<?php

/**
 * Template Name: Testing
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

function site_testing_submit()
{
	// Check if the form is submitted and handle the submission
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_post'])) {

		$nickname = sanitize_text_field($_POST['nickname']);
		$fullname = sanitize_text_field($_POST['fullname']);
		$phone = sanitize_text_field($_POST['phone']);
		$address = sanitize_text_field($_POST['address']);
		$gender_post = sanitize_text_field($_POST['gender']);
		$status_post = sanitize_text_field($_POST['status']);
		$tag_post = sanitize_text_field($_POST['tag']);
		$point = sanitize_text_field($_POST['point']);
		$note = sanitize_textarea_field($_POST['note']);
		$id = intval($_POST['id']);

		$data = [
			'nickname' => $nickname,
			'fullname' => $fullname,
			'phone' => $phone,
			'status' => $status_post,
			'gender' => $gender_post,
			'note' => $note,
			'tag' => $tag_post,
			'point' => $point,
			'address' => $address,
		];

		if($id > 0) {
			$data['id'] = $id;

			$response = em_api_request('customer/update', $data);
		} else {
			$response = em_api_request('customer/add', $data);
		}

		$url = get_permalink();
		if($response['code'] != 200) {
			$url = add_query_arg($response, $url);
		}

		wp_redirect($url);
		exit();
	}
}
add_action('wp', 'site_testing_submit');

$current_user = wp_get_current_user();
if (in_array('administrator', $current_user->roles) == false) {
	// do something
	wp_redirect(home_url());
	exit();
}

get_header("customer");
// Start the Loop.

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
		<?php
			if(!empty($_GET['edit']) || isset($_GET['add'])) {
				get_template_part( 'parts/test/cusomer', 'form' );
			} else {
				get_template_part( 'parts/test/cusomer', 'list' );
			}
		?>
	</section>
	<!-- /.content -->
</div>
<?php
get_footer('customer');