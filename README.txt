=== RestAPI===

Contributors: inpsyde 
Tags: REST API, WebService, JSON Response , External webrequest. 
Requires at least: 3.0.1
Tested up to: 5.3.2
Stable tag: 5.3
License: GPLv2 or later
License URI:  

This plugin allows you to make a external REST API call and display data from external website.

== Description ==

This plugin allows you to make a external REST API call and display data from external website.  

== Requirements ==

1.WordPress version 3.0 and later.
2.PHP 5.2 or later.
3.Single or Multisite installation.

== Installation == 

1. Unzip the downloaded package.
2. Upload folder include the file to the /wp-content/plugins/ directory.
3. Activate the plugin through the Plugins menu in WordPress.
4. Please include short-code [restapi_shortcode] in page content to display the API user list.
5. Also you can place <?php do_action('restapi_hook'); ?> in your templates and select this template to a page in admin section.

==Settings ==

You can change the settings of REST API plugin in Settings -> Reading.

==Classes==

 RestAPI             Load's the required dependencies for this plugin.
 RestAPI_Loader      Register the hooks of the plugin.
 RestAPI_Activator   Define code to excute on plugin activation
 RestAPI_Deactivator Define code to excute on plugin deactivation.
 RestAPI_i18n        Defines internationalization functionality.
 RestAPI_Shortcode   Defines plugin short-code functionality.
 RestAPI_Widget      Defines plugin widget functionality.
 RestAPI_Admin       Defines all hooks for the admin area.
 RestAPI_Public      Defines all hooks for the public side of the site. 

== Screenshots ==

1. This screen shot description corresponds to screenshot-1. 

== Changelog ==