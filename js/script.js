$(window).load(function() {
      var w = $( window ).width();
    var h = $( window ).height();
    if(w>600){
    w=w*15/100;
	 $( "#main" ).css({ "left" : w + "px" });
}
    if(h>600){
    h=h*15/100;

    $( "#main" ).css({ "top" : h + "px" });
	}
});

$(window).resize(function() {
    var w = $( window ).width();
    var h = $( window ).height();
     if(w>600){
		w=w*15/100;
		$( "#main" ).css({ "left" : w + "px" });
	}
	else
	{
		$(".maindiv").css({ "background-attachment" : "local"});
	}
    if(h>600){
    h=h*15/100;

    $( "#main" ).css({ "top" : h + "px" });
	}
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


/*
// Dealer login popup
$(document).ready(function() {
	$("#dealerlogin").click(function() {
		dealer = $("#dealerlogindiv");
		dealer.css('float', 'right');
		dealer.css('background', 'rgba(26, 6, 51, 0.67)');
		dealer.css('padding', '25px');
		$.ajax({
			data: $(this).serialize(),
			type: "post",
			url: "http://localhost/pdc/dealerlog.php",
			success: function(response) {
				$(dealer).html(response);
				$("#dealerlogin").fadeOut(0);
			}
		});
	});
});
*/
