<?php

defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

class LoginForm 
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
	public static function getInstance()
	{
		if ( !self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}	

	/**
	 * Sets up the login class and calls all needed functions to set up the login
	 */
	private function __construct()
	{
		add_action('login_enqueue_scripts', array($this, 'addLoginLogo'));
		add_filter('login_headerurl', array($this, 'addLoginUrl'));
		add_filter('login_headertitle', array($this, 'addLoginHoverText'));
		add_filter('login_message', array($this, 'addLoginText'));
	}

	/**
	 * Outputs the css file needed to add a custom logo to the login screen
	 * 
	 * @return css
	 */
	public function addLoginLogo()
	{
		?>
		<style type="text/css">
			.login h1 a {
			    background-image: url(<?php echo WESTCO_ASSETS_URL; ?>/images/95west_large.png);
			}
		</style>
		<?php
	}

	/**
	 * Outputs the url to the 95 West Home Page
	 */
	public function addLoginUrl()
	{
		return WESTCO_HOME_PAGE;
	}
	
	/**
	 * Changes the hover text for the login page logo
	 */
	public function addLoginHoverText()
	{
		return '95 West - Proudly powered by WordPress.';
	}

	/**
	 * Changes the hover text for the login page logo
	 */
	public function addLoginText()
	{
		return '<h3 style="text-align: center; margin-bottom: 10px;">Proudly powered by WordPress.</h3>';
	}

}

LoginForm::getInstance();
