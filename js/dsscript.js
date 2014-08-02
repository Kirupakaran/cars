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
