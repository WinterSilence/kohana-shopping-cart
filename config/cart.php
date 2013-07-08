<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'session' => array(
		'lifetime'  => Date::DAY,
		'type'      => Session::$default,
		'key'       => 'shop_cart',
	),
	'model_product' => 'Cart_Product', // ORM adapter for products table
);