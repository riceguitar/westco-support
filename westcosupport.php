<?php
/*
    Plugin Name: 95 West Support
    Plugin URI: http://95west.co
    Description: Thanks for choosing 95 West! We are here to help you. On top of making some tweaks to better your website, this plugin makes it easy for you to reach us for any concerns or questions you might have!
    Version: 0.1
    Author: 95 West
    Author URI: https://95west.co/
*/

defined('ABSPATH') or die('Plugin file cannot be accessed directly.');

/*
|--------------------------------------------------------------------------
| Main 95 West Support Plugin Class
|--------------------------------------------------------------------------
|
| This is the main class for the 95 west support plugin. Its purpose
| is to set up the plugin by defining all of the global variables
| and service classes that are needed for the plugin to work
|
*/

class Westco_Support
{
    /*
     * Static property to hold singelton instance
     */
    protected static $instance = false;

    /**
     * Returns a singelton instance of the class
     *
     * @return Westco_Support
     */
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Sets up and initiates the Westco_Support class
     */
    public function __construct()
    {
        /*
        GLOBAL VARIABLES
        */

        // The main 95 West Support plugin file.
        if (!defined('WESTCO_SUPPORT_FILE')) {
            define('WESTCO_SUPPORT_FILE', __FILE__);
        }
        // Url to the main 95 West Support plugin file.
        if (!defined('WESTCO_SUPPORT_URL')) {
            define('WESTCO_SUPPORT_URL', plugin_dir_url(__FILE__));
        }
        // Path to the main 95 West Support plugin file.
        if (!defined('WESTCO_SUPPORT_PATH')) {
            define('WESTCO_SUPPORT_PATH', plugin_dir_path(__FILE__));
        }
        // Url to plugin styles
        if (!defined('WESTCO_ASSETS_URL')) {
            define('WESTCO_ASSETS_URL', WESTCO_SUPPORT_URL . 'assets/');
        }
        // Path to plugin styles
        if (!defined('WESTCO_ASSETS_PATH')) {
            define('WESTCO_ASSETS_PATH', WESTCO_SUPPORT_PATH . 'assets/');
        }
        // Path to 95 West Home Page
        if (!defined('WESTCO_HOME_PAGE')) {
            define('WESTCO_HOME_PAGE', 'http://www.95west.co/');
        }

        add_action('init', array($this, 'enqueueAssets'));
        add_action('init', array($this, 'initializeServices'));
    }

    /**
     * Adds all actions needed to load css and js assets where they need to be loaded.
     */
    public function enqueueAssets()
    {
        add_action('admin_enqueue_scripts', array($this, 'enqueueAdminAssets'));
        add_action('login_enqueue_scripts', array($this, 'enqueueLoginAssets'));
        add_action('wp_enqueue_scripts', array($this, 'enqueueFrontEndAssets'));
    }

    /**
     * Enqueues all assets for the admin area.
     */
    public function enqueueAdminAssets()
    {
        // Exit if we are in the customizer
        global $wp_customize;
        if (isset($wp_customize)) {
            return;
        }

        wp_enqueue_style('westco_admin_style', WESTCO_ASSETS_URL . 'css/westco_admin.css');
        wp_enqueue_style('westco_fontawesome', WESTCO_ASSETS_URL . 'vendor/font-awesome/css/font-awesome.min.css');
        wp_enqueue_script('westco_vue', WESTCO_ASSETS_URL . 'vendor/vuejs/vue.min.js');
        wp_enqueue_script('westco_vue_resource', WESTCO_ASSETS_URL . 'vendor/vuejs/vue-resource.min.js');
        wp_enqueue_script('westco_dashboard_js', WESTCO_ASSETS_URL . 'js/westco_dashboard.js');
        wp_enqueue_script('westco_intercom', WESTCO_ASSETS_URL . 'js/intercom.js');

        // Give needed varialbes to script
        wp_localize_script('westco_dashboard_js', 'WPURLS', array( 'westcoAjaxUrl' => WESTCO_SUPPORT_URL . 'services/AjaxHandler.php' ));
    }

    /**
     * Enqueues all assets for the login area.
     */
    public function enqueueLoginAssets()
    {
        wp_enqueue_style('westco_login_style', WESTCO_ASSETS_URL . 'css/westco_login.css');
    }

    /**
     * Enqueues all assets for front end.
     */
    public function enqueueFrontEndAssets()
    {

        wp_enqueue_style('westco_style', WESTCO_ASSETS_URL . 'css/westco_style.css');      

        // If admin, and not in customizer load intercom.
        global $wp_customize;
        if (!isset($wp_customize) && current_user_can('manage_options')) {
            wp_enqueue_script('westco_intercom', WESTCO_ASSETS_URL . 'js/intercom.js');
        }  
    }

    /**
     * Initializes all services of the plugin by including their classes.
     */
    public function initializeServices()
    {
        include_once 'services/LoginForm.php';
        include_once 'services/AdminMenuBar.php';
        include_once 'services/DashboardWidget.php';
        include_once 'services/WestcoSupportUpdater.php';
        // $this->runUpdater();
    }

    /**
     * Instantiates the updater class
     */
    private function runUpdater()
    {
        // Set up all of the github stuff.
        $username = 'riceguitar';
        $repo = 'westco-support';
        new WestcoSupportUpdater(__FILE__, $username, $repo);
    }
}

// Initiates the class.
Westco_Support::getInstance();