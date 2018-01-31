<?php 

function wp_sample_shortcode(){

		$atts = shortcode_atts(
			array(
					'title' => 'Current job opening in..........'
			), $atts
		);

		$locations = get_terms('location');
		
}

add_shortcode('job_listing', 'wp_sample_shortcode');
function wp_sample_location_shortcode($atts , $content = null){

		$atts = shortcode_atts(
			array(
					'title' => 'Current job opening in..........'
			), $atts
		);

		$locations = get_terms('location');
		 
		 if(! empty($locations) && ! is_wp_error($locations)){}
		 $displayList = '<div id="job-location-list">';
		 $displayList .= '<h4>'.esc_html__( $atts['title'] ).'</h4>';
		 $displayList .= '<ul>';
		 foreach ($locations as $location) {
				$displayList .= '<li class="job-location">';
				$displayList .= '<a href="'.esc_url( get_term_link( $location  ) ).'">';
				$displayList .= esc_html__($location->name).'</a></li>';
		 }
		 $displayList .= '</ul><div>';
		
		return $displayList;
}

add_shortcode('job_location_listing', 'wp_sample_location_shortcode');

function wp_dynamic_shortcode($atts , $content = null){

	if( ! isset($atts['location'])){
		return '<p class="job-error">You must provide location for this shortcode. </p>';
	}	
		$atts = shortcode_atts(
			array(
					'title' => 'Current job opening in..........',
					'count'	=> 5,
					'location'	=>'',
					'pagination'=> false
			), $atts
		);
		$paged = get_query_var('paged') ? get_page_var('paged') :1;
		$args =  array(
			'post_type'			=>	'job',
			'post_status'		=> 	'publish',
			'no_found_rows'		=>	 $atts['pagination'],
			'posts_per_page'	=>	 $atts['count'],
			'paged'				=>	$paged,
			'tax_query'			=> array(
					array(
						'taxonomy'		=>  'location',
						'field'			=>	'slug',
						'terms'			=>	$atts['location'],
					),
			)
		);
		$job_by_locations = new WP_Query($args);
		//var_dump($job_by_locations->get_posts()); 

		if( $job_by_locations->have_posts()) :
				$location = str_replace('-', '', $atts['location']);
				$display_job_by_location = '<div class="job-by-location">';
				$display_job_by_location .= '<h4>'.esc_html__($atts['title'] ).' &nbsp;'.esc_html__( ucwords( $location )).'</h4>';
				$display_job_by_location .= '<ul>';

				while($job_by_locations->have_posts() ) : $job_by_locations->the_post();
					global $post;

					$deadline = get_post_meta(get_the_ID() , 'application_deadline' , true);
					$title = get_the_title();
					$slug = get_the_permalink();
					$display_job_by_location .='<li class="job-listing">';
					$display_job_by_location .=sprintf('<a href="%s">%s</a>&nbsp&nbsp',esc_url( $slug),esc_html__( $title ));
					$display_job_by_location .='<span>'. esc_html($deadline ).'</span>';
					$display_job_by_location .= '</li>';

				endwhile;

			$display_job_by_location	  .= '</ul><div>';
		endif;	
	wp_reset_postdata();
	return $display_job_by_location;

		
}

add_shortcode('job_dynamic_location_listing', 'wp_dynamic_shortcode');