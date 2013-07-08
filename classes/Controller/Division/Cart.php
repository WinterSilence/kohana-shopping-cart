<?php defined('SYSPATH') OR die('No direct script access.');

class Controller_Division_Cart extends Controller_Division
{
	
	public function action_index() 
	{
		$this->view->cart = Cart::instance()->content;
	}
	
}