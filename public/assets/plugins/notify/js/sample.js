// Generated by CoffeeScript 2.1.0
(function () {
  $(function () {
  //   $.growl({
  //  //   title: "Growl",
  //   //  message: "Hi I'm volgh"
  //   });

	 $('.error').click(function (event) {
      event.preventDefault();
      event.stopPropagation();
      return $.growl.error({
        message: "please check Your details ...file is missing"
      });
    });
    $('.notice').click(function (event) {
      event.preventDefault();
      event.stopPropagation();
      return $.growl.notice({
        message: "You have 4 notification"
      });
    });
    return $('.warning').click(function (event) {
      event.preventDefault();
      event.stopPropagation();
      return $.growl.warning({
        message: "read all details carefully"
      });
    });
  });
}).call(this);

 var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-31911059-1']);
  _gaq.push(['_trackPageview']);

  (function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();