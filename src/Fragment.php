<?php

/**
* @module Canteen\HTML5
*/
namespace Canteen\HTML5
{
	/**
	*  Represents a set of HTML tags without a wrapper.
	*  Do not initiate this class directly, use the `html()` function:
	*
	*	$div = html('fragment');
	*
	*  @class Fragment
	*  @extends NodeContainer
	*  @constructor
	*  @param {Node|Array} [children=null] The collection of children or single child
	*/
	class Fragment extends NodeContainer
	{
		public function __construct($children = null)
		{
			parent::__construct('fragment', $children, null);
		}

		/**
		*  Write to HTML
		*  @method __toString
		*  @return {String} The string representation of this HTML node
		*/
		public function __toString()
		{
			$buffer = '';
			foreach($this->getChildren() as $child)
			{
				$buffer .= $child->__toString();
			}
			return $buffer;
		}
	}
}

?>