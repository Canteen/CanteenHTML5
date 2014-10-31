<?php
	
/**
* @module Canteen\HTML5 
*/
namespace Canteen\HTML5
{
	/**
	*  A generic html tag with any children or closing tag. (e.g., img, br, hr).
	*  Do not initiate this class directly, use the `html()` function:
	*  
	*	echo html('br');
	*  
	*  @class Node
	*  @constructor
	*  @param {String} [tag=null] The name of the tag
	*  @param {Array|String} [attributes=null] The collection of tag attributes
	*/
	class Node
	{
		/** 
		*  The string name of the tag
		*  @property {String} _tag
		*  @protected
		*/
		protected $_tag;
		
		/** 
		*  The collection of Attributes objects
		*  @property {Array} _attributes
		*  @protected
		*/
		protected $_attributes;
		
		/** 
		*  The parent node, if any
		*  @property {NodeContainer} _parent
		*  @protected
		*/
		protected $_parent;
		
		/** 
		*  The collection of valid attributes names for given tag
		*  @property {Array} _validAttrs
		*  @protected
		*/
		protected $_validAttrs;
		
		public function __construct($tag = null, $attributes = null) 
		{
			if ($this->isEmpty($tag))
			{
				throw new HTML5Error(HTML5Error::EMPTY_NODE_TAG);
			}
			$this->_parent = null;
			$this->_tag = $tag;
			$this->_attributes = array();

			if (isset(Specification::$TAGS[$tag]))
			{
				$this->_validAttrs = array_merge(
					Specification::$TAGS[$tag],
					Specification::$ATTRIBUTES
				);
			}
			else
			{
				$this->_validAttrs = array();
			}
			
			if ($attributes !== null)
			{
				if (is_string($attributes))
				{
					$attributes = Attribute::shorthand($attributes);
				}
				
				if (is_array($attributes))
				{
					$this->setAttributes($attributes);
				}
			}
		}
		
		/**
		*  Returns the parent node of this node, if
		*  a parent exists.  If no parent exists,
		*  this function returns null.
		*  @method getParent
		*  @private
		*  @return {NodeContainer} The parent node object
		*/
		private function getParent()
		{
			return $this->_parent;
		}
		
		/**
		 * Sets the parent of this Node.  Note that this
		 * function is protected and can only be called by
		 * classes that extend Node.  The parent cannot
		 * be null; this function will throw an Exception
		 * if the parent node is empty.
		 *  @method setParent
		 *  @protected
		 *  @param {NodeContainer} [parent=null] The parent container node
		 */
		protected function setParent(NodeContainer $parent = null) 
		{
			if ($this->isEmpty($parent))
			{
				throw new HTML5Error(HTML5Error::EMPTY_PARENT);
			}
			$this->_parent = $parent;
		}
		
		/**
		 * Given a name and value pair, sets an attribute on this Node.
		 * The name and value cannot be empty; if so, this function
		 * will throw an Exception.  Note if the attribute already exists
		 * and the caller wants to set an attribute of the same name,
		 * this function will not create a new Attribute, but rather
		 * update the value of the existing named attribute.
		 *  
		 *  @method setAttribute
		 *  @param {String} [name=null] The name of the attribute to add
		 *  @param {String} [value=null] The value of the attribute
		 *  @param {Node} The instance of this node
		 */
		public function setAttribute($name = null, $value = null)
		{			
			if ($this->isEmpty($name))
			{
				throw new HTML5Error(HTML5Error::EMPTY_ATTRIBUTE_NAME);
			}
			foreach($this->_attributes as $i=>$attribute) 
			{
				if ($attribute->name === $name)
				{
					if (!$this->isEmpty($value))
						$attribute->value = $value;
					else
						unset($this->_attributes[$i]);
					return $this;
				}
			}
			$this->_attributes[] = new Attribute($name, $value);
			return $this;
		}
		
		/**
		*  Fetch and attribute by name from this Node.  The attribute
		*  name cannot be null; if so, this function will throw an
		*  Exception.
		*  @method getAttribute
		*  @param {String} [name=null] The name of the attribute to fetch
		*  @return {String} The attribute's value, if any or null
		*/
		protected function getAttribute($name = null) 
		{
			$returnAttr = null;

			if ($this->isEmpty($name))
			{
				throw new HTML5Error(HTML5Error::EMPTY_ATTRIBUTE_NAME);
			}
			foreach($this->_attributes as $attribute) 
			{
				if ($attribute->name === $name)
				{
					$returnAttr = $attribute->value;
					break;
				}
			}
			return $returnAttr;
		}
		
