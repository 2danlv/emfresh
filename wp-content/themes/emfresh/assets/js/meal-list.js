//Import {table_languageConfig, tagCondition} from variables.js

jQuery(document).ready(function () {
  $(".table-meal-list")
    .on("init.dt", function () {
      console.log(this, "init.dt");
    })
    .DataTable({
      language: table_languageConfig,
      layout: {},
      columnDefs: [
        {
          //type: 'string',
          targets: [0, 5],
          orderable: false,
        },
        {
          type: "string",
          targets: [1, 2, 3, 4, 5, 6, 7, 8],
        },
      ],
      buttons: [
        // {
        //	 text: "Date range",
        //	 attr: {
        //		 id: "reportrange",
        //	 },
        // },
        {
          extend: "searchBuilder",
          attr: {
            id: "searchBuilder",
          },
          config: {
            conditions: {
              html: tagCondition,
            },
            depthLimit: 0,
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
            filterChanged: function (count) {
              if (count == 0 || count == 1) {
                $(".btn-filter").removeClass("current-filter");
                $(".btn-filter .count").text("");
                $(".dtsb-title").html(`Điều kiện lọc`);
                $(".custom-btn.revert").css("display", "none");
              }
              if (count > 1) {
                $(".btn-filter").addClass("current-filter");
                $(".btn-filter .count").html(`${count - 1}`);
                $(".dtsb-title").html(`Điều kiện lọc (${count - 1})`);
                $(".custom-btn.revert").css("display", "block");
              }
            },
          },
        },
      ],
      dom: 'Bfrtip<"bottom"pl>',
      responsive: true,
      autoWidth: true,
      fixedColumns: {
        start: 3,
      },
      searchBuilder: {
        // Tắt bộ lọc tự động (disable the default behavior)
        preDefined: [], // Không xác định bộ lọc mặc định nào
      },
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
      stateSave: true,
      scrollY: $(window).height() - 227,
    });
  $(".table-waiting-list").DataTable({
    scrollX: true,
    scrollY: "80vh",
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
