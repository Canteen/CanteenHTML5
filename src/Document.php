<?php

/**
* @module Canteen\HTML5 
*/
namespace Canteen\HTML5
{	
	/**
	*  Create an HTML document. Basic barebones structure. 
	*  Located in the namespace __Canteen\HTML5__.
	*  
	*	$doc = new HTML5\Document('Untitled');
	*	$doc->head->addChild(html('script src=main.js'));
	*	$doc->body->addChild(html('div#frame'));
	*	echo $doc;
	*  
	*  @class Document
	*  @extends NodeContainer
	*  @constructor
	*  @param {String} [title=''] The title of the document
	*  @param {String} [charset='utf-8'] The character encoding set of this HTML document
	*  @param {Boolean} [beautify=false] If we should add whitespace to the output to make it look nice markup.
	*/
	class Document extends NodeContainer
	{
		/** 
		*  The document type
		*  @property {NodeContainer} docType
		*/
		private $docType;

		/** 
		*  The head node
		*  @property {NodeContainer} head
		*/
		public $head;
		
		/** 
		*  The body node
		*  @property {NodeContainer} body
		*/
		public $body;
		
		/** 
		*  The title node
		*  @property {NodeContainer} title
		*/
		public $title;
		
		/**
		*  Beautify the output
		*  @property {Boolean} beautify
		*/
		public $beautify = false;
		
		/**
		*  Constructor for Docs 
		*/
		public function __construct($title='', $charset='utf-8', $beautify=false)
		{
			parent::__construct('html', null, null, 
				array_merge(
					array('manifest'), 
					Specification::$ATTRIBUTES
				)
			);
			
			$this->docType = html('doctype');
			$this->head = html('head');
			$this->body = html('body');
			$this->title = html('title', $title);
			
			$this->head->addChild(html('meta', 'charset='.$charset));
			$this->head->addChild($this->title);
			
			$this->addChild($this->head);
			$this->addChild($this->body);
		}
		
		/**
		*  Write to HTML
		*  @method __toString
		*  @return {String} The string representation of this HTML node
		*/
		public function __toString()
		{
			$result = $this->docType . parent::__toString();
			if ($this->beautify) 
				$result = self::beautify($result);
			return $result;	
		}
		
		/** 
		*  Beautifies an HTML string into a human-readable and indented work of art.
		*  @method beautify
		*  @static
		*  @param {String} html The XML-compatible HTML as a string 
		*  @return {String} The formatted string
		*/
		public static function beautify($html)
		{
			// Conver the HTML -> SimpleXML -> DOMDocument
			$dom = dom_import_simplexml(new \SimpleXMLElement($html))->ownerDocument;
			
			// Format the DOMDocument 
			$dom->formatOutput = true;
			
			// Save the output as XML
			$buffer = $dom->saveXML();
			
			// Remove the first line which has the XML declaration
			return substr($buffer, strpos($buffer, "\n")+1); 
		}
	}
}

?>