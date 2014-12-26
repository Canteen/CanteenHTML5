<?php

/**
* @module Canteen\HTML5 
*/
namespace Canteen\HTML5
{	
	/**
	*  The HTML5 Specification
	*  
	*  @class Specification
	*  @constructor
	*/
	class Specification
	{
		/**
		*  The list of all tags and their specific attributes
		*  @property {array} TAGS
		*  @final
		*  @readOnly
		*  @static
		*/
		public static $TAGS = array(
			'a' => array(
				'href', 
				'hreflang', 
				'media', 
				'rel', 
				'target', 
				'type'
			),
			'abbr' => array(),
			'address' => array(),
			'area' => array(
				'alt', 
				'coords', 
				'href', 
				'hreflang', 
				'media', 
				'rel', 
				'shape', 
				'target', 
				'type'
			),
			'article' => array(),
			'aside' => array(),
			'audio' => array(
				'autoplay', 
				'controls', 
				'loop', 
				'muted', 
				'preload', 
				'src'
			),
			'b' => array(),
			'base' => array(
				'href', 
				'target'
			),
			'bdo' => array(),
			'blockquote' => array('cite'),
			'body' => array(),
			'br' => array(),
			'button' => array(
				'autofocus', 
				'disabled', 
				'form', 
				'formaction', 
				'formenctype', 
				'formmethod', 
				'formnovalidate', 
				'formtarget', 
				'name', 
				'type', 
				'value'
			),
			'canvas' => array(
				'height', 
				'width'
			),
			'caption' => array(),
			'cite' => array(),
			'code' => array(),
			'col' =>	null,
			'colgroup' => array('span'),
			'command' => array(
				'checked', 
				'disabled', 
				'icon', 
				'label', 
				'radiogroup', 
				'type'
			),
			'datalist' => array(),
			'dd' => array(),
			'del' => array(
				'cite', 
				'datetime'
			),
			'dfn' => array(),
			'div' => array(),
			'dl' => array(),
			'dt' => array(),
			'em' => array(),
			'embed' => array(
				'height', 
				'src', 
				'type', 
				'width'
			),
			'fieldset' => array(
				'disabled', 
				'form_id', 
				'text'
			),
			'figcaption' => array(),
			'figure' => array(),
			'footer' => array(),
			'form' => array(
				'accept', 
				'accept-charset', 
				'action', 
				'autocomplete', 
				'enctype', 
				'method', 
				'name', 
				'novalidate', 
				'target'
			),
			'h1' => array(),
			'h2' => array(),
			'h3' => array(),
			'h4' => array(),
			'h5' => array(),
			'h6' => array(),
			'head' => array(),
			'header' => array(),
			'hgroup' => array(),
			'hr' => array(),
			'html' => array('manifest'),
			'img' => array(
				'alt', 
				'crossorigin', 
				'height', 
				'src', 
				'usemap', 
				'width'
			),
			'i' => array(),
			'iframe' => array(
				'src',
				'srcdoc',
				'name',
				'width',
				'height'
			),
			'input' => array(
				'accept', 
				'alt', 
				'autocomplete', 
				'autofocus', 
				'checked', 
				'disabled', 
				'form', 
				'formaction', 
				'formenctype', 
				'formmethod', 
				'formnovalidate', 
				'formtarget', 
				'height', 
				'list', 
				'max', 
				'maxlength', 
				'min', 
				'multiple', 
				'name', 
				'pattern', 
				'placeholder', 
				'readonly', 
				'required', 
				'size', 
				'src', 
				'step', 
				'type', 
				'value', 
				'width'
			),
			'keygen' => array(
				'autofocus', 
				'challenge', 
				'disabled', 
				'form', 
				'keytype', 
				'name'
			),
			'label' => array(
				'for', 
				'form'
			),
			'legend' => array(),
			'li' => array(),
			'link' => array(
				'href', 
				'hreflang', 
				'media', 
				'rel', 
				'sizes', 
				'type'
			),
			'map' => array('name'),
			'mark' => array(),
			'menu' => array(),
			'meta' => array(
				'charset', 
				'content', 
				'http-equiv', 
				'name'
			),
			'meter' => array(
				'form', 
				'heigh', 
				'low', 
				'max', 
				'min', 
				'optimum', 
				'value'
			),
			'nav' => array(),
			'noscript' => array(),
			'object' => array(
				'data', 
				'form', 
				'height', 
				'name', 
				'type', 
				'usemap', 
				'width'
			),
			'ol' => array(
				'reversed', 
				'start', 
				'type'
			),
			'optgroup' => array(
				'disabled', 
				'label'
			),
			'option' => array(
				'disabled', 
				'label', 
				'selected', 
				'value'
			),
			'output' => array(
				'for', 
				'form', 
				'name'
			),
			'p' => array(),
			'param' => array(
				'name', 
				'value'
			),
			'pre' => array(),
			'progress' => array(
				'max', 
				'value'
			),
			'q' => array('cite'),
			'rp' => array(),
			'rt' => array(),
			'ruby' => array(),
			's' => array(),
			'sample' => array(),
			'script' => array(
				'async', 
				'charset', 
				'defer', 
				'src', 
				'type'
			),
			'section' => array(),
			'select' => array(
				'autofocus',
				'disabled',
				'form',
				'multiple', 
				'name',
				'required',
				'size'
			),
			'small' => array(), 
			'source' => array('media',
				'src',
				'type'
			),
			'span' => array(), 
			'strong' => array(),
			'style' => array('media',
				'scoped',
				'type'
			),
			'sub' => array(), 
			'table' => array('border'),
			'tbody' => array(),
			'td' => array(
				'colspan',
				'headers',
				'scope'
			),
			'textarea' => array(
				'autofocus',
				'cols',
				'disabled',
				'form', 
				'maxlength',
				'name',
				'placeholder',
				'readonly',
				'required',
				'row',
				'wrap'
			),
			'tfoot' => array(),
			'th' => array(
				'colspan',
				'headers',
				'rowspan',
				'scope'
			),
			'thead' => array(),
			'time' => array('datetime'),
			'title' => array(),
			'tr' => array(),
			'track' => array(
				'default',
				'kind',
				'label', 
				'src',
				'srclang'
			),
			'u' => array(),
			'ul' => array(),
			'var' => array(),
			'video' => array(
				'autoplay',
				'controls',
				'height',
				'loop', 
				'muted',
				'poster',
				'preload',
				'src',
				'width'
			),
			'wbr' => null
		);

