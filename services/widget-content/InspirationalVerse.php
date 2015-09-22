<?php

class InspirationalVerse implements WidgetContent {

	/**
	 * Array of Verses
	 */
	protected $verses;

	/**
	 * Path to the json file
	 */
	protected $file_path = 'http://95west.co/support-api/verses.json';

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
		$this->getVerses();
		$verse_obj = $this->getRandomVerse();

		echo '<p class="quote"><span class="fa fa-quote-left"></span><em> ';
		echo $verse_obj->verse;
		echo '</em></p>';
		echo '<p class="quote-info"><strong>- ';
		echo $verse_obj->reference;
		echo '</strong></p>';
	}

	/**
	 * Get the verses file and set it to the verses property.
	 */
	private function getVerses()
	{
		$return = wp_remote_get($this->file_path);
		if (isset($return['body'])) {
			$obj = json_decode($return['body']);
			$this->verses = $obj->verses;
		}
	}

	/**
	 * Gets a random verse for the content to use.
	 */
	private function getRandomVerse()
	{
		$count = count($this->verses) - 1;
		$index = mt_rand(0,$count);
		return $this->verses[$index];
	}

}