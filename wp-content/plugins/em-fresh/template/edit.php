<?php

$fields = $page->get_model($id);

$history_items = $page->get_history($id);

?>
<div class="row mt-3">
    <form class="col-sm-8" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
        <h1><?php echo $title ?></h1>
        <?php if(isset($result) && is_array($result) && count($result) > 0) : ?>
        <div class="alert alert-danger mb-3" role="alert">
            <?php
                foreach($result as $name => $error) {
                    echo "<p>$name : $error</p>";
                }
            ?>
        </div>
        <?php endif;?>
        <?php foreach($fields as $key => $input) : $type = isset($input['type']) ? $input['type'] : 'text'; ?>
        <div class="row mb-3">
            <label for="<?php echo $key ?>" class="col-sm-2 col-form-label"><?php echo $input['label'] ?></label>
            <div class="col-sm-10">
                <?php if($type == 'textarea'): ?>
                <textarea class="form-control" name="<?php echo $key ?>" id="<?php echo $key ?>" <?php echo $input['required'] != '' ? 'required' : '' ?>><?php echo $input['value'] ?></textarea>
                <?php else :?>
                <input type="<?php echo $type ?>" class="form-control" name="<?php echo $key ?>" id="<?php echo $key ?>" value="<?php echo $input['value'] ?>" <?php echo $input['required'] != '' ? 'required' : '' ?>>
                <?php endif?>
            </div>
        </div>
        <?php endforeach; ?>
        <input type="hidden" name="id" value="<?php echo $id ?>" />
        <div class="row mb-3">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="<?php echo $page_url ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
    <div class="col-sm-4">
        <h2>History</h2>
        <?php if(count($history_items)>0) :?>
        <ul>
            <?php foreach($history_items as $item) :?>
            <li>
                <a href="<?php echo add_query_arg(['id' => $id, 'compare_id' => $item['id']], $page_url) ?>"><?php echo $item['fullname'] ;?></a>
                (<?php echo $item['modified'] . ' - ' . $item['modified_at'] ?>)
            </li>
            <?php endforeach;?>
        </ul>
        <?php endif;?>
    </div>
</div>