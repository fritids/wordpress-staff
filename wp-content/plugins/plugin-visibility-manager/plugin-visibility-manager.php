<?php
/*
Plugin Name: Plugin Visibility Manager
Version: 3.0
Description: Allows Super Admins to control which plugins are visible to admins of a given site within a multi-site WordPress environment. Plugins can be hidden or made visible on a site by site basis or on a site wide basis. Super Admins can activate/deactivate any plugin, but everyone else is limited only to those which are visible.
Author: Ioannis Yessios, Yale Instructional Technology Group
Author URI: http://itg.yale.edu
Plugin URI: http://itg.yale.edu/plugins/wordpress/plugins-visibility-manager
Site Wide Only: true
Network: true
*/

class pluginVisibilityManager {
	var $visible_plugins = false;
	var $site_visible_plugins = false;
	var $both_visible_plugins = false;
	var $pvm_options = false;
	
	function pluginVisibilityManager() {
		add_action( 'admin_init', array( $this, 'register_settings') );

		add_action( 'pre_current_active_plugins', array( $this, 'plugins_nav' ) );
			
		add_action('admin_init', array( $this, 'update_visible_plugins') );
		if (is_admin()) {
			add_filter( 'all_plugins', array( $this, 'remove_hidden_plugins' ), 10, 1 );
		}
		
		add_filter( 'plugin_action_links', array( $this, 'add_make_hidden'), 10, 2 );
		add_filter( 'network_admin_plugin_action_links', array( $this, 'add_network_make_hidden'), 10, 2 );
		
		add_filter( 'views_plugins', array( $this, 'views' ), 10, 1 );
		add_filter( 'views_plugins-network', array( $this, 'views' ), 10, 1 );
	}
	function register_settings() {
		register_setting( 'pluginsvisibilitymanager-option-group', 'visible_plugins_array' );
	}
	
	function views( $view) {
		if (!current_user_can('manage_network_options'))
			return $view;

		global $totals, $status;
		$view['visible'] = sprintf( '<a %shref="plugins.php?plugin_status=visible">Visible <span class="count">(%d)</span></a>', 
			( $status == 'visible' ) ? 'class="current" ':'',
			$totals['visible'] );
		$view['hidden'] = sprintf( '<a %shref="plugins.php?plugin_status=hidden">Hidden <span class="count">(%d)</span></a>', 
			( $status == 'hidden' ) ? 'class="current" ':'',
			$totals['hidden'] );
		return $view;
	}
	
	function plugins_nav() {
		if (!current_user_can('manage_network_options'))
			return;
		
		global $totals, $status, $plugins;
	
		$visible_plugins_array = $this->get_plugin_array( (is_network_admin())? 'sitewide' : 'both' );
		
		$totals['visible'] = count( $visible_plugins_array );
		$totals['hidden'] = $totals['all'] - $totals['visible'];
		//echo "<pre>"; print_r($totals); echo "</pre>";
	
		if ( isset($_REQUEST['plugin_status']) && $status != 'search' && 
			( $_REQUEST['plugin_status'] == 'visible' || $_REQUEST['plugin_status'] == 'hidden' ) ) {
			$status = $_REQUEST['plugin_status'];

			$screen = get_current_screen();
			if ( $screen->is_network && $screen->base == 'plugins-network' && $status == 'hidden') {
				$options = $this->get_site_option();
				
				if ( isset( $_REQUEST['pvm-action']) && $_REQUEST['pvm-action'] == 'dismiss' ) {
					$options['dismiss-netword-vis'] = 1; 
					update_site_option('pvm-options', $options);
				} else if ( !isset($options['dismiss-netword-vis']) || $options['dismiss-netword-vis'] != 1 ) {
					$url = $_SERVER['REQUEST_URI'] . '&pvm-action=dismiss';
					printf ('<div id="pvm-message" class="updated"><p><strong>Note:</strong> For an individual site, Super Admins can make plugins that are not visible to the network available on a site\'s plugin page.<span style="float:right"><a href="%s">Dismiss</a></span></p></div>',
						$url);
				}
			}


			$plugins['visible'] = array();
			$plugins['hidden'] = array();

			//echo "<pre>"; print_r($visible_network_plugins); echo "</pre>";			
			foreach ( $plugins['all'] as $plugin_file => $plugin_data ) {
				if ( in_array( $plugin_file, $visible_plugins_array ) )
					$plugins['visible'][$plugin_file] = $plugin_data;
				else
					$plugins['hidden'][$plugin_file] = $plugin_data;
			}

			global $wp_list_table;
			$wp_list_table->items = array();
			foreach ( $plugins[ $status ] as $plugin_file => $plugin_data ) {
				// Translate, Don't Apply Markup, Sanitize HTML
				$wp_list_table->items[$plugin_file] = _get_plugin_data_markup_translate( $plugin_file, $plugin_data, false, true );
			}
		}
	}

