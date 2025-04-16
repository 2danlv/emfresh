<div class="modal fade modal-meal-static" id="modal-static">
  <div class="overlay"></div>
  <div class="modal-dialog modal-wide">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Thống kê trạng thái</h4>
      </div>
      <div class="modal-body pt-16 pb-16">
        <div class="card-primary">
          <div class="card-body">
            <table class="table dataTable">
              <thead>
                <tr class="text-center">
                  <td style="padding-top:0">
                    Trạng thái
                  </td>
                  <td>
                    Thứ 2 <br>
                    (02/01)
                  </td>
                  <td>
                    Thứ 3 <br>
                    (03/01)
                  </td>
                  <td>
                    Thứ 4 <br>
                    (04/01)
                  </td>
                  <td>
                    Thứ 5 <br>
                    (05/01)
                  </td>
                  <td>
                    Thứ 6 <br>
                    (06/01)
                  </td>
                  <td>
                    Tổng <br>
                    tuần
                  </td>
                </tr>
              </thead>
              <tbody class="blank">
                <tr>
                  <td colspan="7" style="height: 4px; background: transparent;"></td>
                </tr>
              </tbody>
              <tbody>
                <tr class="accordion-tit_table">
                  <td>
                    <div class="d-f show-detail"><i class="fas"></i>Đặt đơn</div>
                  </td>
                  <td>100</td>
                  <td>100</td>
                  <td>100</td>
                  <td>100</td>
                  <td>100</td>
                  <td>100/100</td>
                </tr>
                <?php for ( $i = 0; $i < 3; $i++ ) { ?>
                  <tr class="accordion-content_table">
                    <td>SM</td>
                    <td>100</td>
                    <td>100</td>
                    <td>100</td>
                    <td>100</td>
                    <td>100</td>
                    <td>100/100</td>
                  </tr>
                <?php } ?>
              </tbody>
              <tbody class="blank">
                <tr>
                  <td colspan="7" style="height: 4px; background: transparent;"></td>
                </tr>
              </tbody>
              <tbody class="dimon">
                <tr class="accordion-tit_table">
                  <td>
                    <div class="d-f show-detail"><i class="fas"></i>Dí món</div>
                  </td>
                  <td>45/54/6</td>
                  <td>45/54/6</td>
                  <td>45/54/6</td>
                  <td>45/54/6</td>
                  <td>45/54/6</td>
                  <td>-</td>
                </tr>
                <?php for ( $i = 0; $i < 3; $i++ ) { ?>
                  <tr class="accordion-content_table">
                    <td>SM</td>
                    <td>100</td>
                    <td>100</td>
                    <td>100</td>
                    <td>100</td>
                    <td>100</td>
                    <td>100/100</td>
                  </tr>
                <?php } ?>
              </tbody>
              <tbody class="blank">
                <tr>
                  <td colspan="7" style="height: 4px; background: transparent;"></td>
                </tr>
              </tbody>
              <tbody class="unknown">
                <tr>
                  <td><div class="d-f show-detail"><i class="fas"></i>Chưa rõ</div></td>
                  <td>68</td>
                  <td>68</td>
                  <td>68</td>
                  <td>68</td>
                  <td>68</td>
                  <td>-</td>
                </tr>
              </tbody>
              <tbody class="blank">
                <tr>
                  <td colspan="7" style="height: 4px; background: transparent;"></td>
                </tr>
              </tbody>
              <tbody class="total">
                <tr>
                  <td><div class="d-f show-detail"><i class="fas"></i>TỔNG</div></td>
                  <td>68</td>
                  <td>68</td>
                  <td>68</td>
                  <td>68</td>
                  <td>68</td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>