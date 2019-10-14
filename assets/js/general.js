/**
 * File : general.js
 * 
 * This file contain the change theme script
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */

$(document).ready(function(){

	jQuery(document).on("click", "#site_theme li a", function(){
		var theme_name = $(this).attr("data-skin"),
			hitURL = baseURL + "general",
			currentRow = $(this);				
				
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { theme_name : theme_name } 
			}).done(function(data){
				window.location.reload();
			});		
	});
});