	function update_visible_plugins() {
		if( current_user_can( 'manage_network_options' ) && isset( $_GET['pvm_action'] )) {	

			$plugin_path = $_GET['plugin_path'];
			
			if (! wp_verify_nonce($_REQUEST['_wpnonce'], 'pvm-nonce-'. $plugin_path ) ) die('Security check'); 
			
			if ( !file_exists( ABSPATH . 'wp-content/plugins/' . $plugin_path ) )
				return;

			switch ( $_GET['pvm_action'] ) {
				case 'show_submitted':
					$add = true;
					$update_function = 'update_option';
					$get_function = 'current'; 
					break;
				case 'hide_submitted':
					$add = false;
					$update_function = 'update_option';
					$get_function = 'current'; 
					break;
				case 'network_show_submitted':
					$add = true;
					$update_function = 'update_site_option';
					$get_function = 'sitewide'; 
					break;
				case 'network_hide_submitted':
					$add = false;
					$update_function = 'update_site_option';
					$get_function = 'sitewide'; 
					break;
				default:
					return;
			}
			
			$visible_plugins_array = $this->get_plugin_array($get_function);
						
			// to show a plugin
			if( $add ) {
				if ( !in_array($plugin_path, $visible_plugins_array) )
					$visible_plugins_array[] = $plugin_path;
				sort( $visible_plugins_array );
				$this->update_plugin_array($update_function, array_unique($visible_plugins_array));
			} else {
			// to hide a plugin
				$visible_plugins_array_MODIFIED = $visible_plugins_array;
				
				if( in_array($plugin_path, $visible_plugins_array) ) {
					foreach($visible_plugins_array as $key => $item) {
						//echo "<p>$key ==> $item</p>";
						if(	$item == $plugin_path) {
							unset($visible_plugins_array_MODIFIED[$key]);
						}
					}
					$this->update_plugin_array($update_function, array_unique($visible_plugins_array_MODIFIED));
				}
			}
		}
	}
	function remove_hidden_plugins($plugins_array) {
		if ( is_network_admin() || current_user_can( 'manage_network_options' ) ) {
			return $plugins_array;
		}

		$visible_plugins_array = $this->get_plugin_array('both');
		
		$plugins_array_ON = array();
		
		foreach($visible_plugins_array as $plugin_path) {
			
			if( isset($plugins_array[$plugin_path]) ) {
				$plugins_array_ON[$plugin_path] = $plugins_array[$plugin_path];
			}
		}
		
		$plugins_array = $plugins_array_ON;
		
		// always unset the plugins visibility manager itself, as well as the themes visibility manager if it's installed
		if( isset($plugins_array['plugins-visibility-manager/plugins-visibility-manager.php']) ) {
			unset($plugins_array['plugins-visibility-manager/plugins-visibility-manager.php']);
		}
		if( isset($plugins_array['themes-visibility-manager/themes-visibility-manager.php']) ) {
			unset($plugins_array['themes-visibility-manager/themes-visibility-manager.php']);
		}
		
		return $plugins_array;	
	}
	
	function add_make_hidden( $links, $file ) {
		return $this->build_pvm_link( $links, $file, false );
	}
	
	function add_network_make_hidden( $links, $file ) {
		return $this->build_pvm_link( $links, $file, true );
	}
	
