/**
 * File : addGroup.js
 * 
 * This file contain the validation of add Group form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */

$(document).ready(function(){
	
	var addGroupForm = $("#addGroup");
	
	var validator = addGroupForm.validate({
		
		rules:{
			groupName :{ required : true ,remote : { url : baseURL + "checkGroupExists", type :"post"}},			
			desc : { required : true },
		},
		messages:{
			groupName :{ required : "This field is required", remote : "Group name already taken" },
			desc : { required : "This field is required" },			
		}
	});

	var editGroupForm = $("#editGroup");
	
	var validator = editGroupForm.validate({
		
		rules:{			
			groupName :{ required : true ,remote : { url : baseURL + "checkGroupExists", type :"post", data : { groupId : function(){ return $("#groupId").val(); } }}},			
			groupDesc : { required : true },
		},
		messages:{
			groupName :{ required : "This field is required", remote : "Group name already taken" },
			groupDesc : { required : "This field is required" },
		}
	});


	jQuery(document).on("click", ".deleteGroup", function(){
		var groupId = $(this).data("groupid"),
			hitURL = baseURL + "deleteGroup",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Group ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { groupId : groupId } 
			}).done(function(data){
				console.log(data)
				if(data.result == 'TRUE') { 
					alert("Group successfully deleted"); 
					currentRow.parents('tr').remove();					
				}else if(data.result == 'Error') { 
					alert("Group Not empty, u can't delete it."); 
				}else if(data.result == 'FALSE') { alert("Group deletion failed"); }				
			});
		}
	});

	jQuery(document).on("click", ".editGroup", function(){
		var groupname = $(this).data("groupname");
		var groupdesc = $(this).data("groupdesc");
		var groupid = $(this).data("groupid");

		$("#edit_group_modal").on("shown.bs.modal", function () {
			$("#groupName").val(groupname);
			$("#groupDesc").val(groupdesc);
			$("#groupId").val(groupid);
			}).modal('show');
	});

	jQuery(document).on("click", "#savegroup", function(){
		var groupName = $('#groupName').val(),
			groupDesc = $('#groupDesc').val(),
			groupId = $('#groupId').val();			

		if($("#editGroup").validate().form()){
			hitURL = baseURL + "editGroup",
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { groupId : groupId , groupName : groupName , groupDesc : groupDesc } 
			}).done(function(data){			
				if(data.status = true) { alert("successfully edited"); }
				else if(data.status = false) { alert("Failed edit Group"); }
				else { alert("Access denied..!"); }
				location.reload(true);
			});
		}else{

		}
	});


});
