<?php

/*
Copyright (c) 2013 Bryce Campbell

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE. */

namespace Habari;
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
	
	// the following sets default values upon activation
	public function action_plugin_activation($file)
	{
		// set options
		Options::set('change_tag', true);
		Options::set('change_pcomments', true);
		Options::set('change_mcomments', true);
	}
	
	// the following deletes options from database
	public function action_plugin_deactivation($file)
	{
		// delete delete optiond
		Options::delete('change_tag');
		Options::delete('change_pcomments');
		Options::delete('change_mcomments');
	}
	
	// the following allows plugin configuration
	public function configure()
	{	
		// the following creates the config form
		$ui = new FormUI('feed_config');
		$tfeed = $ui->append(FormControlCheckbox::create('mod_tag', 'change_tag')->label(_t('Modify tag feed')));
		$tfeed->value = Options::get('change_tag'); // retrieve current setting
		$pcomments = $ui->append(FormControlCheckbox::create('mod_pcomments', 'change_pcomments')->label(_t('Modify post comment feeds')));
		$pcomments->value = Options::get('change_pcomments'); // retrieve current setting
		$mcomments = $ui->append(FormControlCheckbox::create('mod_mcomments', 'change_mcomments')->label(_t('Modify main comment feed')));
		$mcomments->value = Options::get('change_mcomments'); // retrieve current setting
		$ui->append(FormControlSubmit::create('save')->set_caption(_t('Save')));
		$ui->set_settings(array('success_message' => _t('Configuration saved')));
		return $ui;
	}
	
	// the following function is needed to work with the comment feeds
	public function action_atom_get_comments($xml, $params, $handler_vars)
	{
		// used to retrieve slug variable
		$slug = Controller::get_var('slug');
		
		if (Options::get('change_pcomments') && Options::get('change_mcomments'))
		{
			// the following runs the function used to manipulate the main comment feed and comment feeds for posts
			$this->feed->commentfeed($xml, $params, $handler_vars);
			$this->feed->postfeed($slug, $xml, $params, $handler_vars);
		} elseif (Options::get('change_pcomments')) {
			$this->feed->postfeed($slug, $xml, $params, $handler_vars);
		} elseif (Options::get('change_mcomments')) {
			$this->feed->commentfeed($xml, $params, $handler_vars);
		} else;
	} // end function
	
	// the following function is needed to work with the tag feed
	public function action_atom_get_collection($xml, $params, $handler_vars)
	{
		// used to retrieve tag variable
		$tag = Controller::get_var('tag');
		
		if (Options::get('change_tag'))
		{
			// the following runs the function used to manipulate tag feeds
			$this->feed->tagfeed($tag, $xml, $params, $handler_vars);
		}
	} // end function
} // end class
?>