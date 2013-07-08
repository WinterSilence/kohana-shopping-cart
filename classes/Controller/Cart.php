<?php defined('SYSPATH') OR die('No direct script access.');

class Controller_Cart extends Controller_Template
{
	public $template = 'cart';
	
	public function action_index() 
	{
		//$prd = array(array('id'=>1,'qty'=>1),array('id'=>4,'qty'=>3));
		//$v = Cart::instance()->delete()->set($prd)->get();
		//$v = Cart::instance()->delete()->set(1,2)->get();
		//var_export($v);
		$this->template->content = View::factory('cart');
		$this->template->cart = Cart::instance()->content;
	}
	
}