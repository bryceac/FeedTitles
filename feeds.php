<?php

// the feeds class contains functions that will manipulate feed titles
class Feeds
{
	// tagfeed function manipulates Habari's tag feed
	public function tagfeed(&$tag)
	{
		// check if feed is a tag collection and executes the code in the block
		if ( Controller::get_action() == 'tag_collection' )
		{
			// if the condition is true, the following appends the tag name with the name of the blog
			$xml->title = ucwords(htmlentities(Tags::get_by_slug($tag))->term_display) . ' - ' . Utils::htmlspecialchars( Options::get( 'title' ) );

			// the following changes the description, or subtitle, as the ATOM standard calls it, and makes it reflect the feed
			$xml->subtitle = ' posts on ' . htmlentities(Tags::get_by_slug($tag))->term_display . ' from ' . Utils::htmlspecialchars( Options::get( 'title' ) );
		}
	} // end function
	
	// the postfeed function manipulates Habari entry comment feed
	public function postfeed(&$slug)
	{
		// check if feed is an entry comment feed and executes the code in the block
		if ( Controller::get_action() == 'entry_comments' )
		{
			// if the condition is true, the following appends the post title with the name of the blog
			$xml->title = htmlentities(Post::get(array('slug' => $slug))->title) . ' - ' . Utils::htmlspecialchars( Options::get( 'title' ) );

			// the following changes the description, or subtitle, as the ATOM standard calls it, and makes it reflect the feed
			$xml->subtitle = ' comments on ' . htmlentities(Post::get(array('slug' => $slug))->title) . ' from ' . Utils::htmlspecialchars( Options::get( 'title' ) );
		}	
	} // end function
	
	public function commentfeed()
	{
		// check if feed is the comment feed and executes the code in the block
		if ( Controller::get_action() == 'comments' )
		{
			// if the condition is true, the following appends a new name for the feed with the name of the blog
			$xml->title = 'Comments - ' . Utils::htmlspecialchars( Options::get( 'title' ) );

			// the following changes the description, or subtitle, as the ATOM standard calls it, and makes it reflect the feed
			$xml->subtitle = ' comments made on ' . Utils::htmlspecialchars( Options::get( 'title' ) );
		}
	} // end function
} // end class
?>