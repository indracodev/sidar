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
  disableCollapseOnMobile();
});
