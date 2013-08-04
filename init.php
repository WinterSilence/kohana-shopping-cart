<?php defined('SYSPATH') OR die('No direct script access.');

if ( ! Route::cache())
{
	Route::set('cart', '(<directory>/)cart(/<action>(/<id>))', array(
			'directory' => '(widget)',
			'action'    => '(delete|clear|add|update|index)',
			'id'        => '[a-zA-Z0-9_\-]+',
		))
		->defaults(array(
			//'directory'  => 'Widget',
			'controller' => 'Cart',
			'action'     => 'index',
		));
}
