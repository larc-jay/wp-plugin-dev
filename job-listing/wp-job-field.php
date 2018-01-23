<?php 

function wp_add_custom_metabox(){

		add_meta_box(
			'wp_meta',
			'Job Listing',
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
				<div class="meta_th">
					<label for ="job-id" class = "wp-row-title">Job ID </label>
				</div>
 				<div class="meta-td">
 					<input type="text" name="job_id" id="job-id" value="<?php if ( ! empty ( $wp_stored_meta['job_id'])) echo esc_attr($wp_stored_meta['job_id'][0]); ?>" />
 				</div>
			</div>
			<div class="meta-row">
				<div class="meta-th">
					<label for="date-listed" class="wp-row-title">Date Listed</label>
				</div>
				<div class="meta-td">
					<input type="text" name="date_listed" id ="date-listed" value="">
				</div>
			</div>
			<div class="meta-row">
				<div class="meta-th">
					<label for="date-listed" class="wp-row-title">Application Deadline</label>
				</div>
				<div class="meta-td">
					<input type="text" name="application_deadline" id ="app-deadline" value="">
				</div>
			</div>
			<div class="meta-row">
				<div class="meta-th">
					<label for="relocation" class="wp-row-title">Relocation Assistant</label>
				</div>
				<div class="meta-td">
					 <select name="relocation" id = "relocation_assistance">
					 	<option value="select-yes">Yes</option>
					 	<option value="select-no">No</option>
					 </select>
				</div>
			</div>
			<div class="meta">
				<div class="meta-th">
					<span>Principle Duties</span>
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
	</div>

<?php
}

function wp_meta_save($post_id){
	$is_autosave = wp_is_post_autosave($post_id);
	$is_revision = wp_is_post_revision($post_id);
	$is_valid_nonce = (isset( $_POST[ 'wp-job-nonce']) && wp_verify_nonce ( $_POST['wp-job_nonce']));

	if($is_autosave || $is_revision || $is_valid_nonce){
		return;
	}

	if(isset ($_POST['job_id'])){
		update_post_meta($post_id , 'job_id' , sanitize_text_field( $_POST['job_id']));
	}
}
add_action('save_post' , 'wp_meta_save');