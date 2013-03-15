<?php
/**
 * Plugin Name: WRDSB Elementary Schools Top Menu Links
 * Plugin URI: http://www.wrdsb.ca
 * Description: Inserts topmenu links
 * Version: 0.1
 * Author: Michael Denny
 */

/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'wrdsb_top_menu' );

function wrdsb_top_menu() {
	register_widget( 'wrdsb_top_menu' );
}

class wrdsb_top_menu extends WP_Widget {

	function wrdsb_top_menu() {
		$widget_ops = array( 'classname' => 'wrdsb_top_links', 'description' => __('Displays Top Menu Links', 'wrdsb_top_links') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'wrdsb_top_links-widget' );
		$this->WP_Widget( 'wrdsb_top_links-widget', __('WRDSB Top Menu Links', 'wrdsb_top_links'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
echo '
    <div id="nav_menu-3" class="widget_nav_menu widget clearfix"><div class="menu-top-menu-container"><ul id="menu-top-menu" class="menu"><li id="menu-item-6" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-6"><a href="http://www.wrdsb.ca/home">Home</a></li>
<li id="menu-item-7" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-7"><a href="http://www.wrdsb.ca/about">About Us</a></li>
<li id="menu-item-8" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-8"><a href="http://www.wrdsb.ca/programs">Programs</a></li>
<li id="menu-item-9" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-9"><a href="http://www.wrdsb.ca/schools">Schools</a></li>
<li id="menu-item-10" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-10"><a href="http://www.wrdsb.ca/careers">Careers</a></li>
<li id="menu-item-11" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-11"><a href="http://staff.wrdsb.ca">Staff</a></li>
</ul></div></div>
';
	}



}

?>