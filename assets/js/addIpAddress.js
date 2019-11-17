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
	
	var addIpForm = $("#addIp");
	
	var validator = addIpForm.validate({
		
		rules:{
			ipAddress :{ required : true },			
			branchName : { required : true },
		},
		messages:{
			ipAddress :{ required : "This field is required" },
			branchName : { required : "This field is required" },			
		}
	});

	jQuery(document).on("click", ".addIp", function(){
		$("#add_ip_modal").on("shown.bs.modal", function () {
		}).modal('show');
	});

	jQuery(document).on("click", "#saveIp", function(){
		var ip = $('#ipAddress').val();		
		var branch = $('#branchName').val();		

		if($("#addIp").validate().form()){		
			hitURL = baseURL + "addIp",
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : {ip : ip, branch : branch} 
			}).done(function(data){			
				if(data.status = true) { alert("successfully Ip added"); }
				else if(data.status = false) { alert("Failed add Ip"); }
				else { alert("Access denied..!"); }
				location.reload(true);
			});
		}
	});

	jQuery(document).on("click", ".deleteIp", function(){
		var ipid = $(this).data("ipid");

		console.log(ipid)

		var confirmation = confirm("Are you sure to delete this Ip Address ?");
		
		if(confirmation)
		{
			currentRow = $(this);
			hitURL = baseURL + "deleteIp",
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { ipid : ipid}
			}).done(function(data){
				if(data.status = true) {
					alert("successfully TODO deleted"); 
					currentRow.parents('tr').remove();
					location.reload(true);
				}
				else if(data.status = false) { alert("Failed to delet"); }
				else { alert("Access denied..!"); }			
			});
		}
	});


});
