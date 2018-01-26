<?php

function reorder_admin_job_callback()
{
	$args = array(
		'post_type' => 'job',
		'orderby' 	=> 'menu_order',
		'order'		=> 'ASC',
		'no_found_rows' => true,
		'update_post_term_cache'	=> false,
		'post_per_page'	=>50

		//category_name => 'test'		
	);
	$job_listing = new WP_query($args);
	 
	//var_dump($job_listing->get_posts());
	 
	 ?>
	 <div id="job-sort" class="wrap">
	 	<div id="icon-job-admin" class = "icon32"><br /></div>
	 	<h2> <?php _e('Sort Job Positions','wp-job-listing'); ?>  
	 	<img src="<?php  echo esc_url(admin_url() . '/images/loading.gif'); ?>" id="loading-animation"> </h2>
	 	<?php if($job_listing->have_posts()) : ?>
	 		<p> <?php _e('<strong>Note: </strong> this is only affects the Jobs listed the shortcode function', 'wp-job-listing') ; ?> </p>
	 		<ul id ="custom-type-list">
	 			<?php while ( $job_listing->have_posts() ) : $job_listing->the_post(); ?>
	 				<li id="<?php esc_attr(the_id()); ?>"><?php esc_html(the_title()); ?> </li>
	 			<?php  endwhile; ?>	
	 		</ul>	
	 	<?php else: ?>
	 		<p> <?php _e('you have no Job to sort.','wp-job-listing'); ?> </p>
	 	<?php endif ?>	
	 </div>
<?php
}

function wp_save_reorder(){
	wp_send_json_error('You dd');
	/*alert($_POST['order']);
	if(! wp_ajax_referer('wp-job-order', 'security')){
		alert('hello');
		return wp_send_json_error('Invalid Nonce');
	}
	if( ! current_user_can('manage_options')){
		return wp_send_json_error('You do not have permission');
		alert('hi');
	}

	$order = $_POST['order'];
	var_dump($order);
	die();
	$counter = 0;
	foreach ($order as $item_id) {
		$post = array(
			'ID'  => $item_id,
			'menu_order'	=> $counter	
		);
		wp_update_post($post);
		$counter++;
	}
	wp_send_json_success('Post saved');*/
}
add_action('wp_ajax_save_sort', 'wp_save_reorder');