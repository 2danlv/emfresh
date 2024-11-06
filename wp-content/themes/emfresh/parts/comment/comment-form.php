<?php 
$data = wp_unslash($_GET);
if(!empty($data['message']) && !empty($data['expire']) && intval($data['expire']) > time()) {
    echo '<p style="color: red">'. site_base64_decode($data['message']) .'</p>';
}
?>
<form action="<?php the_permalink() ?>" method="post" enctype="multipart/form-data" class="js-comment-form" id="editcomment">
    <div class="binhluan-moi">
        <div class="box-right">
            <div class="form-group">
                <input type="text" name="comment" maxlength="65525" class="form-control comment-box" placeholder="Viết bình luận">
            </div>
            <button class="btn-common-fill" type="submit" name="submit" value="submit">Send</button>
        </div>
        <input type="hidden" name="url" value="<?php the_permalink() ?>" />
        <input type="hidden" name="comment_post_ID" value="<?php the_ID() ?>" />
        <input type="hidden" name="comment_parent" value="0" />
        <input type="hidden" name="comment_ID" value="0" />
        <?php wp_nonce_field( 'comtoken', 'comtoken' ); ?>
    </div>
</form>