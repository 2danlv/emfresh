<?php

$static_days = site_get_days_week_by('this-week');

$statistics = $data['statistics'];

?>
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
                  <?php foreach($static_days as $day) : ?>
                  <td data-day="<?php echo $day ?>">
                    <?php echo site_get_meal_week($day, '<br>') ?>
                  </td>
                  <?php endforeach ?>
                  <td>
                    Tổng <br>tuần
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
                  <?php foreach($static_days as $day) : ?>
                  <td>
                    <?php 
                      echo isset($statistics['tong_dat_don'][$day]) ? $statistics['tong_dat_don'][$day] : 0;
                    ?>
                  </td>
                  <?php endforeach ?>
                  <td><?php echo $statistics['tong_dat_don']['chinh'] . '/' . $statistics['tong_dat_don']['phu'] ?></td>
                </tr>
                <?php foreach ($statistics['dat_don'] as $name => $items) { ?>
                  <tr class="accordion-content_table">
                    <td><?php echo $name ?></td>
                    <?php 
                      foreach($items as $value) {
                        echo "<td>$value</td>";
                      }
                    ?>
                    <td><?php echo array_sum($items) ?></td>
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
                  <?php foreach($static_days as $day) : ?>
                  <td>
                    <?php 
                      echo isset($statistics['tong_di_mon_chinh'][$day]) ? $statistics['tong_di_mon_chinh'][$day] : 0;
                      echo '/'. (isset($statistics['tong_di_mon_dam'][$day]) ? $statistics['tong_di_mon_dam'][$day] : 0);
                      echo '/'. (isset($statistics['tong_di_mon_nuoc'][$day]) ? $statistics['tong_di_mon_nuoc'][$day] : 0);
                    ?>
                  </td>
                  <?php endforeach ?>
                  <td>-</td>
                </tr>
                <?php foreach ($statistics['di_mon'] as $name => $items) { ?>
                  <tr class="accordion-content_table">
                    <td><?php echo $name ?></td>
                    <?php 
                      foreach($items as $value) {
                        echo "<td>$value</td>";
                      }
                    ?>
                    <td>-</td>
                  </tr>
                <?php } ?>
              </tbody>
              <tbody class="blank">
                <tr>
                  <td colspan="7" style="height: 4px; background: transparent;"></td>
                </tr>
              </tbody>
              <tbody class="unknown">
                <tr class="accordion-tit_table">
                  <td><div class="d-f show-detail"><i class="fas"></i>Chưa rõ</div></td>
                  <?php foreach($static_days as $day) : ?>
                  <td>
                    <?php 
                      echo isset($statistics['tong_chua_ro'][$day]) ? $statistics['tong_chua_ro'][$day] : 0;
                    ?>
                  </td>
                  <?php endforeach ?>
                  <td>-</td>
                </tr>
                <?php foreach ($statistics['chua_ro'] as $name => $items) { ?>
                  <tr class="accordion-content_table">
                    <td><?php echo $name ?></td>
                    <?php 
                      foreach($items as $value) {
                        echo "<td>$value</td>";
                      }
                    ?>
                    <td>-</td>
                  </tr>
                <?php } ?>
              </tbody>
              <tbody class="blank">
                <tr>
                  <td colspan="7" style="height: 4px; background: transparent;"></td>
                </tr>
              </tbody>
              <tbody class="total">
                <tr>
                  <td><div class="d-f show-detail"><i class="fas"></i>TỔNG</div></td>
                  <?php foreach($static_days as $day) : ?>
                  <td>
                    <?php 
                      echo isset($statistics['tong'][$day]) ? $statistics['tong'][$day] : 0;
                    ?>
                  </td>
                  <?php endforeach ?>
                  <td>-</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>