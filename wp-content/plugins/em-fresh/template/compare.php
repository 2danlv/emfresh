<?php

$history = $page->get_item($compare_id);

$fields = $page->get_model($id);

unset($fields['parent']);

?>
<div class="row mt-3">
    <h1 class="col-sm-6">Compare</h1>
    <div class="col-sm-6">
        <a class="btn btn-success" href="<?php echo add_query_arg(['id' => $id], $page_url) ?>">Back to edit</a>
    </div>
</div>
<table class="table mt-3">
    <thead>
        <tr>
            <th scope="col">Field</th>
            <th scope="col">Current</th>
            <th scope="col">History</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            foreach($fields as $key => $input):
                $value = isset($history[$key]) ? $history[$key] : '';
        ?>
        <tr>
            <th scope="row"><?php echo $input['label'] ?></th>
            <td><?php echo $input['value'] ?></td>
            <td <?php echo $input['value'] != $value ? 'class="bg-warning"' : '' ?>><?php echo $value ?></td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>