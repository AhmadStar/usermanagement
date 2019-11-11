/**
 * File : editUser.js 
 * 
 * This file contain the validation of edit user form
 * 
 * @author Kishor Mali
 */
$(document).ready(function(){
	
	var editUserForm = $("#editUser");
	
	var validator = editUserForm.validate({
		
		rules:{
			fname :{ required : true ,remote : { url : baseURL + "checkUsernameExists", type :"post", data : { userId : function(){ return $("#userId").val(); } } }},
			email : { required : true, email : true, remote : { url : baseURL + "checkEmailExists", type :"post", data : { userId : function(){ return $("#userId").val(); } } } },
			cpassword : {equalTo: "#password"},
			mobile : { required : true, digits : true },
			role : { required : true, selected : true},
			group : { required : true, selected : true},
			workType : { required : true, selected : true}
		},
		messages:{
			fname :{ required : "This field is required", remote : "name already taken"  },
			email : { required : "This field is required", email : "Please enter valid email address", remote : "Email already taken" },
			cpassword : {equalTo: "Please enter same password" },
			mobile : { required : "This field is required", digits : "Please enter numbers only" },
			role : { required : "This field is required", selected : "Please select atleast one option" },
			group : { required : "This field is required", selected : "Please select atleast one option" },
			workType : { required : "This field is required", selected : "Please select atleast one option" }
		}
	});
});