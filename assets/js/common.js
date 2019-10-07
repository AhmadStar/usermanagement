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


	jQuery(document).on("click", ".addbonus", function(){
		var userId = $(this).data("userid"),
			hitURL = baseURL + "addbonus",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to add bonus to user ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { userId : userId } 
			}).done(function(data){
				console.log(data);				
				if(data.status = true) { alert("successfully bonus added"); }
				else if(data.status = false) { alert("Failed add bonus"); }
				else { alert("Access denied..!"); }
				location.reload(true);
			});
		}
	});
	
	$(".favourite_icon").click(function(){
		$(this).css({"color": "yellow"});
	   });
	
	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});
