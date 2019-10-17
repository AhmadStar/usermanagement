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
	
	var addUserForm = $("#addNewTask");
	
	var validator = addUserForm.validate({		

		rules:{			
			priority : { required : true , selected : true},
			role : { required : true, selected : true},
			group : { required : true, selected : true}
		},
		messages:{
			fname :{ required : "This field is required", selected : "Please select atleast one option" },			
			group : { required : "This field is required", selected : "Please select atleast one option" }
		}
	});
});
