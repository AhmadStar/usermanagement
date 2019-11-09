/**
 * File : addUser.js
 * 
 * This file contain the validation of add user form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */

$(document).ready(function(){
	
	var addUserForm = $("#addUser");
	
	var validator = addUserForm.validate({
		
		rules:{
			fname :{ required : true ,remote : { url : baseURL + "checkUsernameExists", type :"post"}},
			email : { required : true, email : true, remote : { url : baseURL + "checkEmailExists", type :"post"} },
			password : { required : true },
			cpassword : {required : true, equalTo: "#password"},
			mobile : { required : true, digits : true },
			role : { required : true, selected : true},
			group : { required : true, selected : true},
			workType : { required : true, selected : true}
		},
		messages:{
			fname :{ required : "This field is required", remote : "name already taken" },
			email : { required : "This field is required", email : "Please enter valid email address", remote : "Email already taken" },
			password : { required : "This field is required" },
			cpassword : {required : "This field is required", equalTo: "Please enter same password" },
			mobile : { required : "This field is required", digits : "Please enter numbers only" },
			role : { required : "This field is required", selected : "Please select atleast one option" },
			group : { required : "This field is required", selected : "Please select atleast one option" },
			workType : { required : "This field is required", selected : "Please select atleast one option" }
		}
	});


	var addgeneralForm = $("#addgeneral");
	
	var validator = addgeneralForm.validate({
		
		rules:{
			theme_name : { required : true, selected : true}
		},
		messages:{
			theme_name : { required : "This field is required", selected : "Please select atleast one option" }			
		}
	});
});
