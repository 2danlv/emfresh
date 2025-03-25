function switch_tabs_order(obj) {
	$('.tab-pane').stop().fadeOut(1);
	$('ul.tab-nav li').removeClass("selected");
	var id_order = obj.attr("rel");
	$('#' + id_order).stop().fadeIn(300);
	obj.addClass("selected");
}
$(document).ready(function () {
	switch_tabs_order($('ul.tab-nav li.defaulttab'))
	$("ul.tab-nav li").click(function () {
		switch_tabs_order($(this))
	});
})