		/**
		*  Set the list of all attributes.
		*  @method setAttributes
		*  @param {Dictionary} values An attributes array(name=>value, name=>value)
		*  @return {Node} The instance of this Node
		*/
		public function setAttributes($values)
		{
			if (is_array($values))
			{
				foreach($values as $name=>$value)
				{
					$this->setAttribute($name, $value);
				}
				return $this;
			}
		}
		
		/**
		*  Set the a data-* HTML5 Attribute
		*  @param {String} name The name of the data, for instance "id" is an attribute "data-id"
		*  @param {String} value The value of the attribute
		*  @return {Node} The instance of this Node
		*/
		public function setData($name, $value)
		{
			return $this->setAttribute('data-'.$name, $value);	
		}
		
		/**
		*  Add this child to a node container at the end
		*  @method appendTo
		*  @param {NodeContainer} container The node container to add to
		*  @return {Node} The instance of this Node
		*/
		public function appendTo(NodeContainer $container)
		{
			$container->addChild($this);
			return $this;
		}
		
		/**
		*  Add this child to the beginning of a node container
		*  @method prependTo
		*  @param {NodeContainer} container The node container to prepend to to
		*  @return {Node} The instance of this Node
		*/
		public function prependTo(NodeContainer $container)
		{
			$container->addChildAt($this, 0);
			return $this;
		}
		
		/**
		*  Get the data-* HTML5 attribute value, if set
		*  @method getData
		*  @param {String} name The name of the data attribute
		*  @return {String} The value of the data
		*/
		public function getData($name)
		{
			return $this->getAttribute('data-'.$name);	
		}
		
		/**
		*  Write to HTML
		*  @method __toString
		*  @return {String} The string representation of this HTML node
		*/
		public function __toString() 
		{
			return $this->writeOpen();
		}
		
		/**
		*  Start the writing the tag
		*  @method writeOpen
		*  @protected
		*  @param {Boolean} [selfClose=true] If the tag is a self closing tag (e.g., br, img, hr)
		*  @return {String} The buffer of HTML
		*/
		protected function writeOpen($selfClose=true) 
		{
			$buffer = '<';
			$buffer .= $this->_tag;
			foreach($this->_attributes as $attribute) 
			{
				$buffer .= (string)$attribute; 
			}
			$buffer .= ($selfClose ? ' />' : '>');
			return $buffer;
		}
		
		/**
		*  General purpose getter to get attribute values
		*  @method __get
		*  @param {String} name The name of the property to set
		*/
		public function __get($name) 
		{
			if (in_array($name, $this->_validAttrs) || strpos($name, 'data-') === 0)
			{
				return $this->getAttribute($name);
			}
			return parent::__get($name);
		}

		/**
		*  General purpose setter to set attribute values
		*  @method __set
		*  @param {String} name The name of the attribute
		*  @param {String} value The value of the attribute
		*/
		public function __set($name, $value) 
		{
			if (in_array($name, $this->_validAttrs) || strpos($name, 'data-') === 0)
			{
				return $this->setAttribute($name, $value);
			}
		}

		/**
		*  See if a property exists
		*  @method __isset
		*  @param {String} name The name of the attribute
		*/
		public function __isset($name)
		{
			return in_array($name, $this->_validAttrs) || parent::__isset($name);
		}
		
		/**
		*  Checks if a variable is really "empty".  Code borrowed from PHP.net at
		*  http://us3.php.net/manual/en/function.empty.php#90767 because we were
		*  previously using empty() to see if a variable is empty or not.  But
		*  empty() dosen't work for attributes that have a value of "0", so we need
		*  something more robust here.
		*  <ul>
		*  <li>an unset variable -> empty</li>
		*  <li>null -> empty</li>
		*  <li>0 -> NOT empty</li>
		*  <li>"0" -> NOT empty</li>
		*  <li>false -> empty</li>
		*  <li>true -> NOT empty</li>
		*  <li>'string value' -> NOT empty</li>
		*  <li>"	"(white space) -> empty</li>
		*  <li>array()(empty array) -> empty</li>
		*  </ul>
		*  @method isEmpty
		*  @protected
		*  @param {mixed} var The variable to check for empty on
		*/
		protected function isEmpty($var) 
		{
			return (!isset($var) || is_null($var) ||
				(!is_object($var) && is_string($var) && trim($var) == '' && !is_bool($var)) ||
				(is_bool($var) && $var === false) ||
				(is_array($var) && empty($var)));
	 	}
	}
}

?>