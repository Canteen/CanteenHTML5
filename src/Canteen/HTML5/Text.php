<?php

/**
*  @module Canteen\HTML5
*/
namespace Canteen\HTML5
{
	/**
	*  Special Node representing plain text. Do not initiate this 
	*  class directly, it is created whenever a text is passed into 
	*  a container tag:
	*  
	*	echo html('p', 'Some Text Here');
	*  
	*  @class Text
	*  @extends Node
	*  @constructor
	*  @param {String} text the plain text string 
	*/
	class Text extends Node 
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
			return $this->_tag;
		}
	}
}

?>