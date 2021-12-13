
$(document).ready(function(){
$('#rtl').click(function (){
	
   $('link[href="../assets/css/style.css"]').attr('href','../assets/css/style1.css');
   $('link[href="../assets/css/skin-modes.css"]').attr('href','../assets/css/skin-modes1.css');
   $('link[href="../assets/plugins/sidemenu/closed-sidemenu.css"]').attr('href','../assets/plugins/sidemenu/closed-sidemenu1.css');
   $('link[href="../assets/plugins/charts-c3/c3-chart.css"]').attr('href','../assets/plugins/charts-c3/c3-chart1.css');
   $('link[href="../assets/plugins/scroll-bar/jquery.mCustomScrollbar.css"]').attr('href','../assets/plugins/scroll-bar/jquery.mCustomScrollbar1.css');
   $('link[href="../assets/css/icons.css"]').attr('href','../assets/css/icons1.css');
   $('link[href="../assets/plugins/sidebar/sidebar.css"]').attr('href','../assets/plugins/sidebar/sidebar1.css');


});
$('#ltr').click(function (){
   $('link[href="../assets/css/style1.css"]').attr('href','../assets/css/style.css');
   $('link[href="../assets/css/skin-modes1.css"]').attr('href','../assets/css/skin-modes.css');
   $('link[href="../assets/plugins/sidemenu/closed-sidemenu1.css"]').attr('href','../assets/plugins/sidemenu/closed-sidemenu.css');
   $('link[href="../assets/plugins/charts-c3/c3-chart1.css"]').attr('href','../assets/plugins/charts-c3/c3-chart.css');
   $('link[href="../assets/plugins/scroll-bar/jquery.mCustomScrollbar1.css"]').attr('href','../assets/plugins/scroll-bar/jquery.mCustomScrollbar.css');
   $('link[href="../assets/css/icons1.css"]').attr('href','../assets/css/icons.css');
   $('link[href="../assets/plugins/sidebar/sidebar1.css"]').attr('href','../assets/plugins/sidebar/sidebar.css');
});
});