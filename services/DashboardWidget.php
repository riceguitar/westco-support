<?php
if (!$_SERVER['HTTP_X_REQUESTED_WITH']) {
	defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );
}
include 'traits/RegistersWidgetContent.php';
include 'traits/DisplaysWidgetContent.php';
include 'AjaxHandler.php';

class DashboardWidget
{

	use RegistersWidgetContent, DisplaysWidgetContent;

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
		$this->loadContentClasses();
		$this->registerWidgetOptions();
		$this->registerWidgetAjax();
		add_action('wp_dashboard_setup', array($this, 'registerDashboardWidget'));
	}

	public function registerWidgetAjax()
	{
		$ajaxhandler = new AjaxHandler($this->options);
		add_action('wp_ajax_westco_dashboard_settings', array($ajaxhandler, 'handleAjaxRequest'));
	}

	public function registerDashboardWidget()
	{
		wp_add_dashboard_widget(
			'95_west_dashboard_support',
			'95 West Dashboard Support',
			array($this, 'dashboardWidgetDisplay')
		);
		$this->putWidgetAtTop();
	}

	private function putWidgetAtTop()
	{
		global $wp_meta_boxes;
		
		// Get the regular dashboard widgets array 
		$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
		
		// Backup and delete new dashboard widget from the end of the array
		$example_widget_backup = array( '95_west_dashboard_support' => $normal_dashboard['95_west_dashboard_support'] );
		unset( $normal_dashboard['95_west_dashboard_support'] );
		
		// Merge the two arrays together so our widget is at the beginning
		$sorted_dashboard = array_merge( $example_widget_backup, $normal_dashboard );
		
		// Save the sorted array back into the original metaboxes 
		$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
	}

	public function dashboardWidgetDisplay()
	{
		?>
		<div id="westco-dashboard-widget">
			<button class="lines-button {{settingsActive ? 'active' : ''}}" 
					type="button" 
					role="button" 
					aria-label="Toggle Navigation"
					v-on="click: toggleSettings">
			  <span class="lines"></span>
			</button>
			<div class="westco-dashboard-settings {{settingsActive ? 'active' : ''}}">
				<h3>Display Options</h3>
				<?php $this->displayWidgetSettings(); ?>
			</div>
			<div class=" westco-dashboard-body">
				<?php $this->displayWidgetContent(); ?>
			</div>
		</div>
		<?php
	}
}

// Initiates the class
DashboardWidget::getInstance();