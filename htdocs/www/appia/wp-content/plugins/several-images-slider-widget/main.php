<?php
/*
Plugin Name: Several Images Slider Widget
Plugin URI: https://wordpress.org/plugins/several-images-slider-widget/
Description: This plugin provides the feature to add a single image or slider in your sidebar using the widget. The plugin have many options for display random images in the front end, multiple items in the slide, enable/disable pagination & navigation and much more.
Version: 2.3
Author: Galaxy Weblinks
Author URI: https://www.galaxyweblinks.com/
Text Domain: sisw_gwl
License:GPL2
*/
defined('ABSPATH') or die('No script kiddies please!');

require("includes/image_widget.php"); // Widget code

/* Register activation hook. */
register_activation_hook( __FILE__, 'sisw_gwl_activate' );

/**
 * Runs only when the plugin is activated.
 */
function sisw_gwl_activate() 
{
    update_option( 'sisw_gwl_version','2.3');
}

class SISW_multi_image_slider_widget
{
	function __construct()
	{
		add_action('admin_enqueue_scripts', array($this,'sisw_image_slider_enqueue_script'));
		add_action('wp_enqueue_scripts', array($this,'sisw_frontend_multi_image_widget_custom_css'));
	}

	function sisw_image_slider_enqueue_script() {   //Enqueue sscript on widget page
		global $pagenow;
		if($pagenow=='widgets.php'||$pagenow=='customize.php')
		{
			wp_enqueue_style( 'sisw-admin-style', plugins_url( '/', __FILE__ ).'assets/css/admin-style.css');
			wp_enqueue_media();
			
			wp_enqueue_script('jquery-ui-core');

			$sisw_translation_array = array(
			'newtab_string' => __( 'Open link in a new tab', 'sisw_gwl' ),
			'newtab_value' => __( 'New tab', 'sisw_gwl' ),
			'sametab_value' => __( 'Same tab', 'sisw_gwl' ),
			'confirm_message' => __( 'This is the last image of this Widget. Are you sure want to proceed.', 'sisw_gwl' )
			);
	        wp_register_script( 'sisw-admin-script', plugins_url( '/', __FILE__ ).'assets/js/admin.js',array("jquery"));
			wp_localize_script( 'sisw-admin-script', 'sisw_admindata', $sisw_translation_array );
			wp_enqueue_script( 'sisw-admin-script');
		}
	}

	/*Frontend style and script*/
	function sisw_frontend_multi_image_widget_custom_css()
	{
		wp_enqueue_style( 'sisw-front-style', plugins_url( '/', __FILE__ ).'assets/css/front-style.css');
		wp_enqueue_style('sisw-carousal-theme',plugins_url( '/', __FILE__ ).'assets/css/owl.theme.default.min.css');
		wp_enqueue_style('sisw-carousal-min',plugins_url( '/', __FILE__ ).'assets/css/owl.carousel.min.css');		

		wp_enqueue_script('sisw-carousal-script',plugins_url( '/', __FILE__ ).'assets/js/owl.carousel.js', array("jquery"), false, true);	    
	}

}
$sisw = new SISW_multi_image_slider_widget();