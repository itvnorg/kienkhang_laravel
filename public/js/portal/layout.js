// Initial WOW js
new WOW().init();

// BEGIN: Function find error image and replace with default image
function imgError(image) {
    image.onerror = "";
    image.src = "images/no-image.png";
    return true;
}

$(document).ready(function() {

	$('.btn-show-advance').click(function(){
		$('.show-on-advance').show();
		$('.btn-hide-advance').show();
		$('.btn-show-advance').hide();
	});
	$('.btn-hide-advance').click(function(){
		$('.show-on-advance').hide();
		$('.btn-hide-advance').hide();
		$('.btn-show-advance').show();
	});

    if($('.list-brands').length != 0) {
        var owl = $(".list-brands");
        owl.owlCarousel({
            nav: false,
            dots: true,
            loop: true,
            autoplay:true,
            autoplayTimeout:3000,
            responsiveClass: true,
            margin: 30,
            responsive: {
                0: {
                items: 1
                },
                520: {
                items: 2
                },
                1000: {
                items: 3
                }
            }
        });
    }

    $('#slider').flexslider({
        animation: "slide",
        controlNav: false
    });

});