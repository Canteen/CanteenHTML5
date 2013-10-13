<?php	

	/**
	*  @module global
	*/
	
	/**
	*  Auto load the assets in this library
	*/
	spl_autoload_register(function($name)
	{
		// Ignore class names not in the HTML5 namespace
		if (!preg_match('/^HTML5\\\/', $name)) return;
		
		// Remove the HTML5 namespace
		$name = preg_replace('/^HTML5\\\/', '', $name);
		
		// Convert the rest to directories
		$name = str_replace("\\", '/', $name);
		
		// Include the class relative to here
		include __DIR__.'/'.$name.'.php';
	});
	
	use Canteen\HTML5\NodeContainer;
	use Canteen\HTML5\Node;
	use Canteen\HTML5\Comment;
	use Canteen\HTML5\HTML5Error;
	use Canteen\HTML5\Text;
	use Canteen\HTML5\Attribute;
	
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
		
		$s = false; // if the html is a single tag like <br>
		$tag = strtolower($tagParts[1]); // the name of the tag
		$a = ''; // Valid extra attributes for tags
		switch($tag)
		{
			case 'a':			$a = 'href,hreflang,media,rel,target,type'; break;
			case 'abbr':		break;
			case 'address':		break;
			case 'area':		$s = true; $a = 'alt,coords,href,hreflang,media,rel,shape,target,type'; break;
			case 'article':		break;
			case 'aside':		break;
			case 'audio':		$a = 'autoplay,controls,loop,muted,preload,src'; break;
			case 'b':			break;
			case 'base':		$s = true; $a = 'href,target'; break;
			case 'bdo':			break;
			case 'blockquote':	$a = 'cite'; break;
			case 'body':		break;
			case 'br':			$s = true; break;
			case 'button':		$a = 'autofocus,disabled,form,formaction,formenctype,formmethod,formnovalidate,formtarget,name,type,value'; break;
			case 'canvas':		$a = 'height,width'; break;
			case 'caption':		break;
			case 'cite':		break;
			case 'code':		break;
			case 'col':			$s = true; break;
			case 'colgroup':	$a = 'span'; break;
			case 'command':		$s = true; $a = 'checked,disabled,icon,label,radiogroup,type'; break;
			case 'comment':		return new Comment($childrenOrAttributes);
			case 'doctype':		return '<!DOCTYPE html>';
			case 'datalist':	break;
			case 'dd':			break;
			case 'del':			$a = 'cite,datetime'; break;
			case 'dfn':			break;
			case 'div':			break;
			case 'dl':			break;
			case 'dt':			break;
			case 'em':			break;
			case 'embed':		$s = true; $a = 'height,src,type,width'; break;
			case 'fieldset':	$a = 'disabled,form_id,text'; break;
			case 'figcaption':	break;
			case 'figure':		break;
			case 'footer':		break;
			case 'form':		$a = 'accept,accept-charset,action,autocomplete,enctype,method,name,novalidate,target'; break;
			case 'h1':			break;
			case 'h2':			break;
			case 'h3':			break;
			case 'h4':			break;
			case 'h5':			break;
			case 'h6':			break;
			case 'head':		break;
			case 'header':		break;
			case 'hgroup':		break;
			case 'hr':			$s = true; break;
			case 'html':		$a = 'manifest'; break;
			case 'img':			$s = true; $a = 'alt,crossorigin,height,src,usemap,width'; break;
			case 'i':			break;
			case 'input':		$s = true; $a = 'accept,alt,autocomplete,autofocus,checked,disabled,form,formaction,formenctype,formmethod,formnovalidate,formtarget,height,list,max,maxlength,min,multiple,name,pattern,placeholder,readonly,required,size,src,step,type,value,width'; break;
			case 'keygen': 		$s = true; $a = 'autofocus,challenge,disabled,form,keytype,name'; break;
			case 'label':		$a = 'for,form'; break;
			case 'legend':		break;
			case 'li':			break;
			case 'link':		$s = true; $a = 'href,hreflang,media,rel,sizes,type'; break;
			case 'map':			$a = 'name'; break;
			case 'mark':		break;
			case 'menu':		break;
			case 'meta':		$s = true; $a = 'charset,content,http-equiv,name'; break;
			case 'meter':		$a = 'form,heigh,low,max,min,optimum,value'; break;
			case 'nav':			break;
			case 'noscript':	break;
			case 'object':		$a = 'data,form,height,name,type,usemap,width'; break;
			case 'ol':			$a = 'reversed,start,type'; break;
			case 'optgroup':	$a = 'disabled,label'; break;
			case 'option':		$a = 'disabled,label,selected,value'; break;
			case 'output':		$a = 'for,form,name'; break;
			case 'p':			break;
			case 'param':		$s = true; $a = 'name,value'; break;
			case 'pre':			break;
			case 'progress':	$a = 'max,value'; break;
			case 'q':			$a = 'cite'; break;
			case 'rp':			break;
			case 'rt':			break;
			case 'ruby':		break;
			case 's':			break;
			case 'sample':		break;
			case 'script':		$a = 'async,charset,defer,src,type'; break;
			case 'section':		break;
			case 'select':		$a = 'autofocus,disabled,form,multiple,name,required,size'; break;
			case 'small':		break; 
			case 'source':		$s = true; $a = 'media,src,type'; break;
			case 'span':		break; 
			case 'strong':		break;
			case 'style':		$a = 'media,scoped,type'; break;
			case 'sub':			break; 
			case 'table':		$a = 'border'; break;
			case 'tbody':		break;
			case 'td':			$a = 'colspan,headers,scope'; break;
			case 'text':		return new Text($childrenOrAttributes);
			case 'textarea':	$a = 'autofocus,cols,disabled,form,maxlength,name,placeholder,readonly,required,row,wrap'; break;
			case 'tfoot':		break;
			case 'th':			$a = 'colspan,headers,rowspan,scope'; break;
			case 'thead':		break;
			case 'time':		$a = 'datetime'; break;
			case 'title':		break;
			case 'tr':			break;
			case 'track':		$s = true; $a = 'default,kind,label,src,srclang'; break;
			case 'u':			break;
			case 'ul':			break;
			case 'var':			break;
			case 'video':		$a = 'autoplay,controls,height,loop,muted,poster,preload,src,width'; break;
			case 'wbr': 		$s = true; break;
			default:
				throw new HTML5Error(HTML5Error::INVALID_TAG, $tag);
				break;
		}
		
		// Create the attributes collection, either string or array
		$attributes = $s ? $childrenOrAttributes : $attributes;
		
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
		$node = ($s) ?
			new Node($tag, $attributes, $a) :
			new NodeContainer($tag, $childrenOrAttributes, $attributes, $a);
		
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

?>