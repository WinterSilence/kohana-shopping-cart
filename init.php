<?php

if (! Route::cache()) {
	Route::set(
		'cart',
		'(<directory>/)cart(/<action>(/<id>))', 
		[
			'directory' => '(Widget)',
			'action' => '(add|update|delete|clear|index)',
			'id' => '[-a-z0-9_]+',
		]
	)->defaults(['controller' => 'Cart', 'action' => 'index']);
}
