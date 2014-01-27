<?php
/**
 * Plugin Name: Forge Facebook Connect
 * Plugin URI: http://www.forgeandsmith.com
 * Description: Connect to facebook for logins and registration
 * Version: .1
 * Author: Jon Campbell of Forge and Smith
 * Author URI: http://www.forgeandsmith.com
 * License: GPL2
 */













class FFCSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'Forge Facebook Connect', 
            'manage_options', 
            'ffc-setting-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'ffc_general' );
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>Forge Facebook Connect</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'ffc_general_group' );   
                do_settings_sections( 'ffc-setting-admin' );
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
            'ffc_general_group', // Option group
            'ffc_general', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'ffc-settings-general', // ID
            'Forge Facebook Connect', // Title
            array( $this, 'print_section_info' ), // Callback
            'ffc-settings-admin' // Page
        );  

        add_settings_field(
            'id_number', // ID
            'ID Number', // Title 
            array( $this, 'id_number_callback' ), // Callback
            'ffc-settings-admin', // Page
            'ffc-settings-general' // Section           
        );      

        add_settings_field(
            'title', 
            'Title', 
            array( $this, 'title_callback' ), 
            'ffc-settings-admin', 
            'ffc-settings-general'
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
        if( isset( $input['id_number'] ) )
            $new_input['id_number'] = absint( $input['id_number'] );

        if( isset( $input['title'] ) )
            $new_input['title'] = sanitize_text_field( $input['title'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function id_number_callback()
    {
        printf(
            '<input type="text" id="id_number" name="ffc_general[id_number]" value="%s" />',
            isset( $this->options['id_number'] ) ? esc_attr( $this->options['id_number']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function title_callback()
    {
        printf(
            '<input type="text" id="title" name="ffc_general[title]" value="%s" />',
            isset( $this->options['title'] ) ? esc_attr( $this->options['title']) : ''
        );
    }
}

if( is_admin() )
    $ffc_settings_page = new FFCSettingsPage();





// Check if they are logged in

// Load up facebook script files when needed

// 

// Set up shortcode for showing login button

// Set up template piece for facebook login

// Set up template piece for facebook registration

