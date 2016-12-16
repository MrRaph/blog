<?php
class TapatalkGeneral
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;
    private $option_dir;
    private $page_common;

    /**
     * Start up
     */
    public function __construct()
    {
        $this->option_dir = plugin_dir_path( __FILE__ );
        require_once $this->option_dir . 'page_common.php';
        $this->page_common = PageCommon::getInstance();
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
            'Tapatalk', 
            'manage_options', 
            'tapatalk_general_admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        //Set class property
        $this->options = get_option('tapatalk_general');
        ?>
        <div class="wrap">
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields('tapatalk_general_group');
                do_settings_sections('tapatalk_general_admin');
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
            'tapatalk_general_group', 
            'tapatalk_general',
            array($this, 'sanitize')
        );

        add_settings_section(
            'tapatalk_general', // ID
            'Tapatalk-General', // Title
            array($this, 'print_section_info'), // Callback
            'tapatalk_general_admin' // Page
        );

        add_settings_field(
            'mobile_smart_banner',
            'Mobile Smart Banner',
            array($this->page_common, 'create_section_for_checkbox'), 
            'tapatalk_general_admin',
            'tapatalk_general',
            array(
                "id" => "mobile_smart_banner",
                "group" => "tapatalk_general",
                "options" => array(
                    "desc" => 'Tapatalk will show a smart banner to mobile users, when your site is viewed by a mobile web browser.',
                ),
            )
        );

        add_settings_field(
            'facebook_twitter_deep_link',
            'Facebook and Twitter Deep Linking',
            array($this->page_common, 'create_section_for_checkbox'), 
            'tapatalk_general_admin',
            'tapatalk_general',
            array(
                "id" => "facebook_twitter_deep_link",
                "group" => "tapatalk_general",
                "options" => array(
                    "desc" => 'Allow your members to open the same blog in Tapatalk from your Facebook post / Twitter tweet.',
                ),
            )
        );

        add_settings_field(
            'indexing_enabled',
            'Google App Indexing',
            array($this->page_common, 'create_section_for_checkbox'), 
            'tapatalk_general_admin',
            'tapatalk_general',
            array(
                "id" => "indexing_enabled",
                "group" => "tapatalk_general",
                "options" => array(
                    "desc" => 'Enable Google App Indexing',
                ),
            )
        );

        add_settings_field(
            'api_key',
            'Tapatalk Key',
            array($this->page_common, 'create_section_for_text'),
            'tapatalk_general_admin',
            'tapatalk_general',
            array(
                "desc" => "This field is mandatory. Please input the key provided in tapatalk site owner account.",
                "id" => "api_key",
                "group" => "tapatalk_general",
                "title" => 'Tapatalk API Key',
                "std" => '',
            )
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        if (empty($input)) return $input;
        $bool_val = array('mobile_smart_banner', 'facebook_twitter_deep_link', 'indexing_enabled');
        $int_val = array();
        foreach ($input as $key => $value){
            if (in_array($key, $bool_val)){
                if (strtolower($value) === 'false'){
                    $input[$key] = false;
                }else{
                    $input[$key] = (bool) $value;
                }
            }
            if (in_array($key, $int_val)){
                $input[$key] = intval($value);
            }
        }
        return $input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Additional options of your sites are available in Tapatalk Admin CP.';
    }
}

if( is_admin() ){
    $tapatalkGeneral = new TapatalkGeneral();
}