/******************************* FORM VALIDATION ********************************/

function signupValidation() {
	var valid = true;
	
	$("#label").removeClass("required");
	$("#email").removeClass("required");
	$("#agree").removeClass("required");

	var label = $("#label").val();
	var email = $("#email").val();
	var agree = jQuery("#agree").is(':checked');

	var emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;

	if (label.trim() == "") {
		$("#label-label").html("Collection title required").css("color", "#ee0000").show();
		$("#inputFirstName").addClass("error");
		valid = false;
	}

	if (email.trim() == "") {
		$("#email-label").html("Email required").css("color", "#ee0000").show();
		$("#email").addClass("error");
		valid = false;
	}
	else if (!emailRegex.test(email)) {
		$("#email-label").html("Invalid email address.").css("color", "#ee0000").show();
		$("#email").addClass("error");
		valid = false;
	}
console.log(agree);
	if (agree == false) {
		$("#agree-label").css("color", "#ee0000").show();
		$("#agree").addClass("error");
		valid = false;
	}  
       
	if (valid == false) {
		$('.required').first().focus();
		valid = false;
	}
	return valid;
}

/*********************** AM I HUMAN **********************/


