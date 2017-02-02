$(document).ready(function(){
	var altura = $('.top-nav-bar').offset().top;
	
	$(window).on('scroll', function(){
		if ( $(window).scrollTop() > altura ){
			$('.top-nav-bar').addClass('top-nav-bar-fixed');
		} else {
			$('.top-nav-bar').removeClass('top-nav-bar-fixed');
		}
	});
 
});
