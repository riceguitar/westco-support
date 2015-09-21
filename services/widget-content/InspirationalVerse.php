<?php

class InspirationalVerse implements WidgetContent {

	/**
	 * Array of Verses
	 */
	protected $verses;

	/**
	 * Registers Options for class
	 */
	public function register()
	{
		return array(
			'hideable'		=> true,
			'setting_slug'	=> 'inspirational_verse',
			'setting_title'	=> 'Inspirational Verse',
			'title'			=> 'Inspirational Verse',
		);	
	}

	/**
	 * Displays the inspirational verse
	 */
	public function displayContent()
	{
		echo 'Inspirational Verse Here';
	}

}