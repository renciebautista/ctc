$(document).ready(function() {
	jQuery.validator.addMethod("lettersonly", function(value, element) {
		return this.optional(element) || /^[a-z]+$/i.test(value);
	}, "Please enter only letters");

	jQuery.validator.addMethod("numbersonly", function(value, element) {
		return this.optional(element) || /^[0-9-z]+$/i.test(value);
	}, "Please enter only digits");
	
	jQuery.validator.addMethod("is_natural", function(value, element) {
		return this.optional(element) || /^[1-9]+$/i.test(value);
	}, "This field is required.");
});