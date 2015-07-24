$(document).ready(function(){
	$('#fileselectbutton').click(function(e){
		$('#file').trigger('click');
		});

		$('#file').change(function(e){
		var val = $(this).val();

		var file = val.split(/[\\/]/);

		$('#filename').val(file[file.length-1]);
	});

	//get page every change on selection
    $('.selection').each(function () {
    	$(this).bind("change", function() {
		  	$("form").trigger("submit");
		});
	});

    $('.datenow').each(function () {
    	$(this).mask("99/99/9999");
    	$(this).datepicker({
			minDate: new Date()
		});
	});

	$('.datefilter').each(function () {
    	$(this).mask("99/99/9999");
    	$(this).datepicker();
	});

    if(('#notes').length){
    	$('#notes').wysihtml5();
    	$('#retry,#contact').numericonly();
    }
	
	
});