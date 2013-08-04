<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Controller_Page_Cart extends Controller_Template
{
	public $template = 'cart';
	
	public function action_index() 
	{
		$this->template->cart = Cart::instance()->content;
	}
	
}