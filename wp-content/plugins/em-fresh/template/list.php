<?php

$items = $page->get_items();

?>
<div class="row mt-3">
    <h1 class="col-sm-6"><?php echo $title ?></h1>
    <div class="col-sm-6">
        <a class="btn btn-success" href="<?php echo add_query_arg(['action' => 'new'], $page_url) ?>">Add New</a>
    </div>
</div>
<table class="table mt-3">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Title</th>
            <th scope="col">Parent</th>
            <th scope="col">Created</th>
            <th scope="col">Modified</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            if($items && count($items)>0)
                foreach($items as $i => $item):
                    $title = '';
                    if(!empty($item['title'])) {
                        $title = $item['title'];
                    } else if(!empty($item['name'])) {
                        $title = $item['name'];
                    } else if(!empty($item['fullname'])) {
                        $title = $item['fullname'];
                    } else if(!empty($item['nickname'])) {
                        $title = $item['nickname'];
                    }
        ?>
        <tr>
            <th scope="row"><?php echo $item['id'] ?></th>
            <td>
                <a href="<?php echo add_query_arg(['id' => $item['id']], $page_url) ?>"><?php echo $title ?></a>
            </td>
            <td><?php echo $item['parent'] ?></td>
            <td><?php echo $item['created'] ?></td>
            <td><?php echo $item['modified'] ?></td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>