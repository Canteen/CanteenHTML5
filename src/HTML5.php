<?php	


/**
* @module Canteen\HTML5 
*/
namespace Canteen\HTML5
{	
	/**
	*   Main class of the library
	*   @class HTML5
	*/
	class HTML5
	{
		/**
		*  Turn on autoloading for the library
		*  @method autoload
		*  @static
		*/
		static public function autoload()
		{
			spl_autoload_register(function($name)
			{
				// Ignore class names not in the HTML5 namespace
				if (!preg_match('/^Canteen\\\HTML5\\\/', $name)) return;
				
				// Remove the HTML5 namespace
				$name = preg_replace('/^Canteen\\\HTML5\\\/', '', $name);
				
				// Convert the rest to directories
				$name = str_replace("\\", '/', $name);
				
				// Include the class relative to here
				include __DIR__.'/'.$name.'.php';
			});
		}

		/**
		*  Use the global `html()` method
		*  @method {Boolean} useGlobal
		*/
		static public function useGlobal()
		{
			include __DIR__.'/html.php';
		}
	}

	/**
	*  This is the global function is the main entry for interacting with the HTML5 for PHP library. 
	*  using `html()` global function you can create HTML5 quickly and easily. For more
	*  examples and instruction on how to use this library, please refer to the the 
	*  <a href="https://github.com/Canteen/CanteenHTML5">GitHub project</a>. 
	*  To install the library simply include `html.php`, this takes care of any autoloading that's needed
	*  for the rest of the library.
	*
	*	echo html('img src=home.jpg'); 
	*	echo html('img', 'src=home.jpg'); 
	*	echo html('a', array('href'=>'about.html'));
	*	
	*	
	*
	*  @method html
	*  @param {String} tag The name of the tag as a string for example 'tr', 'table', can be followed 
	*		 by CSS selector, e.g. 'a#backButton' or 'a.button'
	*  @param {Dictionary|Node|String|Array} [childrenOrAttributes=null] If the tag is a NodeContainer, this can be an array 
	*  		  of attributes, another html node or some text. If the tag is a single node, this can 
	*        be an array or chain of attributes
	*  @param {Dictionary|String} [attributes=null] The attributes list for container tags (e.g., 'class:selected')
	*  @return {Node} Return the html node
	*/
	function html($tag, $childrenOrAttributes=null, $attributes=null)
	{
		// Get the tag ID from the tag string
		// for instance 'a.button rel=external', a.button is the tagId, the rest are the attributes
		$endPos = strpos(trim($tag), ' ');
		
		// The tag attributes
		$tagAttributes = array();
		
		// If the tag also has some attributes
		if ($endPos !== false)
		{
			$tagOriginal = $tag;
			$tag = substr($tag, 0, $endPos);
			$tagAttributes = Attribute::shorthand(substr($tagOriginal, $endPos + 1));
		}
		
		// Match the tag name without the CSS selectors
		preg_match('/^([a-z1-6]{1,10})(.*)/', $tag, $tagParts);
		
		// Valid class ane id names must begin with a -, _, or a-z letter
		preg_match_all('/(\.|\#)\-?[\_a-zA-Z]+[\_a-zA-Z0-9\-]*/', $tagParts[2], $selectors);
		
		$tag = strtolower($tagParts[1]); // the name of the tag
		$selfClosing = false;

		// Comment tags are special
		if ($tag == 'comment')
		{
			return new Comment($childrenOrAttributes);
		}
		// Document type declaration
		else if ($tag == 'doctype')
		{
			return '<!DOCTYPE html>';
		}
		// Any normal text
		else if ($tag == 'text')
		{
			return new Text($childrenOrAttributes);
		}
		// Untagged container
		else if ($tag == 'fragment')
		{
			return new Fragment($childrenOrAttributes);
		}
		// Check for task specification
		else if (isset(Specification::$TAGS[$tag]))
		{
			// Check to see if this is a self closing tag
			$selfClosing = in_array($tag, Specification::$SELF_CLOSING);
		}
		else
		{
			throw new HTML5Error(HTML5Error::INVALID_TAG, $tag);
		}
		
		// Create the attributes collection, either string or array
		$attributes = $selfClosing ? $childrenOrAttributes : $attributes;
		
		// If there are attributes and they are in a string format
		// convert to an attributes array
		if ($attributes !== null && is_string($attributes))
		{
			$attributes = Attribute::shorthand($attributes);
		}
		
		// Combine the attributes and the tags
		if (is_array($attributes))
		{
			$attributes = array_merge($tagAttributes, $attributes);
		}
		// Or just add any tag attributes
		else if (count($tagAttributes))
		{
			$attributes = $tagAttributes;
		}
		
		// Create the node or container
		$node = $selfClosing ?
			new Node($tag, $attributes) :
			new NodeContainer($tag, $childrenOrAttributes, $attributes);
		
		// Take the selectors convert them into id or class
		foreach($selectors[0] as $selector)
		{
			switch($selector[0])
			{
				case '#' : 
					$node->id = substr($selector, 1); 
					break;
				case '.' : 
					if ($node->class) $node->class .= ' ';
					$node->class .= substr($selector, 1); 
					break;
			}
		}
		return $node;
	}
}