		/**
		*  The list of self-closing tags
		*  @property {array} SELF_CLOSING
		*  @final
		*  @readOnly
		*  @static
		*/
		public static $SELF_CLOSING = array(
			'area', 
			'base', 
			'br', 
			'col', 
			'command', 
			'embed', 
			'hr', 
			'img', 
			'input', 
			'keygen',
			'link', 
			'meta', 
			'param', 
			'source', 
			'track', 
			'wbr'
		);

		/**
		*  Global valid attributes for all HTML5 tags
		*  See: http://www.w3.org/TR/html5/dom.html#global-attributes
		*  @property {Array} ATTRIBUTES
		*  @final
		*  @static
		*  @readOnly
		*/  
		public static $ATTRIBUTES = array(

			// Event handler context attributes
			'onabort', 'onblur', 'oncancel', 'oncanplay', 'oncanplaythrough', 
			'onchange', 'onclick', 'oncuechange', 'ondblclick', 'ondurationchange',
			'onemptied', 'onended', 'onerror', 'onfocus', 'oninput', 'oninvalid', 
			'onkeydown', 'onkeypress', 'onkeyup', 'onload', 'onloadeddata', 
			'onloadedmetadata', 'onloadstart', 'onmousedown', 'onmouseenter', 
			'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 
			'onmousewheel', 'onpause', 'onplay', 'onplaying', 'onprogress', 
			'onratechange', 'onreset', 'onresize', 'onscroll', 'onseeked', 
			'onseeking', 'onselect', 'onshow', 'onstalled', 'onsubmit', 'onsuspend', 
			'ontimeupdate', 'ontoggle', 'onvolumechange', 'onwaiting',

			// Allow-able on all tags
			'accesskey', 'class', 'contenteditable', 'contextmenu', 'dir', 'draggable',
			'dropzone', 'hidden', 'id', 'lang', 'spellcheck', 'style', 'tabindex',
			'title', 'translate'
		);
	}
}