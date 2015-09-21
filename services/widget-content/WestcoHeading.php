<?php

class WestcoHeading implements WidgetContent {

	public function register()
	{
		return array(
			'hideable'		=> false,
		);
	}

	public function displayContent()
	{
		?>
		<div class="westco-dashboard-heading">
			<img style="max-width: 30%; max-height: 30%;" src="<?php echo WESTCO_ASSETS_URL; ?>images/95west_large.png"/>
			<h3>Hi there! Let us know if you need any help :)</h3>
		</div>
		<?php
	}

}