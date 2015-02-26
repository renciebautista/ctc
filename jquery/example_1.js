$(document).ready(function(){
	//alert(document.domain);
    // Set up our options for the slideshow...
    var myOptions = {
        noImages: 9,
        path: "http://"+document.domain+"/images/slideshow_images/",  // Relative path with trailing slash.
		timerInterval: 6500, // 6500 = 6.5 seconds
		randomise: true, // Start with random image?
        captions: {         
			1:'<b>AHEAD FOODPOS</b> <div style="font-size:14px;margin-top:5px;">Dynamic Solution for Food Chain and Restaurant</div>',        
            2:'<b>AHEAD HMS</b> <div style="font-size:14px;margin-top:5px;">Dynamic Solution for Hotel Management</div>',
            3:'<b>AHEAD WinPark</b> <div style="font-size:14px;margin-top:5px;">Dynamic Solution for Manned and Unmanned Parking</div>',
            4:'<b>AHEAD WinPOS</b> <div style="font-size:14px;margin-top:5px;">Dynamic Solution for Retail Management</div>',
            5:'<b>AHEAD WinProd</b> <div style="font-size:14px;margin-top:5px;">Dynamic Solution for Production Management</div>',
			6:'<b>DATAMAX Barcode Printer</b> <div style="font-size:14px;margin-top:5px;">Industry grade solution for barcoding requirements</div>',
			7:'<b>AHEAD AMS</b> <div style="font-size:14px;margin-top:5px;">Dynamic Solution for Manpower Management</div>',
			8:'<b>AHEAD HOME SECURITY & VIDEO SURVEILLANCE</b> <div style="font-size:14px;margin-top:5px;">Dynamic Solution for Surveillance and Security</div>',
			9:'<b>AHEAD RFID TECHNOLOGY</b> <div style="font-size:14px;margin-top:5px;">Dynamic Solution for Access and Security</div>'
        }

    };

    // Woo! We have a jquery slideshow plugin!
    $('#example_1_container').easySlides(myOptions);
	
	

})