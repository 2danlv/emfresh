$(document).ready(function () {
    $(".tabNavigation [rel='activity-history']").trigger("click");
})
$('.js-cancel').on('click', function(){
    $('#modal-cancel').addClass("is-active");
    $("body").addClass("overflow");
})
$('.js-end').on('click', function(){
    $('#modal-end').addClass("is-active");
    $("body").addClass("overflow");
})
$('.js-continue').on('click', function(){
    $('#modal-continue').addClass("is-active");
    $("body").addClass("overflow");
})