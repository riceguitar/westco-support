<?php

interface WidgetContent {
	
	/*
	 * Registers Options for Widget Content
	 */
	public function register();

	/**
	 * Displays the content for the widget.
	 */
	public function displayContent();

}