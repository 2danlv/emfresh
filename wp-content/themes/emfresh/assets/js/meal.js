//Import {table_languageConfig, tagCondition} from variables.js

jQuery(document).ready(function () {
  $("#btn_calculate").on("click", () => {
    const P = parseFloat($("#input_protein").val() || 0);
    const L = parseFloat($("#input_liqid").val() || 0);
    const G = parseFloat($("#input_glucid").val() || 0);

 
    $("#table_nutrition tr").each(function () {
      var PCol = 0;
      var LCol = 0;
      var GCol = 0;
      var CaloCol = 0;

      var row = $(this);

      if (row.find("td:first").text() === "EM") {
        PCol = P;
        LCol = L;
        GCol = G;
      }
	  if (row.find("td:first").text() === "EL") {
        PCol = Math.round(1.4*P);
        LCol = Math.round(1.3*L);
        GCol = Math.round(1.4*G);
      }
	  if (row.find("td:first").text() === "SM") {
		PCol = P;
        LCol = L;
        GCol = Math.round(0.6*G);
      }
	  if (row.find("td:first").text() === "SL") {
		PCol = Math.round(1.4*P);
        LCol = Math.round(1.3*L);
        GCol = Math.round(0.6*G*1.1);
      }
	  if (row.find("td:first").text() === "PM") {
		PCol = Math.round(1.9*P);
        LCol = Math.round(1.4*L);
        GCol = G;
      }
	  if (row.find("td:first").text() === "PL") {
		PCol = Math.round(2.3*P);
        LCol = Math.round(1.8*L);
        GCol = Math.round(1.4*G);
      }
      CaloCol = Math.round(4 * PCol + 9 * LCol + 4 * GCol);

	  const CRange = $(this).find("td.c_range").text().split("-").map(Number);
	  const PRange = $(this).find("td.p_range").text().split("-").map(Number);

	  $(this).find("td").removeClass("destructive")
	  if(CaloCol < CRange[0] || CaloCol > CRange[1]){
		$(this).find("td.c_range").addClass("destructive")
		$(this).find("td.c").addClass("destructive")
		$(this).find("td.result").addClass("destructive")
	  }

	  if(PCol < PRange[0] || PCol > PRange[1]){
		$(this).find("td.p_range").addClass("destructive")
		$(this).find("td.p").addClass("destructive")
		$(this).find("td.result").addClass("destructive")
	  }

      $(this).find("td.c").text(CaloCol);
      $(this).find("td.p").text(PCol);
      $(this).find("td.l").text(LCol);
      $(this).find("td.g").text(GCol);
	  $(this).find("td.result").text(`${CaloCol} calo | ${PCol}g:${LCol}g:${GCol}g`);
    });
  });
});
