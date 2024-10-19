(function($) {
  var lastScrollTop = 0;
  $_scroll_menu_top = function() {
    $scroll_menu = jQuery('#top-nav');
    if ($scroll_menu.length < 1) {
      return
    }
    $menu = $scroll_menu.find('.nav_top');
    $menu_h = $menu.height();
    // $scroll_menu.height($menu_h);
    $scroll_top = jQuery(document).scrollTop();
    if ($scroll_top > 0) {
      $menu.addClass('fixed');
    } else {
      $menu.removeClass('fixed');
    }
  }
  $.hover_menu = function() {
    function closemenu() {
      $('.overlay').stop().fadeOut();
      $('.main_menu li').removeClass('submenu-show');
    }
    $('.main_menu > li').hover(function(e) {
      var self = $(this),
      p = self;
      /* Act on the event */
      if (p.hasClass('has-child') ) {
        p.addClass('submenu-show');
        $('.overlay').stop().fadeIn();
      }
    }, function() {
      closemenu();
    });
  }
  $_click_menu = function() {
    $('.main_menu > li img').click(function(e) {
      var current = $(this).next('.sub-menu');
      $('.sub-menu').not(current).slideUp();
      $('.sub-menu').not(current).parent().removeClass('active');
      current.stop().slideToggle();
      current.parent().toggleClass('active');
    });
  }
  $_showmenu = function(top) {
    let offset = $('.nav_menu').height();
    jQuery('.show-menu img.open-menu').click(function() {
      /* Act on the event */
      jQuery(this).fadeOut(0);
      $('body').addClass('overflow');
      jQuery('.nav_top .nav_menu').animate({'right': 0}, 300);
      jQuery('.overlay').fadeIn();
      setTimeout(function() {
        jQuery('.show-menu img.close-menu').show(0);
      }, 300);
    });
    jQuery('.nav_top .nav_menu  ul.list_menu_item li a,.main, .logo a,.show-menu img.close-menu,.overlay').click(function() {
      jQuery('.show-menu img.close-menu').fadeOut(0);
      $('body').removeClass('overflow');
      jQuery('.nav_top .nav_menu').animate({'right': '-100%'}, 300);
      jQuery('.overlay').fadeOut();
      setTimeout(function() {
        jQuery('.show-menu img.open-menu').show(0);
      }, 300);
    });
  }
  $_scroll_top = function() {
    var scrollTrigger = 50, // px
    backToTop = function () {
      var scrollTop = $(window).scrollTop();
      if (scrollTop > scrollTrigger) {
        $('.backtop').fadeIn();
      } else {
        $('.backtop').fadeOut();
      }
    };

    $(window).on('scroll', function () {
      backToTop();
    });

    $('.backtop').on('click', function (e) {
      e.preventDefault();
      $('html,body').animate({
        scrollTop: 0
      }, 700);
    });
  };
  //top slider
  $_top_slider = function() {
    $('.top-slider .owl-carousel').owlCarousel({
      nav: true,
      dots: false,
      items: 1,
      touchDrag: true,
      margin: 0,
      mouseDrag: true,
      smartSpeed: 1000,
      // animateIn: 'fadeIn',
      // animateOut: 'fadeOut',
      loop: true,
      autoplay:true,
      autoplayTimeout:6000,
    });
  }
  // tab
  $_tab = function() {
    $('.list-item-tabs').children(":first").addClass('active');
    $('.list-content-tab').children(":first").addClass('active-tab-content');
    $('.list-item-tabs .tab-item').click(function () {
      var tab_id = $(this).attr('data-tab');

      $('.list-item-tabs .tab-item').removeClass('active');
      $('.list-content-tab .tab-content').removeClass('active-tab-content');
      $('.list-content-tab .tab-content').stop().fadeOut(0);
      $(this).addClass('active');
      $(tab_id).addClass('active-tab-content');
      $(tab_id).stop().fadeIn(750);
    })
  };
  // team_slider
  $_team_slider = function() {
    $team_slider = $('.team-slider');
    $team_slider.owlCarousel({
      nav: true,
      dots: false,
      smartSpeed: 1000,
      margin: 30,
      loop: true,
      navText: [
        '<i class="fas fa-chevron-left"></i>',
        '<i class="fas fa-chevron-right"></i>',
      ],
      responsive : {
        0 : {
          items: 2
        },
        840 : {
          items: 3
        },
        920 : {
          items: 4
        }
      }
    });
    var current_slide;
    $('.owlNextBtn').click(function() {
      current_slide =  $('.active-tab-content').find('.owl-carousel');
      current_slide.trigger('prev.owl.carousel');

    })
    $('.owlPrevBtn').click(function() {
      current_slide =  $('.active-tab-content').find('.owl-carousel');
      current_slide.trigger('next.owl.carousel');
    })
  }
  //form popup
  $_open_popup = function() {
    $('.open-popup').on('click', function () {
      if ($(this).hasClass('doctor-item')) {
        $_doctorajax($(this));
      } else {
        var popup_id = $(this).attr('data-target');
        $('body').addClass('body-fixed');
        $("#" + popup_id).removeClass('hidden');
      }
    });
    //close popup
    $('.popup .popup-close,.overlay,.modal-background,.is-large.delete').on('click', function () {
      $('.popup').addClass('hidden');
      $('body').removeClass('body-fixed');
    });
    $('.popup').on('click', function(event){
      if( $('body').hasClass('body-fixed') ) {
        if( $(event.target).is(this) ) {
          $(this).addClass('hidden');
          $('body').removeClass('body-fixed');
        }
      }
    });
  }
  $_doctorajax = function(e) {
    let id = e.data('id');
    let url = e.data('url');
    let avatar = e.find('img').attr('src');
    let popup_id = e.attr('data-target');
    jQuery.post(url, {action: "doctor_detail", id: id}, function(response) {
      data = JSON.parse(response);
      $('.popup-doctor .item_info-title').each(function() {
        $(this).text(data.title)
      });
      $('.popup-doctor .item_info-subtitle').each(function() {
        $(this).text(data.subtitle)
      });
      $('.popup-doctor .item_image img').attr('src', avatar);
      $('.popup-doctor .item_info .content').html(data.content.replace('<!--more-->', ''));
      $('body').addClass('body-fixed');
      $("#" + popup_id).removeClass('hidden');
    })
  }
  //Show more in doctor
  $_showmore = function() {
    $('.showmore').on('click', function(){
      $(this).parent().find('.content_more').stop().slideToggle();
      if ($(this).hasClass('active')) {
        $(this).text($(this).data('more'));
      } else {
        $(this).text($(this).data('less'));
      }
      $(this).toggleClass('active');
    });
  }
  //accordion section in sp
  $_accordion = function() {
    $('.accordion h3').on('click', function() {
      if ($(window).width() < 769) {
        $this = $(this);
        $('.accordion #' + $this.data('target')).stop().slideToggle();
        $this.toggleClass('collapsed');
      }
    });
  }
  //Sidebar navigator show/hide
  $_navigation = function() {
    $('.widget-menu .has-child .nav-link, .widget-menu .has-child img').on('click', function(e){
      e.preventDefault();
      $this = $(this).parent();
      $this.find('.submenu').slideToggle("slow", function(){
        $this.toggleClass('submenu-show');
      });
    });
  }
  //Scroll to id
  $_scroll_id = function() {
		let $menu = $('.nav_top');
    let $navigation = $('.navigation .current-item .submenu');
		//let $menu_mb = $('.nav_top');
		let $menu_h = $menu.height();
		//let $menu_mb_h = $menu_mb.height();
		$navigation.find('a[rel*="#"]').on('click', function (e) {
			e.preventDefault();
			let $id = $(this).attr('rel');
			if ($id == '#' || $($id).length < 1) { return; }

      //$_win_scroll_top( $($id).offset().top - $menu_h - $menu_mb_h + 1 );
			$_win_scroll_top( $($id).offset().top - $menu_h - 10);
		});
	}
  //Scroll function
  $_win_scroll_top = function( top ) {
		if( typeof top == 'string' )
		{
			if( $(top).length < 1 ) return;

			let offset = $('.nav_top').height();
			if( $('.mobile-header').height()>0 ) {
				offset += $('.mobile-header').height();
			} else {
				offset += $('header').height();
			}

			top = $(top).offset().top - offset + 1;
		}

		$('html, body').animate({
			scrollTop: top,
		}, 500, 'linear');
	};
  //Scroll to element in new page by anchor link in sidebar
  $.anchor_link = function() {
    let $navigation = $('.navigation .current-item .submenu');
    let $path = window.location.pathname;
    let $hash = window.location.hash;
		$navigation.find('a').each(function() {
			let currLink = $(this);
			$menu_item = currLink.parent('.menu-item');
			let href = currLink.attr("rel");
      if (href == '#') { return }
      if ($hash === href) {
        currLink.click();
        window.history.replaceState({}, document.title, $path);
      }
		});
	}
  //Scroll sidebar
  $_scroll_sidebar = function() {
    var sidebarSelector = $('.sidebar');
    if (sidebarSelector.length && $(window).width() > 768) {
      sidebarSelector.parent().css({'position': 'relative'});
      sidebarSelector.css('width', sidebarSelector.parent().width());
  		var viewportHeight = $(window).height();
  		var documentHeight = $(document).height();
  		var headerHeight = $('.nav_top.fixed').outerHeight();
  		var sidebarHeight = sidebarSelector.outerHeight();
  		var contentHeight = $('.main_content').outerHeight();
  		var footerHeight = $('footer').outerHeight();
  		var scroll_top = $(window).scrollTop();
  		// calculate
  		if ( contentHeight > sidebarHeight + headerHeight + 120) {
        if (scroll_top > lastScrollTop) {
          var breakingPoint1 = sidebarSelector.parent().offset().top - (headerHeight + 40);
          var breakingPoint2 = contentHeight - sidebarHeight + sidebarSelector.parent().offset().top - headerHeight - 40;
          if (scroll_top < breakingPoint1) {
            sidebarSelector.removeClass('sticky').css({
              'position': 'relative',
              'bottom': 'auto',
              'top': 'auto'
            });
          } else if ((scroll_top >= breakingPoint1) && (scroll_top < breakingPoint2)) {
            sidebarSelector.addClass('sticky').css({
              'position': 'fixed',
              'top': headerHeight + 40 + 'px',
              'bottom': 'auto'
            });
          } else {
            sidebarSelector.removeClass('sticky').css({
              'position': 'absolute',
              'top': 'auto',
              'bottom': '0px'
            });
          }
        } else {
          var breakingPoint1 = sidebarSelector.parent().offset().top - headerHeight - 40;
          var breakingPoint2 = contentHeight - sidebarHeight + sidebarSelector.parent().offset().top - headerHeight - 40;
          if (scroll_top < breakingPoint1) {
            sidebarSelector.removeClass('sticky').css({
              'position': 'relative',
              'bottom': 'auto',
              'top': 'auto'
            });
          } else if ((scroll_top >= breakingPoint1) && (scroll_top < breakingPoint2)) {
            sidebarSelector.addClass('sticky').css({
              'position': 'fixed',
              'top': headerHeight + 40 + 'px',
              'bottom': 'auto'
            });
          } else {
            sidebarSelector.removeClass('sticky').css({
              'position': 'absolute',
              'bottom': '0px',
              'top': 'auto'
            });
          }
        }
        lastScrollTop = scroll_top;
      } else {
        sidebarSelector.removeClass('sticky').css({
          'position': 'relative',
          'bottom': 'auto',
          'top': 'auto'
        });
      }
    }
  }
  //Doctor Filter
  $_doctor_filter = function() {
    $('.doctor-page .filter select').on('change', function() {
      let id = $(this).val();
      let url = window.location.href.split('?')[0] + '?id=' + id;
      window.location.href = url;
    })
  }
  $(document).ready(function() {
    $_scroll_top();
    $_win_scroll_top();
    $_scroll_id();
    $.anchor_link();
    $_navigation();
    $_click_menu();
    $_accordion();
    $_showmore();
    $_showmenu();
    $_top_slider();
    $_team_slider();
    $_open_popup();
    $_tab();
    $_doctor_filter();
  });
  $(window).scroll(function() {
    $_scroll_menu_top();
    $_scroll_sidebar();
  });
  $(window).on('load resize', function() {
    if (window.innerWidth > 991) {
      $.hover_menu();
      $('.accordion-content').removeAttr("style");
    } else {
      jQuery('.nav_top .nav_menu').animate({'right': '-100%'}, 0);
      jQuery('.show-menu img.open-menu').show(0);
      jQuery('.overlay,.show-menu img.close-menu').hide(0);
    }
    $('.sidebar').removeClass('sticky').removeAttr("style");
    $('.nav_item').removeClass('submenu-show');
    $('body').removeClass('overflow');
    $('body').removeClass('body-fixed');
    $('.popup').addClass('hidden');
    jQuery('.overlay,.popup,.show-menu img.close-menu').hide(0);
    jQuery('.show-menu img.open-menu').show(0);
    var height_ =  window.innerHeight ;
    $('.menu-wrapper').height(height_ - 75);
    jQuery('.nav_top .nav_menu').animate({'right': '-100%'}, 0);
  });
})(jQuery);
