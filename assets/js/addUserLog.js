/**
 * File : addUserLog.js
 * 
 * This file contain the validation of add user log form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */

$(document).ready(function(){
	
	var addUserForm = $("#addUserLog");
	
	var validator = addUserForm.validate({
		
		rules:{
			user_id :{ required : true},
			createdDtm : { required : true},
			process : { required : true, selected : true},			
		},
		messages:{
			user_id :{ required : "This user name field is required"},
			createdDtm : { required : "This date field is required"},
			process : { required : "This field is required", selected : "Please select atleast one option" },			
		}
	});
});
