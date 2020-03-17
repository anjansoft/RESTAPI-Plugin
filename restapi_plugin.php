	<?php
	/**
	 *
	 * Plugin Name:  RestAPI
	 * Plugin URI:        
	 * Description: This pulgin will call the external REST API service and dispaly the data. 
	 * Version:       1.0.0
	 * Author:        AnjanReddy
	 * License:       GPL-3.0+
	 * License URI:   License.txt
	 * Text Domain:   restapi
	 */

	// If this file is called directly, abort.
	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	/**
	 * Currently plugin version.
	 */
	define( 'RESTAPI_VERSION', '1.0.0' );

	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-restapi-activator.php
	 */
	function activate_restapi() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-restapi-activator.php';
		RestAPI_Activator::activate();
	}

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-restapi-deactivator.php
	 */
	function deactivate_restapi() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-restapi-deactivator.php';
		RestAPI_Deactivator::deactivate();
	}  
	
	/**
	 * Register API custom url.
	 */
	function restapi_rewrites(){
		add_rewrite_rule( 'api$', 'index.php?api=users', 'top' );
	} 

	function restapi_query_vars( $query_vars ){
		$query_vars[] = 'api';
		return $query_vars;
	} 

	function restapi_parse_request( &$wp ){  
		if ( array_key_exists( 'api', $wp->query_vars ) && array_key_exists( 'api', $wp->query_vars )) { 
			$apipublic=new RestAPI_Public('api','1.0.0'); 
	} 

	}
	
	/**
	 * Uninstall plugin.
	 */
	function uninstall_restapi(){ 
		
		//  codes to perform during unistallation
	}  

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-restapi.php'; 
	register_activation_hook( __FILE__, 'activate_restapi' );
	register_deactivation_hook( __FILE__, 'deactivate_restapi' );
	register_uninstall_hook( __FILE__, array( 'restapi', 'uninstall_restapi' ) );
	
	//Begins execution of the plugin. 
	$plugin = new RestAPI();
	$plugin->run(); 
    
	add_action( 'wp_loaded', 'restapi_rewrites' );
	add_filter( 'query_vars', 'restapi_query_vars' );
	add_action( 'parse_request', 'restapi_parse_request' ); 
 