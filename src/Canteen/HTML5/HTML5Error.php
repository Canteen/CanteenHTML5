<?php

/**
*  @module Canteen\HTML5 
*/
namespace Canteen\HTML5
{	
	/**
	*  Exceptions with using the HTML5 API.
	*  
	*	try
	*	{
	*		html('invalid', 'something');
	*	}
	*	catch(Canteen\HTML5\HTML5Error $e)
	*	{
	*		$e->getMessage();
	*	}
	*  
	*  @class HTML5Error
	*  @extends Exception
	*  @constructor
	*  @param {int} code The code of the error
	*  @param {String} [data=''] Additional data to associate with this error
	*/
	class HTML5Error extends \Exception
	{
		/** 
		*  The database connection failed
		*  @property {int} EMPTY_ATTRIBUTE_NAME
		*  @static
		*  @final
		*/
	 	const EMPTY_ATTRIBUTE_NAME = 500;
	
		/** 
		*  The alias for a database is invalid
		*  @property {int} EMPTY_ATTRIBUTE_VALUE
		*  @static
		*  @final
		*/
		const EMPTY_ATTRIBUTE_VALUE = 501;
		
		/** 
		*  The database name we're trying to switch to is invalid
		*  @property {int} INVALID_SETTER
		*  @static
		*  @final
		*/
		const INVALID_SETTER = 502;
		
		/** 
		*  The mysql where trying to execute was a problem
		*  @property {int} INVALID_GETTER
		*  @static
		*  @final
		*/
		const INVALID_GETTER = 503;
		
		/** 
		*  The html tag name is invalid
		*  @property {int} INVALID_TAG
		*  @static
		*  @final
		*/
		const INVALID_TAG = 504;
		
		/** 
		*  When trying to create a node, the name is empty
		*  @property {int} EMPTY_NODE_TAG
		*  @static
		*  @final
		*/
		const EMPTY_NODE_TAG = 505;
		
		/** 
		*  The parent cannot be empty
		*  @property {int} EMPTY_PARENT
		*  @static
		*  @final
		*/
		const EMPTY_PARENT = 506;
		
		/** 
		*  THe addChildAt is out of bounds
		*  @property {int} OUT_OF_BOUNDS
		*  @static
		*  @final
		*/
		const OUT_OF_BOUNDS = 507;
		
		/** 
		*  The child node is empty
		*  @property {int} EMPTY_CHILD
		*  @static
		*  @final
		*/
		const EMPTY_CHILD = 508;
		
		/** 
		*  The node is not of instance type Node
		*  @property {int} INVALID_NODE
		*  @static
		*  @final
		*/
		const INVALID_NODE = 509;
		
		/**
		*  Look-up for error messages
		*  @property {Dictionary} messages
		*  @private
		*  @static
		*/
		private static $messages = array(
			self::EMPTY_ATTRIBUTE_NAME => 'Attribute names cannot be empty',
			self::EMPTY_ATTRIBUTE_VALUE => 'Attribute values cannot be empty',
			self::INVALID_SETTER => 'Cannot set the property because name is invalid',
			self::INVALID_GETTER => 'Cannot get the property because name is invalid',
			self::INVALID_TAG => 'Not a valid HTML5 tag name',
			self::EMPTY_NODE_TAG => 'Node tag is empty',
			self::EMPTY_PARENT => 'The parent cannot be empty',
			self::OUT_OF_BOUNDS => 'The index is out of bounds',
			self::EMPTY_CHILD => 'Cannot addChild an empty child node',
			self::INVALID_NODE => 'Child node must be a valid tag'
		);
		
		/** 
		*  The label for an error that is unknown or unfound in messages
		*  @property {String} UNKNOWN
		*  @static
		*  @final
		*/
		const UNKNOWN = 'Unknown error';
		
		public function __construct($code, $data='')
		{
			$message = (isset(self::$messages[$code]) ? self::$messages[$code]: self::UNKNOWN)
				. ($data ? ' : ' . $data : $data);	
			parent::__construct($message, $code);
		}
	}
}

?>