<?php
/*
Copyright (c) 2013 Bryce Campbell

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE. */

// the feeds class contains functions that will manipulate feed titles
class Feeds
{
	// tagfeed function manipulates Habari's tag feed
	public function tagfeed(&$tag, $xml, $params, $handler_vars)
	{
		// check if feed is a tag collection and executes the code in the block
		if ( Controller::get_action() == 'tag_collection' )
		{
			// if the condition is true, the following appends the tag name with the name of the blog
			$xml->title = ucwords(htmlentities(Tags::get_by_slug($tag)->term_display)) . ' - ' . Utils::htmlspecialchars( Options::get( 'title' ) );

			// the following changes the description, or subtitle, as the ATOM standard calls it, and makes it reflect the feed
			$xml->subtitle = ' posts on ' . htmlentities(Tags::get_by_slug($tag)->term_display) . ' from ' . Utils::htmlspecialchars( Options::get( 'title' ) );
		}
	} // end function
	
	// the postfeed function manipulates Habari entry comment feed
	public function postfeed(&$slug, $xml, $params, $handler_vars)
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
	
	public function commentfeed($xml, $params, $handler_vars)
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