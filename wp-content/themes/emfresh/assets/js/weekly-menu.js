//Import {table_languageConfig, tagCondition} from variables.js

jQuery(document).ready(function () {
  $(".table-weekly-menu")
    .on("init.dt", function () {
      console.log(this, "init.dt");
    })
    .DataTable({
      language: table_languageConfig,
      layout: {},
      dom: 'Bfrtip<"bottom"pl>',
      responsive: true,
      autoWidth: true,

      scrollCollapse: true,
      scrollX: true,
      //"buttons": ["csv", "excel", "pdf"],
      order: [[1, "desc"]],
      iDisplayLength: 50,
      lengthChange: true,
      lengthMenu: [
        [15, 50, 100, 200],
        ["15 / trang", "50 / trang", "100 / trang", "200 / trang"],
      ],
      ordering: false,
      stateSave: true,
    });

  $(".weekly-menu table.table-waiting-list").DataTable({
    scrollX: true,
    order: [[1, "desc"]],
    paging: false,
    ordering: false,
    info: false,
  });
  //   $('.filter input[type="checkbox"]').on("change", function (e) {
  //     var column = tablee.columns([$(this).attr("data-column")]);
  //     // if checked hide else show
  //     if ($(this).is(":checked")) {
  //       column.visible(true);
  //     } else {
  //       column.visible(false);
  //     }
  //   });
});
