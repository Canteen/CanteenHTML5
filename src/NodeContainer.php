<?php

/**
* @module Canteen\HTML5 
*/
namespace Canteen\HTML5
{	
	/**
	*  Represents an HTML that that can contain other tags (e.g., br, p, div).
	*  Do not initiate this class directly, use the `html()` function:
	*  
	*	$div = html('div');
	*  
	*  @class NodeContainer
	*  @extends Node
	*  @constructor
	*  @param {String} [tag=null] The name of the tag element
	*  @param {Node|Array} [children=null] The collection of children or single child
	*  @param {String|Dictionary} [attributes=null] The tag attributes
	*/
	class NodeContainer extends Node 
	{
		/** 
		*  The collection of children nodes
		*  @property {Array} _children
		*  @private
		*/
		private $_children;

		public function __construct($tag = null, $children = null, $attributes = null)
		{
			if ($this->isEmpty($tag))
			{
				throw new HTML5Error(HTML5Error::EMPTY_NODE_TAG);
			}
			parent::__construct($tag, $attributes);
			
			$this->_children = array();
			
			if (!$this->isEmpty($children))
			{
				if (!is_array($children))
				{
					$children = array($children);
				}
				if (is_array($children))
				{
					foreach($children as $child)
					{
						$this->addChild($child);
					}
				}
			}
		}

		/**
		 *  Add's a child to this NodeContainer. The child to add cannot be null.
		 *  @method addChild
		 *  @param {Node|String|Number|Boolean} childNode The child Node to add
		 *  @return {NodeContainer} The instance of this container
		 */	
		public function addChild($childNode)
		{
			array_push($this->_children, $this->prepareChild($childNode));
			return $this;
		}
		
		/**
		*  Add a child at a specific index
		*  @method addChildAt
		*  @param {Node|String|Number|Boolean} childNode The child Node to add
		*  @param {int} index The index to add child at, 0 is top
		*  @return {NodeContainer} The instance of this container
		*/
		public function addChildAt($childNode, $index)
		{
			if ($index < 0)
			{
				throw new HTML5Error(HTML5Error::OUT_OF_BOUNDS, $index);
			}
			$childNode = $this->prepareChild($childNode);
			if ($index == 0)
			{
				array_unshift($this->_children, $childNode);
			}
			else if ($index > (count($this->_children) - 1))
			{
				$this->addChild($childNode);
			}
			else
			{
				array_splice($this->_children, $index , 0, array($childNode)); 
			}
			return $this;
		}
		
		/**
		*  Before adding a child, we should do some checking for basic types
		*  and convert it into a more useable Node object.
		*  @method prepareChild
		*  @protected
		*  @param {Node|String|Number|Boolean} childNode The child node to add
		*  @return {Node} The child node
		*/
		protected function prepareChild($childNode)
		{
			if ($this->isEmpty($childNode))
			{
				throw new HTML5Error(HTML5Error::EMPTY_CHILD);
			}
			if (is_bool($childNode))
			{
				$childNode = new Text($childNode ? 'true' : 'false');
			}
			else if (is_string($childNode) || is_numeric($childNode))
			{
				$childNode = new Text($childNode);
			}
			if (!($childNode instanceof Node))
			{
				throw new HTML5Error(HTML5Error::INVALID_NODE);
			}
			$childNode->setParent($this);
			return $childNode;
		}

		/**
		*  Removes the first instance of child from this.  
		*  Once the first instance of the child
		*  is removed, this function will return.  It returns
		*  true if a child was removed and false if no child
		*  was removed.
		*  @method removeChild
		*  @param {Node} [childNode=null] The node to remove
		*  @return {Boolean} If successfully removed
		*/
		public function removeChild(Node $childNode = null)
		{
			if ($this->isEmpty($childNode))
			{
				throw new HTML5Error(HTML5Error::EMPTY_CHILD);
			}

			for($i = 0; $i < count($this->_children); $i++)
			{
				$child = $this->_children[$i];
				if ($child === $childNode)
				{
					unset($this->_children[$i]);
					return true;
				}
			}
			return false;
		}
		
		/**
		*  Remove a child as a specific index
		*  @method removeChildAt
		*  @param {int} index The index to remove child at 
		*  @return {NodeContainer} The instance of the node container
		*/
		public function removeChildAt($index)
		{
			if ($index >= $this->_children || $index < 0)
			{
				throw new HTML5Error(HTML5Error::OUT_OF_BOUNDS, $index);
			}
			array_splice($this->_children, $index, 1);
			return $this;
		}

		/**
		*  Removes all children attached to this Node container
		*  @method removeChildren 
		*  @return {NodeContainer} The instance of the node container
		*/
		public function removeChildren()
		{
			unset($this->_children);
			$this->_children = array();
			return $this;
		}

		/**
		* Returns an array of all children attached to this Node container.
		*  @method getChildren
		*  @return {Array} The collection of Node objects
		*/
		public function getChildren() 
		{
			return $this->_children;
		}

		/**
		 * Gets a child of this Node container at given
		 * index.  If no index is passed in, getChild()
		 * will return the child at index zero (0).
		 *  @method getChildAt
		 *  @param {int} [index=0] The index to fetch child Node at
		 *  @return {Node} The child Node
		 */
		public function getChildAt($index = 0)
		{
			return $this->_children[$index];
		}
		
		/**
		*  Close the writing of this container as HTML
		*  @method writeClose
		*  @protected
		*  @return {String} The closing HTML tag element
		*/
		protected function writeClose() 
		{
			return "</" . $this->_tag . ">";
		}

		/**
		*  Write to HTML
		*  @method __toString
		*  @return {String} The string representation of this HTML node
		*/
		public function __toString() 
		{
			$buffer = $this->writeOpen(false);		
			foreach($this->_children as $child)
			{
				$buffer .= $child->__toString();		
			}		
			$buffer .= $this->writeClose();

			return $buffer;
		}
	}
}

?>