	function build_pvm_link( $links, $file, $network=false) {
		if( current_user_can( 'manage_network_options' ) ) {
			//echo ($network) ? '<p>true</p>' : '<p>false</p>';
			
			$prefix = ( $network ) ? 'network_' : '';
			$suffix = ( $network ) ? ' to Network' : '';
			
			$visible_plugins_array = ( $network ) ? array() : $this->get_plugin_array('current');
			$network_visible_plugins_array = $this->get_plugin_array('sitewide');
			
			// indicate that the visibility manager itself if ALWAYS hidden
			if( $file == 'plugins-visibility-manager/plugins-visibility-manager.php' || $file == 'themes-visibility-manager/themes-visibility-manager.php' ) {
				$settings_link = '<span style="font-weight:bold;color:red">ALWAYS HIDDEN</span>';
			} else {
				if ( in_array( $file, $network_visible_plugins_array ) ) {
					$color = 'green';
					$state = 'VISIBLE to Network';
					$pvm_action = ($network) ? $prefix . 'hide_submitted' : '';
					$action_text = 'hide';
				} else if( in_array($file, $visible_plugins_array) ) {
					$color = 'green';
					$state = 'VISIBLE';
					$pvm_action = 'hide_submitted';
					$action_text = 'hide';
				} else {
					$color = 'red';
					$state = 'HIDDEN'. $suffix;
					$pvm_action = $prefix . 'show_submitted';
					$action_text = 'make visible';
				}
				
				$settings_link = sprintf ( '<span style="font-weight:bold;color:%s">is %s</span>',
					$color,
					$state
				);
				
				if ( $pvm_action != '' ) {
					$newget['pvm_action'] = $pvm_action;
					$newget['plugin_path'] = $file;
					if (isset ($_REQUEST['plugin_status']) )
						$newget['plugin_status'] = $_REQUEST['plugin_status'];
					if (isset ($_REQUEST['paged']) )
						$newget['paged'] = $_REQUEST['paged'];
					if (isset ($_REQUEST['s']) )
						$newget['s'] = $_REQUEST['s'];
						
					$newget['_wpnonce'] = wp_create_nonce ( 'pvm-nonce-' . $file );
					
					$getstring = '';
					foreach ( $newget as $k => $v ) {
						$getstring .= "$k=$v&";
					}
					rtrim( $getstring, '&' );
					
					$settings_link .= sprintf( ' (<a href="plugins.php?%s">%s</a>)',
						$getstring,
						$action_text
					);
				}
			}
			$links = array_merge( $links, array( 'pvm' => $settings_link) ); // after other links
		}
		return $links;
	}
	function update_plugin_array( $which, $input ) {
		$which('visible_plugins_array', $input );
		switch ( $which ) {
			case 'update_option':
				$this->visible_plugins = $input;
				break;
			case 'update_site_option':
				$this->site_visible_plugins = $input;
				break;	
		}
	}
	function get_site_option() {
		if ( $this->pvm_option )
			return $this->pvm_option;
			
		return get_site_option( 'pvm-options', array() );
	}
	function get_plugin_array( $level = 'current' ) {
		switch( $level ) {
			case 'current':
				if ( !$this->visible_plugins )
					$this->visible_plugins = get_option('visible_plugins_array', array() );
				return $this->visible_plugins;
				break;
			case 'sitewide':
				if ( !$this->site_visible_plugins )
					$this->site_visible_plugins = get_site_option('visible_plugins_array', array() );
				return $this->site_visible_plugins;
				break;
			case 'both':
				if ( !$this->both_visible_plugins ) {
					if ( !$this->visible_plugins )
						$this->visible_plugins = get_option('visible_plugins_array');
					if ( !$this->site_visible_plugins )
						$this->site_visible_plugins = get_site_option('visible_plugins_array');
					$this->both_visible_plugins = array_unique( array_merge( $this->site_visible_plugins, $this->visible_plugins) );
					sort( $this->both_visible_plugins );
				}
				return $this->both_visible_plugins;
				break;		
		}
	}
	
	/**************************************************************
	* @return the major version (2 or 3)
	***************************************************************/
	function get_major_version()
	{
		global  $wp_version;
		return array_shift(explode('.',$wp_version));
	}
}

if (is_multisite())
	new pluginVisibilityManager();
?>