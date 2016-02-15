<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

class AdminMenuBar
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
		// Exit if we are in the customizer
		global $wp_customize;
		if (isset($wp_customize)) {
			return;
		}
		
		// Add Icon in both Admin and Front End
		add_action('wp_enqueue_scripts', array($this, 'addAdminBarIcon'));
		add_action('admin_enqueue_scripts', array($this, 'addAdminBarIcon'));

		// // Add intercom icon in admin and frontend
		// if (current_user_can('manage_options')) {
		// 	add_action('wp_enqueue_scripts', array($this, 'addIntercom'));
		// 	add_action('admin_enqueue_scripts', array($this, 'addIntercom'));
		// }

		// Adds the 95 west icon
		add_action('admin_bar_menu', array($this, 'addAdminBarMenu'));
		add_action('admin_bar_menu', array($this, 'removeWordPressMenu'), 20);
	}

	/**
	 * Adds the needed css to add the 95 west icon into the admin bar
	 */
	public function addAdminBarIcon()
	{
		?>
		<style type="text/css">
	 	#wpadminbar #wp-admin-bar-95-west-support>.ab-item:before {
	 		display: block;
	 		width: 22px;
	 		height: 22px;
	 		margin: 5px;
	 		padding: 0;
	 		content: '';
	 		background-image: url("<?php echo WESTCO_ASSETS_URL; ?>images/95west_icon.png") !important;
	 		background-size: contain;
		}
	 	#wpadminbar #wp-admin-bar-95-west-support>.ab-item {
			padding: 0 5px;
		}
		</style>
		<?php
	}

	/**
	 * Adds the 95 west support menu to the admin bar.
	 */
	public function addAdminBarMenu($wp_admin_bar)
	{
		$args = array(
			'id'    => '95-west-support',
			'title' => '',
			'meta'  => array( 'class' => 'my-toolbar-page' )
		);

		$wp_admin_bar->add_node($args);

		$args = array();
			
		array_push($args, array(
			'id'		=>	'home',
			'title'		=>	'Visit 95 West',
			'href'		=>	WESTCO_HOME_PAGE,
			'parent'	=>	'95-west-support',
		));

		// array_push($args, array(
		// 	'id'     	=> 'support',
		// 	'title'		=>	'Create a Support Ticket',
		// 	'href'		=> '#',
		// 	'parent' 	=> '95-west-support',
		// 	'meta'		=> array(
		// 		'class' => 'intercom-activate',
		// 	),
		// ));
		sort($args);
		for($a=0;$a<sizeOf($args);$a++)
		{
			$wp_admin_bar->add_node($args[$a]);
		}
	}

	/**
	 * Removes the standard WordPress Menu from the admin bar.
	 */
	public function removeWordPressMenu($wp_admin_bar)
	{
		$wp_admin_bar->remove_node('wp-logo');
		$wp_admin_bar->remove_node('about');
		$wp_admin_bar->remove_node('wporg');
		$wp_admin_bar->remove_node('documentation');
		$wp_admin_bar->remove_node('support-forums');
		$wp_admin_bar->remove_node('feedback');
	}

	/**
	 * Adds the intercom chat to the bottom of the page.
	 */
	public function addIntercom()
	{
		?>
			<a class="intercom-activate intercom-button" href="#">
				<p>Chat with</p> 
				<div class="westco-icon" style="background: url('<?php echo WESTCO_ASSETS_URL; ?>images/95west_large.png') no-repeat center;"></div>
			</a>
		<?php
	}
}

// Initiates the class.
AdminMenuBar::getInstance();