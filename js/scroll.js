$(window).load(function() {
	var container = $('div'),
		scrollTo = $('#form');

	container.scrollTop(
		scrollTo.offset().top - container.offset().top + container.scrollTop()
	);

	container.animate({
		scrollTop: scrollTo.offset().top - container.offset().top + container.scrollTop()
	});​
});