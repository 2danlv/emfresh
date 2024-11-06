<?php

extract(shortcode_atts([
    'comment' => false
], (array) $args));

if (is_object($comment)) :

?>
    <div class="row row-comment<?php echo $comment->comment_approved == 0 ? 'status-trash' : '' ?>">
        <div class="col-md-3 avatar-cmt">
            <p>Author: <?php echo $comment->comment_author ?></p>
            <p>Status: <?php echo $comment->comment_approved ?></p>
            <div class="time"><?php echo get_comment_date('d/m/Y', $comment->comment_ID) ?></div>
        </div>
        <div class="col-md-9 box-right">
            <div class="comment_content"><?php echo $comment->comment_content ?></div>
            <p>
                <a href="<?php echo site_comment_get_delete_link($comment->comment_ID) ?>">Delete</a>
                |
                <a href="#editcomment" data-id="<?php echo $comment->comment_ID ?>">Edit</a>
            </p>
        </div>
    </div>
<?php

endif;
