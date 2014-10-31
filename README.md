#Canteen HTML5

Create dynamic, well-formatted HTML5 markup with a simple an intuitive PHP API. This is a fork/rewrite of the [Gagawa](https://code.google.com/p/gagawa/) project. CanteenHTML5 is a concise, flexible and easy to remember API which makes it possible to create simple markup (such as a link) or more complex structures (such a table, document or nested list). All tags and attribute names are validated against the current HTML5 specification.

For documentation of the codebase, please see [Canteen HTML5 docs](http://canteen.github.io/CanteenHTML5/).

##Requirements


This library requires a webserver running PHP 5.3+. Also, the root namespace for the library is `Canteen\HTML5`.

##Installation

Install is available using [Composer](http://getcomposer.org).

```bash
composer require canteen/html5 dev-master
```

Including using the Composer autoloader.

```php
require 'vendor/autoload.php';
```

##Usage

###Basic
To create an HTML node, simply call global `html` method, passing in the tag name and then any attributes.

```php
// Enable the global use of html()
Canteen\HTML5\HTML5::useGlobal();

// Turn on autoloading if not using composer's autoloading
Canteen\HTML5\HTML5::autoload();

echo html('img src=home.jpg');
echo html('img', 'src=home.jpg'); 
echo html('img', array('src'=>'home.jpg')); 
```

All of these examples would output:

```html
<img src="home.jpg" />
```

###Adding Attributes

There are  dfferent ways to add attributes for HTML container nodes such as `<p>`, `<div>`, or in the example below, `<nav>`.

1. Part of the tag

    ```php
    echo html('nav title="Navigation" class=main', 'Welcome');
    ```
    
2. As an associative array

	```php
    echo html('nav', 'Welcome', array('title'=>'Navigation', 'class'=>'main'));
    ```

3. As a shorthand string

	```php
    echo html('nav', 'Welcome', 'title="Navigation" class=main');
    ```
    
4. As an property methods

  ```php
  $nav = html('nav', 'Welcome');
  $nav->class = 'main';
  $nav->title = 'Navigation';
  echo $nav;
  ```

All of these examples output the same markup:
```html
<nav title="Navigation" class="main">Welcome</nav>
```

###Adding Nested Elements

Any HTML5 container tags (such as `<p>`, `<span>`, or `<div>`) can have child elements. These elements can be strings or other HTML5 element objects.

```php
$label = html('span', 'Website!');
$link = html('a', $label);
$link->href = 'http://example.com';
echo $link; 
```

Alternatively, use the `addChild` method for any container tag.

```php
$link = html('a');
$link->href = 'http://example.com';
$link->addChild(html('span', 'Website!'));
echo $link;
```

Or `appendTo` to target a container to be added to:

```php
$link = html('a');
$link->href = 'http://example.com';
html('span', 'Website!')->appendTo($link);
echo $link;
```
All examples would output:

```html
<a href="http://example.com"><span>Website!</span></a> 
```

###CSS Selectors

Tag names can optionally have CSS-style class and id selectors:

```php
echo html('a#example'); //<a id="example"></a>
echo html('span.small'); //<span class="small"></span>
echo html('span.small.label'); //<span class="small label"></span>
echo html('span#example.small.label'); //<span id="example" class="small label"></span>
```

##API Documentation

####For self-closing elements (e.g. `<br>`, `<img>`) 

```php
html($tag, $attributes=null);
```
+	`$tag` **{string}** The name of the valid HTML5 element which can contain CSS selectors or short-hand attribute string.
+   `$attributes` **{array | string}** (optional) Collection of element attributes

Returns a `Canteen\HTML5\Node` object.

####Node Methods

+ `setAttribute($name, $value)` Set an attribute by name and value.
+ `setAttributes($values)` Set an associative array of name/value pairs.
+ `setData($name, $value)` Set data-* fields on the HTML5 element.
+ `getData($name)` Get the data-* field on the HTML5 element.
+ `appendTo(NodeContainer $container)` Add the element to the end of a container element. 
+ `prependTo(NodeContainer $container)` Add the element to the beginning of a container element.

####For container HTML elements (e.g. `<p>`, `<div>`)

```php
html($tag, $contents=null, $attributes=null);
```
+	`$tag` **{string}** The name of the valid HTML5 element which can contain CSS selectors or short-hand attribute string.
+   `$contents` **{string | Node | NodeContainer}** (optional) The string of the contents of the tag, or another element created by `html()`
+   `$attributes` **{array | string}** (optional) Collection of element attributes

Returns a `Canteen\HTML5\NodeContainer` object.

####NodeContainer Methods (extends `Node`)

+ `addChild($node)` Add a `Node` object to the bottom of the collection of nodes
+ `addChildAt($node, $index)` Add a `Node` object at a specific zero-based index
+ `removeChild($node)`  Remove a particular node from the container
+ `removeChildAt($index)` Remove a node by zero-based index
+ `removeChildren()` Remove all children from the container
+ `getChildren()`  Get the collection of all `Node` objects
+ `getChildAt($index)` Get a `Node` object at a specific index

###Additional Components

####Document

The `Document` object is used for creating a bare-bones HTML5 document.

```php
Canteen\HTML5\Document($title='', $charset='utf-8', $beautify=false);
```
+ `$title` **{string}** (optional) The title of the document
+ `$charset` **{string}** (optional) The HTML character set to use
+ `$beautify` **{boolean}** (optional) If the output should be an indented work of art.

Properties

+ `head` **{NodeContainer}** The document's `<head>` element
+ `body` **{NodeContainer}** The document's `<body>` element
+ `title` **{NodeContainer}** The document's `<title>` element

```php
	use Canteen\HTML5\Document;
	$doc = new Document('Untitled');
    $doc->head->addChild(html('script src=main.js'));
    $doc->body->addChild(html('div#frame'));
    echo $doc;
```

####SimpleList

The `SimpleList` for conveniently creating `<ul>` and `<ol>` elements.

```php
Canteen\HTML5\SimpleList($elements, $attributes=null, $type="ul");
```

+ `$elements` **{array}** The collection of strings or other HTML elements
+ `$attributes` **{array | string}** (optional) Collection of element attributes
+ `$type` **{string}** (optional) A value of either "ul" or "ol"

####Table

The `Table` object is used for creating `<table>` elements.

```php
Canteen\HTML5\Table($data, $headers=null, $checkbox=null);
```

+ `$data` **{array}** The collection of associative-arrays with key/value pairs
+ `$headers` **{array}** (optional) The names of the header labels
+ `$checkbox` **{string}** (optional) The name of the key name in the data to replace with a checkbox, for instance "id"

```php
// Create a sample table with some rows of dummy data
$table = new Table(
    array(
        array('id'=>1, 'first'=>'James', 'last'=>'Smith'),
        array('id'=>2, 'first'=>'Mary', 'last'=>'Denver'),
        array('id'=>3, 'first'=>'Charlie', 'last'=>'Rose')
    ),
    array('ID', 'First Name', 'Last Name')
);
```

###Rebuild Documentation

This library is auto-documented using [YUIDoc](http://yui.github.io/yuidoc/). To install YUIDoc, run `sudo npm install yuidocjs`. Also, this requires the project [CanteenTheme](http://github.com/Canteen/CanteenTheme) be checked-out along-side this repository. To rebuild the docs, run the ant task from the command-line. 

```bash
ant docs
```

##License##

Copyright (c) 2013 [Matt Karl](http://github.com/bigtimebuddy)

Released under the MIT License.
