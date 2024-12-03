<?php

extract(shortcode_atts([
    'comments' => []
], (array) $args));

?>
<div class="comment-childs">
<?php
foreach ($comments as $comment) :
    if (count($comment->childs) == 0) continue;

?>
    <div class="modal fade modal-history" id="modal-history<?php echo $comment->comment_ID ?>">
        <div class="overlay"></div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body pt-16">
                    <div class="note-wraper">
                        <?php foreach ($comment->childs as $child) : ?>
                            <div class="js-comment-row pb-16">
                                <div class="row row-comment">
                                    <div class="account-name d-f ai-center col-9">
                                        <div class="avatar">
                                            <img src="<?php echo get_avatar_url($child->user_id); ?>" alt="" width="40">
                                        </div>
                                        <div><?php echo $child->comment_author ?></div>
                                    </div>
                                    <div class="time col-3 text-right"><?php echo get_comment_date('d/m/Y', $child->comment_ID) ?></div>
                                </div>
                                <div class="note-content cap-nhat">
                                    <span class="comment_content"><?php echo nl2br($child->comment_content) ?></span>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-right pt-16 pr-16">
                <button type="button" class="btn btn-secondary modal-close">Đóng</button>
            </div>
        </div>
    </div>
<?php
endforeach;
?>
</div>