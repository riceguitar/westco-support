<?php

/*
|--------------------------------------------------------------------------
| 95 West Latest Blog posts
|--------------------------------------------------------------------------
| 
| This widget content gets the latest blog post from 95 west and shows
| a small excerpt of it. It also gets the title and links to the
| last 3 blog posts and displays them.
|
*/

class LatestBlogPost implements WidgetContent {

	/**
	 * Integer showing the amount of characters that the excerpt will be.
	 */
	protected $excerpt_length = 250;

	/**
	 * Array of the last 4 posts from the 95west blog.
	 */
	protected $latest_posts;

	/**
	 * Registers all of the different settings for this Widget Content Class.
	 *
	 * @return array
	 */
	public function register()
	{
		return array(
			'hideable'		=> true,
			'setting_slug'	=> 'latest_blog_post',
			'setting_title'	=> 'Latest 95 West Blog Post',
			'title'	=> 'Latest Blog Post'
		);
	}

	/**
	 * Displays the html for this specific widget content.
	 *
	 * @return html
	 */
	public function displayContent()
	{
		$this->getRssFeed();
		$i = 1;
		foreach ($this->latest_posts as $p):
			?>
			<p><a style="font-weight: 400;" class="rsswidget" href="<?php echo $p['link']; ?>">
				<?php echo $p['title']; ?>
			</a></p>
			<?php if ($i == 1): ?>
			<span class="rss-date"><em>
				<?php echo $p['date']; ?>
			</em></span>
			<br>
			<div class="rssSummary">
				<p><?php echo $p['excerpt']; ?></p>
				<div style="
					display: inline-block;
					width: 10%;
					height: 1px;
					background: rgba(0,0,0,.1);
					vertical-align: middle;
				"></div>
				<span> Older Posts </span>
				<div style="
					display: inline-block;
					width: 10%;
					height: 1px;
					background: rgba(0,0,0,.1);
					vertical-align: middle;
				"></div>
			</div>
			<?php endif;
			$i++;
		endforeach;
	}

	/**
	 * Connects to the rss feed and creates the latest posts object
	 */
	private function getRssFeed()
	{
		// Get the latest 
		$rss = new DOMDocument();
		$rss->load('http://www.95west.co/feed/');
		$content_array = $rss->getElementsByTagName('item');
		$all_posts = array();
		// Build up the array
		foreach ($content_array as $content) {
			$post = array();
			// Get the title of the post
			$post['title'] = $content->getElementsByTagName('title')->item(0)->nodeValue;
			// Create an excerpt of the post.
			$full_content = $content->getElementsByTagName('description')->item(0)->nodeValue;
			$post['excerpt'] = $this->getShortVersion($full_content);
			
			$post['link'] = $content->getElementsByTagName('link')->item(0)->nodeValue;
			
			$date = $content->getElementsByTagName('pubDate')->item(0)->nodeValue;
			$post['date'] = date('F d, Y', strtotime($date));
			
			array_push($all_posts, $post);
		}

		// Set the property
		$this->latest_posts = array(
			$all_posts[0],
			$all_posts[1],
			$all_posts[2],
			$all_posts[3],
		);
	}

	/**
	 * Creates the excerpt for the post based on $excerpt_length property.
	 *
	 * @param string $full_content
	 * @return string
	 */
	private function getShortVersion($full_content)
	{
		return substr($full_content, 0, $this->excerpt_length) . ' ...';
	}
}