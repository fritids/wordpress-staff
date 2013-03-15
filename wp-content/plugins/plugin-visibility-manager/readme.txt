=== Plugin Visibility Manager ===
Contributors: yianniy
Donate link: http://plugins.commons.yale.edu/plugin-visibility-manager
Tags: wpmu,plugins,visibility,administration
Requires at least: 3.0
Tested up to: 3.2.1
Stable tag: 3.0

Allows Super Admins to control which plugins are visible to admins of a given site within a multi-site WordPress environment.

== Description ==

The Plugin Visibility Manager adds granular administrative control over which plugins are visible in the plugins menu for any given site. Plugins can be made hidden or visible on a blog by blog basis (through the plugins menu). It is also possible to specify plugins that will be available for all site on the Network Admin plugins page.

Plugins can be active even if they are invisible, but this can only be controlled by Super Admins. Blog administrators can only de/activate visible plugins. (Note: plugin settings page are not affected by the plugin visibility manager.)

The Plugin Visibility Manager automatically makes itself invisible.

== Installation ==

1. Upload `plugins-visibility-manager` director to the `/wp-content/plugins/` directory
1. Network Activate the plugin through the 'Plugins' menu in WordPresss' Network Admin section.

== Frequently Asked Questions ==

= How do I make a plugin Visible/Hidden in a site? =

If you are a Super Admin, navigate to the plugins page in the admin section. Each plugin will have its visibility status (i.e. 'is Visible' or 'is Hidden'). Next to this is a link ('make visible' or 'make hidden'). Clicking on this link will change the status of this plugin in the current site.

= How do I make a plugin Visible site-wide? =

Navigate to the Plugins page in the 'Super Admin' menu. From there, find the plugin in question and click on 'make Visible'. Plugins visible to the Network will be visible on every single blog on your server.

= What does 'Hidden to the Network' mean. =

Plugins that are 'Hidden to the Network' will not be visible on individual blogs, but they can be made visible on a blog by blog basis.

== Changelog ==

= 3.0 =
Added 'Visible to Network' functionality, so that plugins can be made visible site wide (Managed through network admin plugins page). Updated interface so that plugin visibility is done purely through the plugins page. Implemented nonce.

= 2.2 =

Updated to be compatible with 3.1

= 2.1 =

Added the ability to bulk show/hide plugis only for the current site. This can be found in the Plugin Visibility Manager page in the Super Admin menu.

= 2.0 =
Original public release.