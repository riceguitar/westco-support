<?php

class AjaxHandler {

	protected $registered_content;
	
	protected $visible_content = array();

	public function __construct($options)
	{
		$this->registered_content = $options;
		
	}

	public function handleAjaxRequest()
	{

		// Get all of the request parameters.
		foreach ($_POST['form'] as $setting) {
			// Get the setting slug
			$setting_slug = $setting['value'];
			
			// Add it to the visibile content.
			$this->visible_content[] = $setting_slug;
		}

		// Update the options
		$this->updateVisibilitySettings();

		// Die because it is an ajax request.
		wp_die();
	}


	private function updateVisibilitySettings()
	{
		foreach ($this->registered_content as $content) {
			$slug = $content['setting_slug'];
			// Is it hideable?
			if ($content['hideable'] == false) {
				continue;
			}
			
			// Is it in the visible_content property?
			if (in_array($slug, $this->visible_content)) {
				// Make it visible.
				$this->setOption($slug, true);
			} else {
				// Hide it.
				$this->setOption($slug, false);
			}
		}
	}

	private function setOption($name, $value)
	{
		$option_name = 'westco_support_' . $name;

		update_option($option_name, $value);
	}

}