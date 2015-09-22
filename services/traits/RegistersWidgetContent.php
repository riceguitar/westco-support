<?php

/*
|--------------------------------------------------------------------------
| Registers all of the different Widget Content Classes
|--------------------------------------------------------------------------
| 
| This is a small trait who's responsibility is to extend the ability of
| the main Widget class so that it can register all of the different
| content classes and their options, which it saves to a property.
|
*/

trait RegistersWidgetContent {
	
	/**
	 * Array of class names that display content.
	 */
	public $content_classes = array(
		'WestcoHeading',
		'InspirationalVerse',
		'InspirationalQuote',
		'ContactInformation',
	);

	/**
	 * Array of options for the different content classes
	 */
	public $options = array();

	/**
	 * Loads the content classes and the content class contract
	 */
	public function loadContentClasses() {
		// Includes the WidgetContent interface.
		include (WESTCO_SUPPORT_PATH . "services/widget-content/WidgetContent.php");
		
		// Includes the Content Classes
		foreach ($this->content_classes as $content_class_name) {
			include (WESTCO_SUPPORT_PATH . "services/widget-content/$content_class_name.php");
		}
	}

	/**
	 * Registers all of the options for each content class.
	 */
	public function registerWidgetOptions()
	{
		foreach ($this->content_classes as $content_class_name) {
			$content_class = new $content_class_name;
			$this->extractOptions($content_class);
		}
	}

	private function extractOptions(WidgetContent $content_class)
	{
		// Adds the content class's settings
		$this->options[get_class($content_class)] = $content_class->register();
	}

}