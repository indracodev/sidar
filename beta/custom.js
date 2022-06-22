// tombol open/close sidebar
 

$(document).ready(function () {
	$('.tombolCollapseSidebar').on('click', function () {
		$('.wrapper').toggleClass('geser');
		$('.sidebar').toggleClass('geser');
		$('.topbar').toggleClass('geser');
		$('.anti-scroll').toggleClass('geser');
		$('.konten').toggleClass('geser');
		$(this).toggleClass('geser');
	});
});


        $(document).ready(function () {
	$('.tombolCollapseSidebarr').on('click', function () {
		$('.wrapper').toggleClass('geser');
		$('.sidebar').toggleClass('geser');
		$('.topbar').toggleClass('geser');
		$('.anti-scroll').toggleClass('geser');
		$('.konten').toggleClass('geser');
		$(this).toggleClass('geser');
	});
});
        
  


      
    

// aktif navbar
$(function(){
  $('a').each(function(){
    if ($(this).prop('href') == window.location.href) {
      $(this).addClass('active'); $(this).parents('.menu-list').addClass('active');
    }
  });
});

//FOR TOGGLING THE COLLAPSE ON DESKTOP AND MOBILE
function disableCollapseOnMobile() {
  var desktopView = $(window).width();
  if (desktopView >= 1024) {
    $(".collapse-click[data-toggle]").attr("data-toggle", "collapse");
  } else {
    $(".collapse-click[data-toggle]").attr("data-toggle", "");
  }
}
$(window).on("load resize", function() {
 // disableCollapseOnMobile();
});



    