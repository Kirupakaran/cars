$(window).load(function() {
	var i =0;
	var images = ['car2.jpg','car.jpg','car4.jpg','bg2.jpg'];
	var image = $('.image-container');
                //Initial Background image setup
	image.css('background', 'url(images/car4.jpg)');
	image.css('background-repeat', 'no-repeat');
	image.css('background-size', 'cover');
	image.css('position', 'fixed !important');
	image.css('overflow', 'hidden');
	image.css('z-index', '1');
	image.css('top', '0');
	image.css('left', '0');
	image.css('width', '100%');
	image.css('height', '93%');
                //Change image at regular intervals
	setInterval(function(){
		image.fadeOut(1000, function () {
			image.css('background', 'url(images/' + images [i++] +')');
			image.css('background-repeat', 'no-repeat');
			image.css('background-size', 'cover');
			image.css('position', 'fixed !important');
			image.css('overflow', 'hidden');
			image.css('z-index', '1');
			image.css('top', '0');
			image.css('left', '0');
			image.css('width', '100%');
			image.css('height', '93%');
			image.fadeIn(1000);
		});
		if(i == images.length)
		i = 0;
	}, 10000);
});



$(document).ready(function() {
	$('#petrolvsdiesel').submit(function(e) {
		e.preventDefault();
		if($( "#carbrand" ).val()!='' && $( "#carmodel" ).val()!=''  && $( "#pvariant" ).val()!=''   && $( "#dvariant" ).val()!=''   && $( "#location" ).val()!='' )
		{
		$.ajax({
			data: $(this).serialize(),
			type: "post",
			url: "http://localhost/pdc/includes/pvdc.php",
			success: function(response) {
				$('html,body').animate({ scrollTop: $('#cars').offset().top }, 700);
				$('#cars').html(response);
        $('#cars').css('display', 'block');
			}
		});
		return false;
		}
		else
		{
			alert("Please Select the values");
		}
	});

});

$(function() {
      $("#go").click( function()
           {
             $('html,body').animate({ scrollTop: $('#form-section').offset().top }, 'slow');
           }
      );
});
var animated=false;
$(function() {
	$(window).scroll(function(e) {
			var x=$(".splash-container").height()+$(".content").height() - 200;

            if($(this).scrollTop()>x){
			if(animated==false)
			{
			animated=true;
		 $("#compare").css("display", "block");
            jQuery('#compare').animate({right: -20,opacity: 1}, 'slow');
			}
            }
            else{
                if(animated==true){
					jQuery('#compare').animate({right:-500,opacity: 0.5}, 'slow');

					animated=false;
		 }
			}
        });
		$("#compare").mouseover(function(){
if(animated==true){
jQuery('#compare').animate({right: 0,opacity: 1}, 'fast'); //raised the div class=”.boxx” with image
}
});

$("#compare").mouseout(function(){
if(animated==true){
jQuery('#compare').animate({right: -20,opacity: 1}, 'fast'); //lowers the div class=”.boxx” with image
}
});
      $("#compare").click( function()
           {
				event.preventDefault();
             $('html,body').animate({ scrollTop: $('#compare_form').offset().top }, 'slow');
			 animated=true;
           }
      );
});
