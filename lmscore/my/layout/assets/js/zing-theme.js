var width = $(window).width();
var height = $(window).height();

$(document).ready(function () {	
	if(width>992){
		singlesliderHeight();
	}
	if(width<992){
		navigationMenu();
	}
	multiItemsCarousel();
	sideBar();	
	filterSection();
});

$(window).on('resize', function(){
    if(width>992){
		singlesliderHeight();
	}
	if(width<992){
		navigationMenu();
	}
	multiItemsCarousel();
	sideBar();	
	filterSection();
});

function singlesliderHeight(){
	var sliderHeight = $('.eq-height-card').outerHeight();
	$('.eq-height-slider').height(sliderHeight);
}
function navigationMenu(){
    $(document).on('click','.navbar-toggler',function(){
    	$(this).toggleClass('open');
        $('header .bott-head').slideToggle(600);
    });
}

function multiItemsCarousel(){
	/* Start Carousel MultiItem */
	$('.carousel.carousel-multi-item.v-2 .carousel-item').each(function () {
		var next = $(this).next();
		if (!next.length) {
			next = $(this).siblings(':first');
		}
		next.children(':first-child').clone().appendTo($(this));

		for (var i = 0; i < 4; i++) {
			next = next.next();
			if (!next.length) {
				next = $(this).siblings(':first');
			}
			next.children(':first-child').clone().appendTo($(this));
		}
	});
	/* End */
}

function sideBar(){
	$(document).on('click','.sidebar .icon-back',function(){
		$('.sidebar').toggleClass('open');
	});
}
function filterSection(){
	$(document).on('click','.approvals-box .icon',function(){
		$(this).parent('div').find('.icon').fadeOut();
		$(this).parent('div').find('.btn-close').fadeIn();
		$('.filter-box').slideDown(600);
	});
	$(document).on('click','.approvals-box .btn-close',function(){
		$(this).parent('div').find('.icon').fadeIn();
		$(this).parent('div').find('.btn-close').fadeOut();
		$('.filter-box').slideUp(600);
	});
}