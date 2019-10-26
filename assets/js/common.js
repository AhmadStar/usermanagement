/**
 * @author Kishor Mali
 */


jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteUser", function(){
		var userId = $(this).data("userid"),
			hitURL = baseURL + "deleteUser",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this user ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { userId : userId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("User successfully deleted"); }
				else if(data.status = false) { alert("User deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});

	jQuery(document).on("click", ".deleteTask", function(){
		var taskId = $(this).data("taskid"),
		hitURL = baseURL + "deleteTask",
		currentRow = $(this);				

		var confirmation = confirm("Are you sure to delete this Task ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { taskId : taskId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Task successfully deleted"); }
				else if(data.status = false) { alert("Task deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});


	jQuery(document).on("click", ".confirmTask", function(){
		var taskId = $(this).data("taskid"),
		hitURL = baseURL + "confirmTask",
		currentRow = $(this);				

		var confirmation = confirm("Are you sure to confirm this Task ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { taskId : taskId }
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Task successfully confirmed"); }
				else if(data.status = false) { alert("Task confirmation failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});

	jQuery(document).on("click", ".finishtask", function(){
			var taskid = $(this).data("taskid")
		
		$("#finish_task_modal").on("shown.bs.modal", function () {			
			$("#taskid").val(taskid);
			}).modal('show');
	});

	jQuery(document).on("click", "#finish_task", function(){
		var finishDetail = $('#finishDetail').val(),
		taskId = $('#taskid').val();		
		
		hitURL = baseURL + "endTask",
		jQuery.ajax({
		type : "POST",
		dataType : "json",
		url : hitURL,
		data : {taskId : taskId , finishDetail : finishDetail } 
		}).done(function(data){
			console.log(data);				
			if(data.status = true) { alert("successfully task finished"); }
			else if(data.status = false) { alert("Failed finish task"); }
			else { alert("Access denied..!"); }
			location.reload(true);
		});
	});

	jQuery(document).on("click", ".addbonus", function(){
			var userId = $(this).data("userid"),
			userName = $(this).data("name")
		
		$("#add_bonus_modal").on("shown.bs.modal", function () {
			$("#bonus_user_name").text(userName);
			$("#userId").val(userId);
			}).modal('show');
	});


	jQuery(document).on("click", "#savebonus", function(){
		var title = $('#bonus-title').val(),
		userId = $('#userId').val(),
		desc = $('#bonus-desc').val();

		console.log(title+' '+userId +' '+ desc);
		
		hitURL = baseURL + "addbonus",
		jQuery.ajax({
		type : "POST",
		dataType : "json",
		url : hitURL,
		data : { title : title , userId : userId , desc : desc } 
		}).done(function(data){
			console.log(data);				
			if(data.status = true) { alert("successfully bonus added"); }
			else if(data.status = false) { alert("Failed add bonus"); }
			else { alert("Access denied..!"); }
			location.reload(true);
		});
	});

	jQuery(document).on("click", "#deleteBonus", function(){
		var bonusid = $(this).data("bonusid"),
			hitURL = baseURL + "deleteBonus",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Bonus ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { bonusid : bonusid } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Bonus successfully deleted"); }
				else if(data.status = false) { alert("Bonus deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	
	$(".favourite_icon").click(function(){
		$(this).css({"color": "yellow"});
	   });
	
	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});
