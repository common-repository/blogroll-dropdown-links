<?php
/*
Plugin Name: Blogroll Dropdown Links
Plugin URI: https://www.thefreewindows.com/28779/blogroll-links-dropdown-list-free-plugin-wordpress/
Description: Blogroll links presented as a space saving convenient dropdown list
Version: 1.0
License: GPLv2 or later
Tags: links manager, links, blogroll, dropdown, blogroll dropdown
Author: TheFreeWindows
Author URI: https://www.thefreewindows.com
Text Domain: blogroll
*/

class Blogroll_Dropdown_Widget extends WP_Widget {


	public function __construct() {

		// Enable Links Manager for newer WP versions
		add_filter( 'pre_option_link_manager_enabled', '__return_true', 100 );

		parent::__construct(
			'blogroll-dropdown-widget',
			__( 'Blogroll Dropdown', 'blogrolldrop' ),
			array(
				'classname'		=>	'blogroll-dropdown-widget',
				'description'	=>	__( 'Display links as dropdown', 'blogrolldrop' )
			)
		);

		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_styles' ) );

	} 


	public function widget( $args, $instance ) {

		extract( $args, EXTR_SKIP );

		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __( ' ' ) : $instance['title'], $instance, $this->id_base);
		$default_option = $instance['default_option'];
		$default_optionhrf = $instance['default_optionhrf'];
		$link_cat = $instance['link_cat'];
		$open_same_window = $instance['open_same_window'];

		echo $before_widget;

		echo $before_title . $title . $after_title;

		include( plugin_dir_path( __FILE__ ) . 'views/widget.php' );

		echo $after_widget;

	} 

	/**
	 * Saving the options
	 */

	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['default_option'] = strip_tags($new_instance['default_option']);
		$instance['default_optionhrf'] = strip_tags($new_instance['default_optionhrf']);
		$instance['link_cat'] = (int)($new_instance['link_cat']);
		$instance['open_same_window'] = $new_instance['open_same_window'];

		return $instance;

	} 

	/**
	 * Admin form
	 */

	public function form( $instance ) {

		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title' => '',
				'default_option' => 'Blogroll Dropdown',
				'default_optionhrf' => 'https://www.thefreewindows.com/',
				'link_cat' => 0
			)
		);

		$title = esc_attr( $instance['title'] );
		$default_option = esc_attr( $instance['default_option'] );
		$default_optionhrf = esc_attr( $instance['default_optionhrf'] );
		$link_cat = (int) $instance['link_cat'];
		$open_same_window = $instance['open_same_window'];

		// Display 
		include( plugin_dir_path(__FILE__) . 'views/admin.php' );

	} 

	/**
	 * Styles
	 */

	public function register_widget_styles() {

		wp_enqueue_style( 'links-widget-widget-styles', plugins_url( 'css/widget.css',__FILE__ ) );

	} 

} 

add_action( 'widgets_init', create_function( '', 'register_widget("Blogroll_Dropdown_Widget");' ) );


function blogrolldrop_categories_to_array($taxonomy){
    $terms = get_terms($taxonomy,array(
        'hide_empty'=>false
    ));
    $terms_production = array();
    foreach ($terms as $key=>$term){
        $terms_production[$term->term_id] = $term->name;
    }
    $terms_production[0] = __('All', 'blogrolldrop');
    return $terms_production;
}