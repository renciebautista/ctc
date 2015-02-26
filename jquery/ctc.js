$(document).ready(function(){
	// inquiry cart
	var domain ="http://"+document.domain;
	
	$.get(domain+"/ctc/addtoBasket", function(data) {
		$('#basket ul').html(data);
	});
	
	$(".clickHere a.basket").click(function() {
		var productIDVal = (this.id);
		$.ajax({  
		type: "POST",  
		url: domain+"/ctc/addtoBasket",  
		data: { productID: productIDVal},  
		success: function(theResponse) {
			
			$('#basket ul').html(theResponse);
		}  
		});  
	});
	
	$("#basket ul").on("click", 'li a img',function(event) { 					
		var productIDVal = (this.id)	
		//console.log(this);
		$.ajax({  
		type: "POST",  
		url: domain+"/ctc/remove",
		data: { productID: productIDVal},  
		success: function(theResponse) {
			$('#basket ul').html(theResponse);
		}  
		});  
	});
	
	$("#reset a.clear").on("click", function(event) { 					
		var productIDVal = (this.id)	
		$.ajax({  
		type: "POST",  
		url: domain+"/ctc/reset",
		data: { productID: productIDVal},  
		success: function(theResponse) {
			$('#basket ul').html(theResponse);
		}  
		});  
		
	});

	//-----------------------------------------------------
	//get contact info
	$( "#c_number" ).blur(function() {
		var p = $(this).val();
		$.ajax({
			type: "GET",
		    url: "/ajax/contact_info",
		    data: {num: p},
		    dataType: 'json',  // <======= instead of 'text' 
		    success: function(data) {
		        $("#c_person").val(data.contact_person);
		        $("#email").val(data.email);
		        $("#company").val(data.company);
		        $("#store").val(data.branch);
		        $("#address").val(data.address);
		        $("#landline").val(data.landline);
		    }
		    // complete: function() {
		    //     alert('Complete: Do something.');
		    // },
		    // error: function() {
		    //     alert('Error: Do something.');
		    // }
		});
	});
});