<?php

/**
 * Plugin short-code
 *
 * This class implements the plugin short code functionality.
 *
 * @since      1.0.0
 * @package    RestAPI
 * @subpackage restapi/includes
 * @author     anjanreddy <anjan111reddy@gmail.com>
 */
class RestAPI_Shortcode {
	
	
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	
	/**
	 * The API URL.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $api_url    The string used to store the rest api url.
	 */
	protected $api_url; 
	
	public function __construct($plugin_name,$version) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->api_url = 'https://jsonplaceholder.typicode.com/users';

	}

	/**
	 * This function calls the rest api and dispaly the user list.
	 *
	 * @since    1.0.0
	 */
	public function Validate_api_access() {
		$options = get_option('api_settings');
		
		return $options['api_key'];

	}
	/**
	 * This function calls the rest api and dispaly the user list.
	 *
	 * @since    1.0.0
	 */
	public function rest_api_users() { 
		
		$output="html-output";

		//get api admin settings 
		$obj=new RestAPI_Admin($this->plugin_name , $this->version);
		
		//get api key
		$api_key=$obj->get_ApiKey(); 
		
		//check for api-key
		if(strlen($api_key)!=10)
		{
			return "<p>Invalid API KEY<p>.<p>Please set valid API KEY in admin plugin settings.</p>";
		}
		else
		{
			$query_args = array('v' => DAY_IN_SECONDS); 
			
			//check for cache option
			$plg_cache=$obj->get_Cache(); 

			//if cache is true
			if( $plg_cache =="1") { 
				if(!wp_cache_get( $key ) ) {
					$response = wp_remote_get( add_query_arg( $query_args, $this->api_url ) ); 
					wp_cache_add( $key , $response ); 
				}
				else {
					$response = wp_cache_get( $key );
				} 
			}
			else { //without cache
				$response = wp_remote_get( add_query_arg( $query_args, $this->api_url ) ); 
			} 

			if( is_wp_error( $response ) || '200' != wp_remote_retrieve_response_code( $response ) ){
				return "API Connecting Issue";
			}

			$users = json_decode( wp_remote_retrieve_body( $response ) );  

			$output ='<table id="usergrid" class="table table-striped table-bordered"> 
			<thead>
			<tr>
				<th>ID</th>
				<th>NAME</th>
				<th>USERNAME</th>
				<th>EMAIL</th>
			</tr>
			</thead>
			<tbody>';

			foreach( $users as $user ) {
				$output.="<tr>";
				$output .= '<td><a href="#" class="dt"  data-id='.esc_html( $user->id ).'>'.esc_html( $user->id ).'</a></td>';
				$output .= '<td><a href="#" class="dt"  data-id='.esc_html( $user->id ).'>'.esc_html( $user->name ).'</a></td>';
				$output .= '<td><a href="#" class="dt"  data-id='.esc_html( $user->id ).'>'.esc_html( $user->username ).'</a></td>';
				$output .= '<td><a href="#" class="dt"  data-id='.esc_html( $user->id ).'>'.esc_html( $user->email ).'</a></td>';
				$output.="</tr>";
			}

			$output.= '</tbody></table>';

			$output.='<div class="container"><div id="modal-edit" class="modal" tabindex="-1" role="dialog">
			  <form id="form-edit" action="">
			  <div class="modal-dialog" role="document">
				 <div class="modal-content">
					<div class="modal-header">
					  <h5 class="modal-title">User Details</h5>
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					  </button>
					</div>
					<div class="modal-body">
					   <div class="form-group">
						  <label>ID: </label>
						  <span id="user_details_id"></span> 
					   </div>

					   <div class="form-group">
						  <label>Name: </label>
						  <span id="user_details_name"></span> 
					   </div>
						
						 <div class="form-group">
						  <label>User Name: </label>
						  <span id="user_details_username"></span> 
					   </div>

						<div class="form-group">
						  <label>Email: </label>
						  <span id="user_details_email"></span> 
					   </div>

						<div class="form-group">
						  <label>Phone: </label>
						  <span id="user_details_phone"></span> 
					   </div>

						<div class="form-group">
						  <label>Address: </label>
						  <span id="user_details_address"></span> 
					   </div>

						<div class="form-group">
						  <label>Company: </label>
						  <span id="user_details_cmpnyname"></span> 
					   </div>
						
						 <div class="form-group">
						  <label>Website: </label>
						  <span id="user_details_website"></span> 
					   </div>
						  
					 </div>
					<div class="modal-footer">
					   
					  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				 </div>
			  </div>
			  </form>
		   </div>'; 
			return $output; 
		}
		
		
	}

 

}
