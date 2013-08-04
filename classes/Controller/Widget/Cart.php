<?php defined('SYSPATH') OR die('No direct script access.');

class Controller_Widget_Cart extends Controller_Template
{
	public $template = 'widget/cart';
	
	public $auto_render = TRUE;
	
	protected $_cart;
	
	public function before() 
	{
		if ($this->request->is_ajax())
		{
			$this->auto_render = FALSE;
		}
		
		$this->_cart = Cart::instance();
		
		parent::before();
	}
	
	public function action_index() 
	{
		if ($this->request->is_ajax())
		{
			$this->response->body(json_encode($this->_cart->content));
		}
		else
		{
			$this->template->cart = $this->_cart->content;
		}
	}
	
	public function action_add()
	{
		if ($product = Arr::extract($this->request->post(), array('id', 'qty', 'options')))
		{
			try
			{
				$this->_cart->set($product['id'], $product['qty'], (array) $product['options']);
			}
			catch (Kohana_Exception $e)
			{
				$errors = Debug::dump($e);
			}
		}
		
		if ($this->request->is_ajax())
		{
			$result = isset($errors) ? array('result' => 'error', 'errors' => $errors) : $this->_cart->content;
			$this->response->body(json_encode($result));
		}
		else
		{
			$this->template->cart = $this->_cart->content;
			HTTP::redirect(Route::url('cart'));
		}
	}
	
}