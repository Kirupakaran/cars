/* 
	author: istockphp.com
*/
jQuery(function($) {
	
	$("button.topopup").click(function() {
			loading(); // loading
			setTimeout(function(){ // then show popup, deley in .5 second
				loadPopup(); // function show popup 
			}, 500); // .5 second    
	return false;
	});
	
	/* event for close the popup */
	$("div.close").hover(
					function() {
						$('span.ecs_tooltip').show();
					},
					function () {
    					$('span.ecs_tooltip').hide();
  					}
				);
	
	$("div.close").click(function() {
		disablePopup();  // function close pop up
	});
	
	$(this).keyup(function(event) {
		if (event.which == 27) { // 27 is 'Ecs' in the keyboard
			disablePopup();  // function close pop up
		}  	
	});
	
	$("div#backgroundPopup").click(function() {
		disablePopup();  // function close pop up
	});
	
	

	 /************** start: functions. **************/
	function loading() {
		$("div.loader").show();  
	}
	function closeloading() {
		$("div.loader").fadeOut('normal');  
	}
	
	var popupStatus = 0; // set value
	
	function loadPopup() { 
		if(popupStatus == 0) { // if value is 0, show popup
			closeloading(); // fadeout loading
			$("#toPopup").fadeIn(0500); // fadein popup div
			$("#backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8
			$("#backgroundPopup").fadeIn(0001); 
			popupStatus = 1; // and set value to 1
		}	
	}
		
	function disablePopup() {
		if(popupStatus == 1) { // if value is 1, close popup
			$("#toPopup").fadeOut("normal");  
			$("#backgroundPopup").fadeOut("normal");  
			popupStatus = 0;  // and set value to 0
		}
	}
	/************** end: functions. **************/
}); // jQuery End

$(document).ready(function() {
			$('#dsform').submit(function(e) {
				e.preventDefault();
		if($( "#brandsel" ).val()!='' && $( "#locsel" ).val()!='' )
		{
		$.ajax({
			data: $(this).serialize(),
			type: "post",
			url: "http://localhost/pdc/includes/dealersearch.php",
			success: function(response) {
				$('html,body').animate({ scrollTop: $('#dealers').offset().top }, 1000);
				$('#dealers').html(response);	
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

$(document).ready(function() {
			$('#custform').submit(function(e) {
				e.preventDefault();
		if($( "#custname" ).val()!='' && $( "#custemail" ).val()!=''  && $( "#custphno" ).val()!='')
		{
		$.ajax({
			data: $(this).serialize(),
			type: "post",
			url: "http://localhost/pdc/includes/dealersearch.php",
			success: function(response) {
				$('html,body').animate({ scrollTop: $('#dealers').offset().top }, 1000);
				$('#dealers').html(response);	
			}
		});
		return false;
		}
		else
		{
			alert("Please Enter the values");
		}
		
		
	});
		
});



