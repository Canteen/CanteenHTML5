<?php

/**
* @module Canteen\HTML5 
*/
namespace Canteen\HTML5
{	
	/**
	*  Convenience class for creating an ordered or un-ordered list.
	*  
	*	$list = new Canteen\HTML5\SimpleList(
	*		array(
	*			html('b', 'first'),
	*			'second', 
	*			'third',
	*			array(
	*				'sub-third',
	*				'sub-forth'
	*			)
	*		)
	*	);
	*  
	*  @class SimpleList
	*  @extends NodeContainer
	*  @constructor
	*  @param {Array} [elements=null] The array of child Nodes, Strings, etc.
	*  @param {String|Dictionary} [attributes=null] The optional attributes
	*  @param {String} [type='ul'] The type of list, either ul or ol
	*/
	class SimpleList extends NodeContainer
	{
		public function __construct($elements=null, $attributes=null, $type='ul')
		{
			parent::__construct($type, null, $attributes);
			
			if ($elements != null)
			{
				assert(is_array($elements));

				foreach($elements as $child)
				{
					$this->addChild($child);
				}
			}
		}
		
		/**
		*  Override for the prepareChild method on NodeContainer which 
		*  wraps each elements in a list item
		*  @method prepareChild
		*  @protected
		*  @param {Node|String|Number|Boolean|Array} childNode The child node to add, an array will get converted into another list elements.
		*  @return {Node} The child node
		*/
		protected function prepareChild($childNode)
		{
			// Recursively create new lists for each array
			if (is_array($childNode))
			{
				$list = new SimpleList($childNode, null, $this->_tag);
				return $this->prepareChild($list);
			}
			else
			{
				$childNode = parent::prepareChild($childNode);
				return html('li', $childNode);
			}
		}
	}
}

?>