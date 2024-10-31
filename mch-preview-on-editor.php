<?php
/*
Plugin Name: PreviewOnEditor
Description: Add a post preview next to the editor.
Author: macha795
Version: 0.0.2
Text Domain: mch-preview-on-editor
*/



if ( !defined( 'ABSPATH' ) ) {
	exit;
}



define( 'MCH_POE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
require_once (MCH_POE_PLUGIN_DIR . 'mch_poe_main.php');



if ( function_exists( 'add_action' ) && class_exists('Mch_Preview_On_Editor') ) {
	add_action( 'plugins_loaded', array('Mch_Preview_On_Editor', 'get_object' ) );
	add_action( 'plugins_loaded', ['Mch_Preview_On_Editor', 'myplugin_load_textdomain'] );
}





//add_action( 'enqueue_block_editor_assets', 'mch_gutenberg_stylesheets_custom' );
//if ( !function_exists( 'mch_gutenberg_stylesheets_custom' ) ){
//	function mch_gutenberg_stylesheets_custom() {
//		wp_enqueue_script( 'mch' . '-gutenberg-js',  '/wp-content/plugins/preview-on-editor/js/editor/gb.js', array( 'jquery' ), false, true );
//
//	}
//}

