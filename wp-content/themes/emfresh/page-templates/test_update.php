<?php
/*
Template Name: update Post
*/

get_header();

global $em_customer;

$response = em_api_request('customer/list', []);

$status = $em_customer->get_statuses();
$gender = $em_customer->get_genders();
$tag = $em_customer->get_tags();

$list = [];
if(isset($response['data'])) {
    $list = $response['data'];
}

$response = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_post'])) {
    $nickname   = sanitize_text_field($_POST['nickname']);
    $fullname   = sanitize_text_field($_POST['fullname']);
    $phone    = sanitize_textarea_field($_POST['phone']);
    $address    = sanitize_textarea_field($_POST['address']);
    $gender_post = sanitize_text_field($_POST['gender']);
    $status_post = sanitize_text_field($_POST['status']);
    $tag_post = sanitize_text_field($_POST['tag']);
    $point = sanitize_text_field($_POST['point']);
    $note = sanitize_textarea_field($_POST['note']);
    $data = [
      'id' => 1,
        'nickname'          => $nickname,
        'fullname'      => $fullname,
        'phone'         => $phone,
        'status'        => $status,
        'gender'        => $gender_post,
        'note'          => $note,
        'tag'           => $tag,
        'point'         => $point,
        'address'       => $address,
    ];

    $response = em_api_request('customer/update', $data);
}


?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<div class="container mt-3">
    <?php if(count($list) > 0) : ?>
        <h3>List</h3>
    <ul>
        <?php foreach($list as $item) :?>
        <li><?php echo $item['id'] . ') ' . $item['fullname'] ;?></li>
        <?php endforeach; ?>
    </ul>
    <?php endif;?>
    <?php 
        if(isset($response['code'])) {
            echo '<div class="alert alert-success mt-3" role="alert">'.$response['message'].'</div>';
        }
    ?>
    <h3 class="mt-3">Form</h3>
    <form class="add-post-form mt-3" method="post" action="<?php the_permalink() ?>">
    <div class="form-group row">
                <div class="col-sm-3"><label>Tên khách hàng (*)</label></div>
                <div class="col-sm-9">
                  <input type="text" name="nickname" class="form-control" required>
                </div>
              </div>
        <div class="mb-3">
            <label for="fullname" class="form-label">Fullname</label>
            <input type="text" class="form-control" name="fullname" id="fullname" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" name="phone" id="phone" required>
        </div>
        <div class="form-group row">
                <div class="col-sm-3"><label>Giới tính (*)</label></div>
                <div class="col-sm-9">
                <?php 
                    foreach ($gender as $key => $value) { ?>
                    <div class="icheck-primary d-inline mr-2">
                    <input type="radio" id="radioPrimary<?php echo $key; ?>" value="<?php echo $key; ?>" name="gender" required>
                    <label for="radioPrimary<?php echo $key; ?>">
                      <?php echo $value; ?>
                    </label>
                  </div>
                    <?php } ?>
                </div>
              </div>
        <div class="mb-3">
            <label for="address">Address</label>
            <textarea class="form-control" name="address" id="address" rows="2" required></textarea>
        </div>
        <div class="card-body">
              <div class="form-group row">
                <div class="col-sm-3"><label>Ghi chú đặc biệt</label></div>
                <div class="col-sm-9"><textarea name="note" class="form-control" rows="4"></textarea></div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label for="inputStatus">Trạng thái khách hàng (*)</label></div>
                <div class="col-sm-9"><select id="inputStatus" name="status" class="form-control custom-select" required>
                    <option selected disabled>Select one</option>
                    <?php 
                    foreach ($status as $key => $value) { ?>
                      <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label for="inputTag">Tag phân loại (*)</label></div>
                <div class="col-sm-9"><select class="form-control" name="tag" style="width: 100%;" required>
                    <option selected disabled>Select one</option>
                    <?php 
                    foreach ($tag as $key => $value) { ?>
                      <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3"><label for="inputPoint">Điểm tích lũy</label></div>
                <div class="col-sm-9"><input type="number" id="inputPoint" name="point" class="form-control"></div>
              </div>
            </div>
        <div class="mb-3">
            <input type="submit" class="btn btn-primary" name="add_post" value="Submit">
        </div>
    </form>
    <?php 
        global $em_customer;
        var_export($em_customer->get_statuses());
        var_export($em_customer->get_genders());
        var_export($em_customer->get_tags());
    ?>
</div>

<?php get_footer(); ?>
