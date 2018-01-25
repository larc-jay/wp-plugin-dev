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

function wp_admin_enque_scripts(){
    global $pagenow, $typenow;

    if(($pagenow == 'post.php' || $pagenow == 'post-new.php') && $typenow == 'job'){
      wp_enqueue_style( 'job-admin-css' , plugins_url( 'css/job-admin.css', __FILE__));
      wp_enqueue_script( 'job-admin-js',plugins_url('js/job-admin.js' , __FILE__), array('jquery' , 'jquery-ui-datepicker'), '20150204',true);
      wp_enqueue_style( 'jquery-style','https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css' );
      wp_enqueue_script( 'job-custom-quicktags',plugins_url('js/wp-quicktags.js' , __FILE__), array('quicktags' , 'jquery-ui-datepicker'), '20160206',true);
       
    }

}

add_action('admin_enqueue_scripts','wp_admin_enque_scripts');