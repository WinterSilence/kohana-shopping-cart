<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Product adapter. Return data in carts format.
 * 
 *
 *   $product = array(
 *               'id'      => 123, //or use sku '123ABC'
 *               'qty'     => 2,
 *               'price'   => 39.95,
 *               'name'    => 'T-Shirt',
 *               'options' => array(
 *                             '123' => array'id' => 134, 'name' => 'Size', 'value' => 'XL'), 
 *                             '13'  => array'id' => 34, 'name' => 'Color', 'value' => 'Red'), 
 *                           ),
 *           );
 
 */
class Model_Cart_Product extends ORM
{
	protected $_table_name    = 'products';
	
	protected $_primary_key   = 'id';
	
	protected $_db_group      = 'default';
	
	protected $_table_columns = array(
		'id'       => array(),
		'name'     => array(),
		'price'    => array(),
		'in_stock' => array(),
		'active'   => array(),
	);
	
	public function get_product($id, $qty, array $options = array())
	{
		 // Get only active products & return correct fields names
		$this->clear()->select(array('in_stock', 'qty'))->where('active', '=', 1);
		
		if (Arr::is_array($id))
		{
			$result = $this->where($this->primary_key(), 'IN', $id)->find_all();
			// TODO: ADD in_stock check
		}
		else
		{
			$result = $this->where($this->primary_key(), '=', $id)
						   ->and_where('in_stock', '>=', $qty)
				           ->find();
		}
		
		if ($result->loaded())
		{
			return $result->as_array();
		}
		else
		{
			// TODO:  
			throw new Database_Exception(__('Old data =\ '));
		}
	}
	
} // End Model_Cart_Product