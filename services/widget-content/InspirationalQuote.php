<?php

class InspirationalQuote implements WidgetContent {

	/**
	 * Array of quotes
	 */
	protected $quotes;

	/**
	 * Path to the json file
	 */
	protected $file_path = 'http://95west.co/support-api/quotes.json';

	/**
	 * Registers Options for class
	 */
	public function register()
	{
		return array(
			'hideable'		=> true,
			'setting_slug'	=> 'inspirational_quote',
			'setting_title'	=> 'Inspirational Quotes',
			'title'			=> 'Inspirational Quote',
		);	
	}

	/**
	 * Displays the inspirational quote
	 */
	public function displayContent()
	{
		$this->getQuotes();
		$quote_obj = $this->getRandomVerse();

		echo '<p class="quote"><span class="fa fa-quote-left"></span><em> ';
		echo $quote_obj->quote;
		echo '</em></p>';
		echo '<p class="quote-info"><strong>- ';
		echo $quote_obj->reference;
		echo '</strong></p>';
	}

	/**
	 * Get the quotes file and set it to the quotes property.
	 */
	private function getQuotes()
	{
		$return = wp_remote_get($this->file_path);
		if (isset($return['body'])) {
			$obj = json_decode($return['body']);
			$this->quotes = $obj->quotes;
		}
	}

	/**
	 * Gets a random quote for the content to use.
	 */
	private function getRandomVerse()
	{
		$count = count($this->quotes) - 1;
		$index = mt_rand(0,$count);
		return $this->quotes[$index];
	}

}