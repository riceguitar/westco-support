<?php

/*
|--------------------------------------------------------------------------
| Displays all of the different registered Widget Content
|--------------------------------------------------------------------------
|
| This is a small trait that extends the ability of the main widget class.
| It handles parsing each of the widget, displaying the correct content
| as well as creating the settings panel inside of the widget.
|
*/

trait DisplaysWidgetContent {
	
	/**
	 * Options for the opening and closing of each content area
	 */
	public $displayOptions = array(
		'opening' => '<div class="westco-content-entry">',
		'closing' => '</div>',
		'last' 	  => '<div class="westco-content-entry last">',
	);


	/**
	 * Loops through the content of the classes and displays all content.
	 */
	public function displayWidgetContent()
	{
		$i = 0;
		$length = count($this->content_classes) - 1;

		foreach($this->content_classes as $content_class_name) {
			if ($i == $length) {
				$this->parseClassContent($content_class_name, true);
			} else {
				$this->parseClassContent($content_class_name);
			}
			$i++;
		}
	}

	public function displayWidgetSettings()
	{
		?>
		<form id="westco_dashboard_settings_form">
		<?php
		foreach($this->options as $setting_options) {
			if ($setting_options['hideable']) {
				?>
				<div class="content-setting">
				<?php
				$this->displayContentForOption($setting_options);
				?>
				</div>
				<?php
			}
		}
		?>
		<div class="westco_save_settings_wrap">
			<button id="westco_save_settings" 
					class="page-title-action"
					type="submit"
					v-html="buttonContent"
					v-on="click: saveDisplaySettings"></button>
		</div>
		</form>
		<?php
	}

	/**
	 * Checks a class to see if it shoul be displayed and displays it
	 */
	private function parseClassContent($content_class_name, $last = false)
	{
		// Get the opening and closing tags for the entry
		$options = $this->options[$content_class_name];
		$main_open = $this->displayOptions['opening'];
		$main_close = $this->displayOptions['closing'];
		$title_open = '<div class="westco-entry-heading"><h3>';
		$title_close = '</h3></div>';
		$body_open = '<div class="westco-entry-body">';
		$body_close = '</div>';
		$title = $options['title'];
		// No title to display
		if(! $title) {
			$title_open = '';
			$title_close = '';
		}
		// Is it the last iteration?
		if ($last) {
			$main_open = $this->displayOptions['last'];
		}

		// Get the content class object.
		$content_class = new $content_class_name;
		
		// Is the content hideable?
		if (! $options['hideable']) {
			echo $main_open . $title_open . $title . $title_close . $body_open;
			$content_class->displayContent();
			echo $body_close . $main_close;
			return;
		}

		// Did the user hide the option?
		if ($this->isHidden($options)) {
			echo $main_open . $title_open . $title . $title_close . $body_open;
			$content_class->displayContent();
			echo $body_close . $main_close;
			return;
		}
		// It is hidden so display nothing.
		return;
	}

	/**
	 * Checks with the database to see if the content class is set to hidden.
	 */
	private function isHidden($options)
	{
		$displayable = get_option('westco_support_' . $options['setting_slug'], 'not_set');
		if ($displayable == 1) {
			// Not set to hidden
			return true;
		} else if ($displayable == 0) {
			// Set to hidden
			return false;
		} else if ($displayable === 'not_set') {
			// Never set
			add_option('westco_support_' . $options['setting_slug'], true);
			return true;
		}
	}


	private function displayContentForOption($setting_options)
	{
		$slug = $setting_options['setting_slug'];
		$checked = $this->checkForOption($slug);
		
		echo '<div class="westco_dashboard_setting">';
		echo '<input type="checkbox" name="setting_display[' . $slug . ']" value="' . $slug . '"' . $checked . '>';
		echo $setting_options['setting_title'];
		echo '<br/>';
		echo '</div>';
	}

	private function checkForOption($setting_slug)
	{
		$option_name = 'westco_support_' . $setting_slug;
		$option = get_option($option_name, 'not_found');
		if ($option == 'not_found') {
			update_option($option_name, true);
			return ' checked';
		}
		if ($option) {
			return ' checked';
		}
		return false;
	}
}