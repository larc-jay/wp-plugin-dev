<?php 

function wp_add_custom_metabox(){

		add_meta_box(
			'wp_meta',
			__( 'Job Listing' ),
			'wp_meta_callback',
			'job',
			'side',
			'low'	
		);
}

add_action('add_meta_boxes','wp_add_custom_metabox');

function wp_meta_callback( $post ){
	wp_nonce_field(basename(__FILE__), 'wp_jobs_nonce' );
	$wp_stored_meta = get_post_meta($post->ID);	
	//var_dump($wp_stored_meta);
	//die();
?>
	<div>
			<div class="meta-row">
				<div class="meta-th">
					<label for ="job-id" class = "wp-row-title"><?php  _e('Job Id' ,'wp-job-listing' ); ?></label>
				</div>
 				<div class="meta-td">
 					<input type="text" name="job_id" id="job-id" value="<?php if ( ! empty ( $wp_stored_meta['job_id'])) echo esc_attr($wp_stored_meta['job_id'][0]); ?>" />
 				</div>
			</div>
			<div class="meta-row">
				<div class="meta-th">
					<label for="date-listed" class="wp-row-title"><?php  _e('Date Listed','wp-job-listing'); ?></label>
				</div>
				<div class="meta-td">
					<input type="text" class="wp-row-content datepicker" name="date_listed" id ="date-listed" value=""/>
				</div>
			</div>
			<div class="meta-row">
				<div class="meta-th">
					<label for="date-listed" class="wp-row-title"><?php  _e('Application Deadline','wp-job-listing'); ?></label>
				</div>
				<div class="meta-td">
					<input type="text"  class="wp-row-content datepicker"  name="application_deadline" id ="app-deadline" value="" />
				</div>
			</div>
			<div class="meta-row">
				<div class="meta-th">
					<label for="relocation" class="wp-row-title"><?php  _e('Relocation Assistant','wp-job-listing'); ?></label>
				</div>
				<div class="meta-td">
					 <select name="relocation" id = "relocation_assistance">
					 	<option value="1">Yes</option>
					 	<option value="0">No</option>
					 </select>
				</div>
			</div>
			<div class="meta-row">
				<div class="meta-th">
					<span><?php  _e('Principle Duties','wp-job-listing'); ?></span>
				</div>
			</div>
			<div class="meta-editor">
				<?php
					$content = get_post_meta($post->ID, 'duties',true);
					$editor = 'principle_duties';
					$settings = array(
						'textarea_rows' => 5,
						'media_buttons' => false,
					);
					wp_editor($content,$editor,$settings);
				?>
			</div>
			
			<div class="meta-row">
				<div class="meta-th">
					<span><?php  _e('Minimum requirnments','wp-job-listing'); ?></span>
				</div>	
				<div class="meta-td">
						<div id="qt-minimum-requirements-toolbar" class="quicktags-toolbar"></div>
						<textarea class="wp-textarea" name= "minimum_requirement" id="minimum-requirements" > </textarea>
				</div>	
			</div>
				
			<div class="meta-row">
				<div class="meta-th">
					<span><?php  _e('Preferrd requirnments','wp-job-listing'); ?></span>
				</div>
				<div class="meta-td">
					    <div id="qt-preferrd-requirements-toolbar" class="quicktags-toolbar"></div>
						<textarea class="wp-textarea" name= "preferred_requirement"  id="preferred-requirements" > </textarea>
				</div>	
			</div>
	</div>

<?php
}

function wp_meta_save($post_id){
	$is_autosave = wp_is_post_autosave($post_id);
	$is_revision = wp_is_post_revision($post_id);
	$is_valid_nonce = (isset( $_POST[ 'wp-job-nonce']) && wp_verify_nonce ( $_POST['wp-job_nonce']));
	//var_dump($_POST);
	//die();
	if($is_autosave || $is_revision || $is_valid_nonce){
		return;
	}

	if(isset ($_POST['job_id'])){
		update_post_meta($post_id , 'job_id' , sanitize_text_field( $_POST['job_id']));
		update_post_meta($post_id , 'date_listed' , sanitize_text_field( $_POST['date_listed']));
		update_post_meta($post_id , 'application_deadline' , sanitize_text_field( $_POST['application_deadline']));
		update_post_meta($post_id , 'principle_duties' , sanitize_text_field( $_POST['principle_duties']));
		update_post_meta($post_id , 'relocation' , sanitize_text_field( $_POST['relocation']));
		update_post_meta($post_id , 'minimum_requirement' , sanitize_text_field( $_POST['minimum_requirement']));
		update_post_meta($post_id , 'preferred_requirement' , sanitize_text_field( $_POST['preferred_requirement']));
	}
	 
 
}
add_action('save_post' , 'wp_meta_save');