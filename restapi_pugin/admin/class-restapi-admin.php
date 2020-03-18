<?php  
/**
 * The admin-specific functionality of the plugin. 
 *
 * @package    restapi
 * @subpackage restapi/admin
 * @author     anjanreddy <anjan111reddy@gmail.com>
 */
class RestAPI_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $restapi    The ID of this plugin.
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
	public function __construct( $plugin_name, $version ) {
		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) ); 
		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() { 

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-name-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() { 

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-admin.js', array( 'jquery' ), $this->version, false );

	}

	 

	/**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Admin Settings', 
            'REST-API', 
            'manage_options', 
            'api_settings', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'plg_settings' );
        ?>
        <div class="wrap">
            <h1>REST-API</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'api_settings_group' );
                do_settings_sections( 'api_settings' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'api_settings_group', // Option group
            'plg_settings', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'API Custom Settings', // api_key
            array( $this, 'print_section_info' ), // Callback
            'api_settings' // Page
        );  

        add_settings_field(
            'plg_cache', // ID
            'Cache', // api_key 
            array( $this, 'cache_callback' ), // Callback
            'api_settings', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'api_key', 
            'API_KEY', 
            array( $this, 'api_key_callback' ), 
            'api_settings', 
            'setting_section_id'
        );      
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['plg_cache'] ) )
            $new_input['plg_cache'] = absint( $input['plg_cache'] );

        if( isset( $input['api_key'] ) )
            $new_input['api_key'] = sanitize_text_field( $input['api_key'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Please add api settings below.';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function cache_callback()
    { 
		if($this->options['plg_cache']==1){
			printf('<select  id="plg_cache" name="plg_settings[plg_cache]" value="%s" /><option value=1 selected>True</option><option value=0>False</option></select>',""); 
		}
		else {
			printf('<select  id="plg_cache" name="plg_settings[plg_cache]" value="%s" /><option value=1>True</option><option value=0 selected>False</option></select>',""); 
		} 
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function api_key_callback()
    {
        printf(
            '<input type="text" id="api_key" name="plg_settings[api_key]" value="%s" size="25" maxlength="20"/>',
            isset($this->options['api_key'] ) ? esc_attr( $this->options['api_key']) : ''
        );
    }

	public function get_ApiKey(){  
	 $settings = get_option( 'plg_settings' ); 
	 return $settings['api_key']; 
	}

	public function get_Cache() 
	{  
	 $settings = get_option( 'plg_settings' );
	  return $settings['plg_cache'];
	}

}
