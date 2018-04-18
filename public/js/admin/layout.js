$(document).ready(function(){
	var pathname = window.location.href;

	var elmItem = $('.treeview-menu li');

	elmItem.each(function(index){
		if($( this ).find('a').attr('href') == pathname){
			$(this).addClass('active');
			$(this).parent('.treeview-menu').css('display','block');
			$(this).parent('.treeview-menu').parent('.treeview').addClass('menu-open');
			$(this).parent('.treeview-menu').parent('.treeview').addClass('active');
		}
	});


	//---> Show loading indicator when pages is loading
	//---> BEGIN: Handle loading indicator show/hide
	$('.c-loading-wrapper').width($(window).width());
    $('.c-loading-wrapper').height($(window).height());

    //---> Handling Indicator Loading for Home Page
    setTimeout(function() {
        $('.c-loading-wrapper').removeClass('loading');
        $('.c-loading-wrapper').addClass('loaded');
    }, 800);
    //---> END: Handle loading indicator show/hide
});