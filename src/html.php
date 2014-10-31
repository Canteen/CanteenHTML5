<?php 

/**
* @module global
*/
namespace
{
	/**
	*  The global method which is an alias for Canteen\HTML5\html()
	*  to use this method globally call Canteen\HTML5\HTML5::useGlobal()
	*  @class html
	*  @constructor
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
		return Canteen\HTML5\html($tag, $childrenOrAttributes, $attributes);
	}
}