jQuery(document).ready(function($) {
 	 var sortList = $( 'ul#custom-type-list' );
 	 var animation = $( '#loading-animation' );
 	 var pageTitle = $( 'div h2' );
 	 sortList.sortable({
 	 	update: function(event , ui){
 	 		animation.show();
 	 		$.ajax({
 	 			url: ajaxurl,
 	 			type: 'POST',
 	 			dataType : 'json',
 	 			data: {
 	 				action: 'save_sort',
 	 				order:  sortList.sortable('toArray'),
 	 				security : WP_JOB_LISTING.security
 	 			},
 	 			success: function(response){
 	 				//console.log(sortList.sortable('toArray'));
 	 				console.log(response);
 	 				$('div#message').remove()
 	 				animation.hide();
 	 				pageTitle.after('<div id="message" class="updated below-h2"> <p> '+WP_JOB_LISTING.success+' </p> </div>');
 	 			},
 	 			error: function(error){
 	 				//console.log(sortList.sortable('toArray'));
 	 				$('div#message').remove()
 	 				pageTitle.after('<div id="message" class="error"> <p>' + WP_JOB_LISTING.failure + '-'+ error.toString() +'</p> </div>');
 	 			}
 	 		});
 	 	}
 	 });
});