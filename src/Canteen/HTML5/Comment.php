<?php

/**
* @module Canteen\HTML5 
*/
namespace Canteen\HTML5
{	
	/**
	*  Special node type representing an HTML5 inline comment.
	*  Do not initiate this class directly, use the `html('comment')` function:
	*  
	*	echo html('comment', 'Hidden HTML comment here');
	*  
	*  @class Comment
	*  @extends NodeContainer
	*  @constructor
	*  @param {String} text the plain text string 
	*/
	class Comment extends NodeContainer 
	{
		public function __construct($text)
		{
			parent::__construct($text);
		}
		
		/**
		*  Write to HTML
		*  @method __toString
		*  @return {String} The string representation of this HTML node
		*/
		public function __toString()
		{
			return '<!-- '.$this->_tag.' -->';
		}
	}
}

?>