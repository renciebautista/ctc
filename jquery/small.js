$(document).ready(function(){

    // Set up our options for the slideshow...
    var myOptions = {
        noImages: 2,
        path: "http://"+document.domain+"/images/small_images/",  // Relative path with trailing slash.
        timerInterval: 6500, // 6500 = 6.5 seconds
		randomise: true // Start with random image?
    };

    // Woo! We have a jquery slideshow plugin!
    $('#example_1_container').easySlides(myOptions);

})