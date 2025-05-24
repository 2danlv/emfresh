<?php
function main_wp_head_seo() {
	global $post;
	if( empty($post) ) return ;

	if( $post->post_type == 'attachment' ) {
		$attachment_id = $post->ID;
	} else {
		$attachment_id = get_post_thumbnail_id( $post->ID );
	}
	$image_url = get_field('json_og_img');
  if($image_url == '') {
    // $image_url = site_get_assets('img/tomysstar_ogp.jpg');
    $image_url = 'https://m-a.mynavi.jp/assets/images/service/ogp.jpg';
  }
	$meta = array();
	
	$title = $post->post_title;
	$keyword = '';
	$desc = '東京、世田谷・吉祥寺・調布・府中エリアを中心に美容室を運営するTOMY’S STAR（トミーズ・スター）は、あなたの「キレイ」をプロデュースするサロンです。';
	$title = get_field('json_meta_title') ? get_field('json_meta_title') : $title;
	$desc = get_field('json_meta_description') ? get_field('json_meta_description') : $desc;
	$keyword = get_field('json_meta_key') ? get_field('json_meta_key') : $keyword;
	
	$title_og = get_field('og_title');
	$desc_og = get_field('og_description');
	if ( get_field('json_meta_title') !='' && get_field('og_title') =='' || (get_field('json_meta_title') =='' && get_field('og_title') =='')) {
		$title_og = $title;
	}
	if ( get_field('json_meta_description') !='' && get_field('og_description') =='' || (get_field('json_meta_description') =='' && get_field('og_description') =='')) {
		$desc_og = $desc;
	}
	if (is_singular() && !is_page()) {
		$meta[] = '<meta property="og:type" content="article">';
	} else {
		$meta[] = '<meta property="og:type" content="website">';
	}
	
	$meta[] = '<meta name="description" content="'. wp_trim_words($desc,10000) .'" />';
  $meta[] = '<meta name="keywords" content="'. wp_trim_words($keyword,10000) .'">';
	$meta[] = '<meta property="og:url" content="'.get_permalink().'" />';
	$meta[] = '<meta property="og:title" content="'.$title_og.'|'.get_bloginfo('description').'" />';
	$meta[] = '<meta property="og:description" content="'. wp_trim_words($desc_og,10000) .'" />';
	$meta[] = '<meta property="og:image" content="'.$image_url.'" />';

	echo implode("\n", $meta ) ."\n";
}
add_action('wp_head', 'main_wp_head_seo');

add_filter( 'pre_get_document_title', function ($title) {

  if( is_404() ) {
    $title = get_bloginfo('name') . '｜' . get_bloginfo('description'); 
    return $title;
  }

  global $post;
  
  $title = $post->post_title;

  $title = get_field('json_meta_title') ? get_field('json_meta_title') : $title;

  $title_og = '';
  
  if( is_front_page() ) {
    $title_og = get_field('json_meta_title');
    if( get_field('json_meta_title') == '' ) {
      $title_og = get_bloginfo('name') . '｜' . get_bloginfo('description');
    }
  } else {
    $title_og = $title;
  }
  
  return $title_og;
}, 10 );
