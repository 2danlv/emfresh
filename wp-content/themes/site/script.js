jQuery(document).ready(function($) {
    $('a[href^="#"]').click(function(ev){
        ev.preventDefault();
      $('html, body').animate({
        scrollTop: $($(this).attr('href')).offset().top - 50
      }, 500);
      return false;
    });
    $('.gotop img').click(function(){ 
       $("html, body").animate({ scrollTop: 0 }, 600); 
       return false; 
   }); 
});
$(window).on('scroll', function() {
    win_pos = $(window).scrollTop() - 99;
    if ( win_pos > $(".kv-area").height()) {
        $('.main').addClass('bg-fixed');
        $('.gotop').stop().fadeIn();
    } else {
        $('.main').removeClass('bg-fixed');
        $('.gotop').stop().fadeOut();
    }
    
});
$(window).on('load', function(){
    // [?]テキストセット
    var expTxt = new Array();
    expTxt[1] = 'Expertは、その分野で最も経験豊富なパートナーです。大規模かつ複雑なプロジェクトにも対応し、トップレベルの顧客満足を実現します。';
    expTxt[2] = 'Level II Specialistは、高水準のカスタマーサクセスを実現することができる知識と経験を持つパートナーです。';
    $.each(expTxt, function(index, value) {
        if(value){
            var idxName = '.exp' + index;
            $('.list_box_slide_item_case_title').find(idxName).text(value);
        }
    })

    //スライド初期化
    $('.list_box_slide').slick({arrows:false,adaptiveHeight:true});

    //スライドインデックス初期表示
    $('.list_box_tab').each(function(index) {
        $(this).find('li').eq(0).addClass('is-active');
    });

    //アンカー付きで遷移した場合
    if(location.hash){
        var hash = location.hash.split('-');
        if(hash[1]) {//スライド指定があれば、該当スライドを初期表示
            var target = $('.list_box_slide_' + hash[0].slice(1));
            var tabNo = hash[1] - 1;
            dispTab(target, tabNo);
        }

        //アンカー位置までスクロール
        var pos = 0;
        if($('#appx_content').length){
            pos = $('#appx_content').offset().top;
        }
        pos = $(hash[0]).offset().top - pos;
        $(window).scrollTop(pos);
    }
});

// [?]クリック時
$('.list_box_slide_item_case_title > .ques').on('click', function() {
    $(this).find('.exp').toggleClass('is-active');
});

//スライドドラッグ時、liメニューを変更
$('.list_box_slide').on('afterChange', function (event, slick, currentSlide, nextSlide) {
    var tabNo = (currentSlide ? currentSlide : 0);
    $(this).parent().find('.list_box_tab li').removeClass('is-active');
    $(this).parent().find('.list_box_tab li').eq(tabNo).addClass('is-active');

    //ハッシュ変更
    var hashIdx = tabNo + 1;
    window.location.hash = $(this).parents('.list_box').attr('id') + '-' + hashIdx;
});

//liメニュークリック時
$('.list_box_tab > li').on('click', function() {
    var target = $(this).parent().next();
    var tabNo = $(this).index();
    dispTab(target, tabNo);

    //ハッシュ変更
    var hashIdx = tabNo + 1;
    window.location.hash = $(this).parents('.list_box').attr('id') + '-' + hashIdx;
});

//引数によっていスライドのliメニューとスライド表示を変更
function dispTab(target, tabNo) {
    target.slick('slickGoTo', tabNo, false);
    target.prev().find('li').removeClass('is-active');
    target.prev().find('li').eq(tabNo).addClass('is-active');
}