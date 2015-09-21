<?php

class ContactInformation implements WidgetContent {


	private $email = 'mail@95west.co';
	private $phone = '(916) 581-0303';
	private $websiteUrl = 'http://www.95west.co';
	/*
	 * Registers Options for Widget Content
	 */
	public function register()
	{
		return array(
			'hideable'		=> false,
			'title'			=> 'Get in touch!',
		);
	}

	/**
	 * Displays the content for the widget.
	 */
	public function displayContent()
	{
		echo '<p><span style="display: inline-block; vertical-align:middle;" class="fa fa-phone fa-lg"></span> ' . $this->phone . '</p>';
		echo '<p><span style="display: inline-block; vertical-align:middle;" class="fa fa-envelope"></span> ' . $this->email . '</p>';
		echo '<p><a href="' . $this->websiteUrl . '">Visit Our Website</a> / <a href="#" class="intercom-activate">Chat with us</a></p>';
	}	
	
}