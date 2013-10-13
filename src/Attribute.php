<?php

/**
* @module Canteen\HTML5 
*/
namespace Canteen\HTML5
{
	/**
	*  An HTML attribute used on the Node, this is used internally.
	*  Do not initiate this class directly, use the `html()` function
	*  to create attributes on elements.
	*  
	*	echo html('a', 'Link', 'class=button href="about.html"');
	*	
	*  	echo html('a', 'Link')
	*  		->setAttribute('class', 'button')
	*  		->setAttribute('href', 'about.html');
	*  
	*  @class Attribute
	*  @constructor
	*  @param {String} [name=null] The name of the attribute
	*  @param {String} [value=null] The value of the attribute
	*/
	class Attribute
	{
		/** 
		*  The name of the attribute
		*  @property {String} _name
		*  @private
		*/
		private $_name;
		
		/** 
		*  The value of the attribute
		*  @property {String} _value
		*  @private
		*/
		private $_value;

		public function __construct($name = null, $value = null) 
		{
			$this->name = $name;
			$this->value = $value;
		}

		/**
		*  Convert the attribute to an HTML tag attribute string
		*  @method __toString
		*  @return {String} String representation of attribute
		*/
		public function __toString() 
		{
			return " " . $this->_name . "=\"" . $this->_value . "\"";
		}

		/**
		*  Get the name of this attribute
		*  @method getName
		*  @return {String} The attribute's name
		*/
		public function getName() 
		{
			return $this->_name;
		}

		/**
		*  Set the name of this attribute, cannot be empty
		*  @method setName
		*  @param {String} [name=null] The name of the attribute
		*/
		public function setName($name = null)
		{
			if (is_null($name) || empty($name))
			{
				throw new HTML5Error(HTML5Error::EMPTY_ATTRIBUTE_NAME);
			}
			$this->_name = $name;
		}
		
		/**
		*  Get the value of this attribute
		*  @method getValue
		*  @protected
		*  @return {String} The value of attribute
		*/
		protected function getValue() 
		{
			return $this->_value;
		}

		/**
		*  Set the value of this attribute, this cannot be empty
		*  @method setValue
		*  @protected
		*  @param {String} value The value to set
		*/
		protected function setValue($value) 
		{
			$this->_value = $value;
		}
		
		/**
		*  Convert a string into an associative array
		*  @method shorthand
		*  @static
		*  @param {String} str The string, delineated by semicolons, and colons for attributes:values
		*  @return {Dictionary} The collection of attributes
		*/
		static public function shorthand($str)
		{
			$res = array();
			
			// Match the name=value in the attributes string
			preg_match_all('/([a-z]+[a-z\-]*)\=("[^\"]*"|\'[^\']*\'|[^\s\"\']*)/',$str, $arr);
			
			foreach($arr[1] as $i=>$name)
			{
				$value = $arr[2][$i];
				
				// Remove containing quotes if present
				if (preg_match('/^[\'\"][^\n]*[\'\"]$/', $value))
				{
					$value = substr($value, 1, -1);
				}
				$res[$name] = $value;
			}
			return $res;
		}
		
		/**
		*  General purpose getter for getting attribute->name and attribute->value
		*  @public __get
		*  @param {String} name The name of the property to get
		*/
		public function __get($name) 
		{
			if (method_exists($this , $method =('get' . ucfirst($name))))
				return $this->$method();
			else
				throw new HTML5Error(HTML5Error::INVALID_GETTER, $name);
		}

		/**
		*  General purpose setter for setting attribute->name and attribute->value
		*  @public __set
		*  @param {String} name The name of the attribute
		*  @param {String} value The value of the attribute
		*/
		public function __set($name, $value) 
		{
			if (method_exists($this , $method =('set' . ucfirst($name))))
				return $this->$method($value);
			else
				throw new HTML5Error(HTML5Error::INVALID_SETTER, $name);
		}

		/**
		*  See if a property exists
		*  @method __isset
		*  @param {String} name The name of the property
		*/
		public function __isset($name)
		{
			return method_exists($this , 'get' . ucfirst($name)) 
				|| method_exists($this , 'set' . ucfirst($name));
		}
	}
}

?>