<?php defined('SYSPATH') OR die('No direct script access.');

class Controller_Division_Cart extends Controller_Template
{
	public $template = 'division/cart'; 
	
	public function action_index() 
	{
		$this->template->cart = Cart::instance()->content;
	}
	
}
