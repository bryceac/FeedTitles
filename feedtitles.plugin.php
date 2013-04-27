<?php

/*
Copyright (c) 2013 Bryce Campbell

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE. */

// include custom class, which is needed to get things working
require_once("feeds.php");

// the FeedTitles class manipulates the feed titles and subtitles of all feeds except Habari's main feed
class FeedTitles extends Plugin
{
	private $feed;
	
	public function action_init()
	{
		// create an object of the custom class
		$this->feed = new Feeds(); 
	}
	
	// the following function is needed to work with the comment feeds
	public function action_atom_get_comments($xml, $params, $handler_vars)
	{
		// used to retrieve slug variable
		$slug = Controller::get_var('slug');
		
		// the following runs the function used to manipulate the main comment feed and comment feeds for posts
		$this->feed->commentfeed($xml, $params, $handler_vars);
		$this->feed->postfeed($slug, $xml, $params, $handler_vars);
	} // end function
	
	// the following function is needed to work with the tag feed
	public function action_atom_get_collection($xml, $params, $handler_vars)
	{
		// used to retrieve tag variable
		$tag = Controller::get_var('tag');
		
		// the following runs the function used to manipulate tag feeds
		$this->feed->tagfeed($tag, $xml, $params, $handler_vars);
	} // end function
} // end class
?>