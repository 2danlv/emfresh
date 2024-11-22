<?php

/**
 * The template used for displaying single content
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

$args = array(
	'type' => 'customer',
	'status' => 'any', // 'any', 'pending', 'approve'
	'post_id' => get_the_ID(),  // Use post_id, not post_ID, fwHR58J87Xc503mt1S
	'parent' => 0,
	'order' => 'ASC',
	// 'number' => 5,
);

$comments = get_comments($args);

?>
<div class="comments" id="comments">
	<p>Comments</p>
	<?php
	foreach ($comments as $comment) {
		get_template_part('parts/comment/comment', 'item', [
			'comment' => $comment
		]);
	}

	get_template_part('parts/comment/comment', 'form');
	?>
</div>
<script>
	var editcomment = document.getElementById('editcomment');
	if(editcomment) {
		document.querySelectorAll('.row-comment').forEach(row => {
			row.querySelector('a[href="#editcomment"]').addEventListener('click', function() {
				let id = this.dataset['id'] || 0;

				if(id > 0) {
					editcomment['comment'].value = row.querySelector('.comment_content').innerText;
					editcomment['comment_ID'].value = id;
				}
			})
		})
	}
</script>