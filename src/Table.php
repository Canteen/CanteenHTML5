<?php

/**
* @module Canteen\HTML5 
*/
namespace Canteen\HTML5
{		
	/**
	*  Convenience class for building a Table. Useful for display
	*  rows of data from a database or another collection
	*  of associative arrays.
	*	
	*	$table = new Canteen\HTML5\Table(
	*		array(
	*			array('id'=>1, 'first'=>'James', 'last'=>'Smith'),
	*			array('id'=>2, 'first'=>'Mary', 'last'=>'Denver'),
	*			array('id'=>3, 'first'=>'Charlie', 'last'=>'Rose')
	*		),
	*		array('ID', 'First Name', 'Last Name')
	*	);
	*  
	*  @class Table
	*  @extends NodeContainer
	*  @constructor
	*  @param {Array} data The collection of Dictionary objects
	*  @param {Array} [headers=null] An optional collection of header labels for each value
	*  @param {String} [checkbox=null] If we should add a checkbox to each row, this is the name 
	*         of the attribute to use as a value. For instance `array('id'=>2)` is 
	*         `<input type="checkbox" name="id[]" value="2">`
	*/
	class Table extends NodeContainer
	{
		public function __construct($data, $headers=null, $checkbox=null)
		{
			parent::__construct('table', null, null);
			
			if ($headers != null && is_array($headers))
			{
				$head = html('thead');
				$this->addChild($head);
				
				$row = html('tr');
				
				if ($checkbox != null)
				{
					$row->addChild(html('th', html('span', $checkbox)));
				}
				
				foreach($headers as $header)
				{
					$row->addChild(html('th', $header));
				}
				$head->addChild($row);
			}
			
			$body = html('tbody');
			
			foreach($data as $d)
			{
				$row = html('tr');
				
				if ($checkbox != null)
				{
					$td = html('td', 
						html(
							'input', 
							'type=checkbox name='.$checkbox.'[] value='.$d[$checkbox]
						),
						'class='.$checkbox
					);
					$row->addChild($td);
				}
				foreach($d as $name=>$value)
				{
					if ($name == $checkbox) continue;
					$td = html('td', $value, 'class='.$name);
					$row->addChild($td);
				}
				$body->addChild($row);
			}
			$this->addChild($body);
		}
	}
}

?>