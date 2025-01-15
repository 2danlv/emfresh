$(document).ready(function () {
    // $(".tabNavigation [rel='activity-history']").trigger("click");
    
    
    $("ul.edit-product li").click(function () {
        switch_tabs_order(jQuery(this))
      });
      switch_tabs_order(jQuery('.defaulttab_order'));
      
    });
$('.js-cancel').on('click', function(){
    $('#modal-cancel').addClass("is-active");
    $("body").addClass("overflow");
});
$('.js-end').on('click', function(){
    $('#modal-end').addClass("is-active");
    $("body").addClass("overflow");
});
$('.js-continue').on('click', function(){
    $('#modal-continue').addClass("is-active");
    $("body").addClass("overflow");
});
function switch_tabs_order(obj) {
	jQuery('.tab-pane-2').stop().fadeOut(1);
	jQuery('ul.tab-order li').removeClass("selected");
	var id_order = obj.attr("rel");
	jQuery('#' + id_order).stop().fadeIn(300);
	//jQuery('#'+id).show();
	obj.addClass("selected");
}