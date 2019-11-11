/**
 * File : editUser.js 
 * 
 * This file contain the validation of edit user form
 * 
 * @author Kishor Mali
 */
$(document).ready(function(){
	
	var updateUserForm = $("#updateUser");

	var validator = updateUserForm.validate({
		
		rules:{			
			fname :{ required : true ,remote : { url : baseURL + "checkUsernameExists", type :"post", data : { userId : function(){ return $("#userId").val(); } } }},
			email : { required : true, email : true, remote : { url : baseURL + "checkEmailExists", type :"post", data : { userId : function(){ return $("#userId").val(); } } } },
		},
		messages:{			
			fname :{ required : "This field is required", remote : "name already taken"  },
			email : { required : "This field is required", email : "Please enter valid email address", remote : "Email already taken" },
		}
	});
});