<?php 
  /**
  * Plugin Name: Basic Plugin
  * Plugin URI: http://jpsitgroup.com
  * Description: Aplugin for creating and displaying jobs.
  * Author: JP Singh
  * Author URI: http://jpsitgroup.com
  * Version: 1.0
  * License: JPSITV2
  */


function wp_remove_dashboard_widgets(){
	 
	  remove_meta_box( 'dashboard_quick_press',   'dashboard', 'side' );      //Quick Press widget
      //remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );      //Recent Drafts
      remove_meta_box( 'dashboard_primary',       'dashboard', 'side' );      //WordPress.com Blog
      //remove_meta_box( 'dashboard_secondary',     'dashboard', 'side' );      //Other WordPress News
      //remove_meta_box( 'dashboard_incoming_links','dashboard', 'normal' );    //Incoming Links
}

add_action('wp_dashboard_setup', 'wp_remove_dashboard_widgets');

function wp_add_google_link(){
	global $wp_admin_bar;
	//var_dump($wp_admin_bar);
	$wp_admin_bar->add_menu(
		array(
			'id' => 'google_analytics',
			'title' => 'Google Analytics',
			'href' => "http://google.com/analytics"	
		)
	);
}

add_action('wp_before_admin_bar_render','wp_add_google_link');