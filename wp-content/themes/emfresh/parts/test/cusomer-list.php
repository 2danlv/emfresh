<?php

$response = em_api_request('customer/list', []);

$list = $response['data'];

?>
<?php if(count($list) > 0) : ?>
<h3>List</h3>
<table  class="table">
    <?php foreach($list as $item) :?>
    <tr>
        <th><?php echo $item['id'] . ') ' . $item['fullname'] ;?></th>
        <td>
            <a href="<?php echo add_query_arg(['edit' => $item['id']], get_permalink()) ?>" target="_blank">Edit</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php endif;?>