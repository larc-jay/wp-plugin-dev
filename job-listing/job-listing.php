<?php 
  /**
  * Plugin Name: Job Listing
  * Plugin URI: http://jpsitgroup.com
  * Description: Aplugin for creating and displaying jobs.
  * Author: JP Singh
  * Author URI: http://jpsitgroup.com
  * Version: 1.0
  * License: JPSITV3
  */

if(! defined('ABSPATH')){
  exit;
}

$dir = plugin_dir_path(__FILE__);
require_once ( $dir . 'wp-job-cpt.php');
require_once ( $dir . 'wp-job-render-admin.php');
require_once ( $dir . 'wp-job-field.php');
require_once ( $dir . 'wp-job-shortcode.php');

function wp_admin_enque_scripts(){
    global $pagenow, $typenow;
  if($typenow =='job'){
       wp_enqueue_style( 'job-admin-css' , plugins_url( 'css/job-admin.css', __FILE__));
    }
    if(($pagenow == 'post.php' || $pagenow == 'post-new.php') && $typenow == 'job'){
     
      wp_enqueue_script( 'job-admin-js',plugins_url('js/job-admin.js' , __FILE__), array('jquery' , 'jquery-ui-datepicker'), '20150204',true);
      wp_enqueue_style( 'jquery-style','https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css' );
      wp_enqueue_script( 'job-custom-quicktags',plugins_url('js/wp-quicktags.js' , __FILE__), array('quicktags' , 'jquery-ui-datepicker'), '20160606',true);
       
    }

    if(   $pagenow =='edit.php' && $typenow=='job'){
       wp_enqueue_script( 'reorder-js',plugins_url('js/reorder.js' , __FILE__), array('jquery' , 'jquery-ui-sortable'), '20150206',true);
       wp_localize_script('reorder-js' , WP_JOB_LISTING , array(
            'security'  => wp_create_nonce( 'wp-job-order' ),
            'siteUrl' => get_bloginfo('url'),
            'success' => 'Job Sort order have been saved',
            'failure' => 'There was an error saving the sort order, or you do not have proper permission'
       ));
    }
}

add_action('admin_enqueue_scripts','wp_admin_enque_scripts');

function wp_add_submenu_page(){
  add_submenu_page( 
      'edit.php?post_type=job', 
      'Reorder Jobs', 
      'Reorder Jobs', 
      'manage_options', 
      'reorder_jobs', 
      'reorder_admin_job_callback'
    );
}
add_action('admin_menu' , 'wp_add_submenu_page');