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
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Task successfully confirmed"); }
				else if(data.status = false) { alert("Task confirmation failed"); }
				else { alert("Access denied..!"); }
				location.reload(true);
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
			if(data.status = true) { alert("successfully task finished"); }
			else if(data.status = false) { alert("Failed finish task"); }
			else { alert("Access denied..!"); }
			location.reload(true);
		});
	});

	jQuery(document).on("click", "#addstage", function(){
		var taskid = $(this).data("taskid")
	
	$("#task_stage_modal").on("shown.bs.modal", function () {			
		$("#taskid").val(taskid);
		}).modal('show');			
	});

	jQuery(document).on("click", "#save_stage", function(){
		$("#overlay").fadeIn(1);
		var stageDetail = $('#stageDetail').val();
		taskId = $('#taskid').val();
		hitURL = baseURL + "saveStage";
		var fd = new FormData();
		var ins = $('#files')[0].files.length;
		for (var x = 0; x < ins; x++) {
			fd.append("files[]", document.getElementById('files').files[x]);
		}
		// fd.append('files',files);
		fd.append('taskId',taskId);
		fd.append('stageDetail',stageDetail);			
				
		jQuery.ajax({
		type : "POST",		
		contentType: false,
		processData: false,
		url : hitURL,
		data : fd		
		}).done(function(data){
			setTimeout(function(){
				$("#overlay").fadeOut(1);
			},500);
			if(data.status = true) { alert("successfully stage added "); }
			else if(data.status = false) { alert("Failed add stage"); }
			else { alert("Access denied..!"); }			
			location.reload(true);
		});
	});

	// $(document).ajaxSend(function() {
	// 	$("#overlay").fadeIn(300);
	// });

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
		
		hitURL = baseURL + "addbonus",
		jQuery.ajax({
		type : "POST",
		dataType : "json",
		url : hitURL,
		data : { title : title , userId : userId , desc : desc } 
		}).done(function(data){			
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
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Bonus successfully deleted"); }
				else if(data.status = false) { alert("Bonus deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});

	jQuery(document).on("click", ".addTodo", function(){
		$("#add_todo_modal").on("shown.bs.modal", function () {

		}).modal('show');
	});

	jQuery(document).on("click", "#addNewTodo", function(){
		var text = $('#add-todo-text').val();					

		console.log(text);

		hitURL = baseURL + "addTodo",
		jQuery.ajax({
		type : "POST",
		dataType : "json",
		url : hitURL,
		data : {text : text} 
		}).done(function(data){			
			if(data.status = true) { alert("successfully added"); }
			else if(data.status = false) { alert("Failed add todo"); }
			else { alert("Access denied..!"); }
			location.reload(true);
		});
	});

	jQuery(document).on("click", ".editTodo", function(){
		var todoid = $(this).data("todoid");
		var todotext = $(this).closest('li').find(".text").text();

		// console.log($(this).closest('li').find(".text").text());

		$("#edit_todo_modal").on("shown.bs.modal", function () {
			$("#todoid").val(todoid);
			$("#todo-text").val(todotext);
			}).modal('show');
	});

	jQuery(document).on("click", "#saveTodo", function(){
		var text = $('#todo-text').val(),
		todoid = $('#todoid').val();				

		hitURL = baseURL + "editTodo",
		jQuery.ajax({
		type : "POST",
		dataType : "json",
		url : hitURL,
		data : { todoid : todoid , text : text } 
		}).done(function(data){			
			if(data.status = true) { alert("successfully edited"); }
			else if(data.status = false) { alert("Failed edit todo"); }
			else { alert("Access denied..!"); }
			location.reload(true);
		});
	});

	jQuery(document).on("click", ".deleteTodo", function(){
		var todoid = $(this).data("todoid");	
		currentRow = $(this);
		hitURL = baseURL + "deleteTodo",
		jQuery.ajax({
		type : "POST",
		dataType : "json",
		url : hitURL,
		data : { todoid : todoid}
		}).done(function(data){
			if(data.status = true) {
				alert("successfully TODO deleted"); 
				currentRow.parents('li').remove();
			}
			else if(data.status = false) { alert("Failed to delet"); }
			else { alert("Access denied..!"); }			
		});
	});

	jQuery(document).on("click", ".finishTodo", function(){
		var todoid = $(this).data("todoid");		
		hitURL = baseURL + "finishTodo",
		jQuery.ajax({
		type : "POST",
		dataType : "json",
		url : hitURL,
		data : { todoid : todoid}
		}).done(function(data){
			if(data.status = true) { 
				alert("successfully TODO finished");
				location.reload(true);
			}
			else if(data.status = false) { alert("Failed to finish"); }
			else { alert("Access denied..!"); }			
		});
	});
	
	$(".favourite_icon").click(function(){
		$(this).css({"color": "yellow"});
	   });
	
	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});
