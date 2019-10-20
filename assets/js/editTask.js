/**
 * File : editUser.js 
 * 
 * This file contain the validation of edit user form
 * 
 * @author Kishor Mali
 */
	

	jQuery(document).on("click", ".remove_picture", function(){
		hitURL = baseURL + "deleteFile",

		jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id: $(this).parent().attr('id') }
			}).done(function(data){				
			});
		$(this).closest('li').remove();
	});
