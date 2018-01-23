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
