<?php

global $em_customer;

$list_noti = site_user_session_get('list_noti', true);

if (empty($list_noti) || count($list_noti) == 0) return;

$list_success = [];
$list_fail = [];
$list_csv = ['Họ tên,Số điện thoại,Kết quả'];
$customers = [];
foreach ($list_noti as $i => $result) {
    $id = $result['id'];

    if (isset($customers[$id])) {
        $customer = $customers[$id];
    } else {
        $customer = $em_customer->get_item($id);

        $customers[$id] = $customer;
    }

    $result['customer_name'] = $customer['customer_name'];
    $result['phone'] = $customer['phone'];

    if ($result['success'] == 0) {
        $list_fail[] = $result;
        $result['message'] = 'Cập nhật không thành công';
    } else {
        $list_success[] = $result;
        $result['message'] = 'Cập nhật thành công';
    }

    $list_csv[] = $result['customer_name'] . ',' . $result['phone'] .',' . $result['message'];

    $list_noti[$i] = $result;
}

?>
<div class="modal fade modal-result_update is-active">
    <div class="overlay"></div>
    <div class="modal-dialog">
        <div class="modal-header pr-16">
            <h4 class="modal-title">Cập nhật nhanh</h4>
            <div class="d-f notice ai-center mb-16">
                <i class="fas fa-check-circle mr-8"></i> Đã cập nhật xong, vui lòng kiểm tra kết quả
            </div>
            <ul class="nav">
                <li class="nav-item active" rel="all">Tất cả</li>
                <li class="nav-item" rel="success">Thành công <span class="badge badge-success ml-8"><?php echo count($list_success) ?></span></li>
                <li class="nav-item error" rel="error">Lỗi <span class="badge badge-error ml-8"><?php echo count($list_fail) ?></span></li>
            </ul>
        </div>
        <div class="modal-content">
            <div class="modal-body pt-16">
                <?php foreach($list_noti as $result) : ?>
                <div class="row <?php echo $result['success'] ? 'success' : 'error' ?>">
                    <div class="col-5">
                        <div class="wrap-name nowrap" title="<?php echo $result['customer_name'] ?>"><?php echo $result['customer_name'] ?></div>
                    </div>
                    <div class="col-2"><span class="copy modal-button" data-target="#modal-copy" title="Copy: <?php echo $result['phone'] ?>"><?php echo $result['phone'] ?></span></div>
                    <div class="col-5"><?php echo $result['message'] ?> </div>
                </div>
                <?php endforeach ?>
                <!-- <div class="row error">
                    <div class="col-4">Linh (Nu Kenny)</div>
                    <div class="col-4"><span class="copy modal-button" data-target="#modal-copy" title="Copy: 0888170802">0888170802</span></div>
                    <div class="col-4">cập nhật thành công</div>
                </div> -->
            </div>
        </div>
        <div class="modal-footer pt-16 pl-16 pr-16">
            <div class="row">
                <div class="col-6"><button type="button" class="btn btn-secondary button-result-export">Xuất Excel kết quả</button></div>
                <div class="col-6 text-right"><button type="button" class="btn btn-secondary modal-close">Đóng</button></div>
            </div>
        </div>
    </div>
    <textarea class="result_update_csv" style="display: none;"><?php echo implode("\n", $list_csv) ?></textarea>
</div>
<script>
    document.querySelector('.button-result-export').addEventListener('click', function(){
        createDownloadLink(document.querySelector('.result_update_csv').value, 'result-update');
    })

    function createDownloadLink(data, name) {
        const blob = new Blob([data], { type: 'text/csv;charset=UTF-8' })
        const link = document.createElement('a')
        link.href = URL.createObjectURL(blob)
        link.download = name + '-' + (new Date()).getTime() + '.csv'
        link.click()
    }
</script>