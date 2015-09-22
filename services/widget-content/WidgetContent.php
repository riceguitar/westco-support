<?php
 /*
 |--------------------------------------------------------------------------
 | Widget Content Interface
 |--------------------------------------------------------------------------
 |
 | This is the main interface that MUST be implemented for each widget
 | content class in order for it to work. It creates the contract
 | that every content class is responsible for registering it's
 | own settings, and displaying it's own widgetized content.
 |
 */
 
interface WidgetContent {
	
	/**
	 * Registers Options for Widget Content by returning an associative array
	 *
	 * @return array
	 */
	public function register(); /*
	-----------------------------------------------------------
	 Avaliable configurable values for a widget content class. 
	-----------------------------------------------------------

	 hideable => bool (required)
	 	- Whether or not the user has the option to hid the
	 	  widget's content from the setting panel.

	 setting_slug => string (required if hideable is set to true)
	 	- This is the slug that will be put in the database that
		  points to the setting of whether or not the widget
		  content is hidden.

	 setting_title => string (required if hideable is set to true)
	 	- This is the title that will be in the settings panel for
	 	  the widget content.

	 title => string (optional)
	 	- This is the tile of the widget content that is displayed
	 	  in the actual widget. If not set, there will be no title
	 	  or wrapper div that normally would wrap the title.

	-----------------------------------------------------------*/


	/**
	 * Displays the content for the widget.
	 *
	 * @return html
	 */
	public function displayContent();

}