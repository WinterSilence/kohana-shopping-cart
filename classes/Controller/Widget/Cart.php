<?php defined('SYSPATH') OR die('No direct script access.');

class Controller_Widget_Cart extends Controller_Template
{
	public $template = 'widget/cart';
	
	public $auto_render = TRUE;
	
	protected $cart;
	
	public function before() 
	{
		if ($this->request->is_ajax())
		{
			$this->auto_render = FALSE;
		}
		
		$this->cart = Cart::instance();
		
		parent::before();
	}
	
	public function action_index() 
	{
		if ($this->request->is_ajax())
		{
			$this->response->body(json_encode($this->cart->content));
		}
		else
		{
			$this->template->cart = $this->cart->content;
		}
	}
	
	public function action_add()
	{
		if ($product = Arr::extract($this->request->post(), array('id', 'qty', 'options')))
		{
			try
			{
				$this->cart->set($product['id'], $product['qty'], (array)$product['options']);
			}
			catch (Kohana_Exception $e)
			{
				$errors = (string)$e;
			}
		}
		
		if ($this->request->is_ajax())
		{
			if ( isset($errors))
			{
				$this->response->body(json_encode(array('result' => 'error', 'errors' => $errors)));
			}
			else
			{
				$this->response->body(json_encode($this->cart->content));
			}
		}
		else
		{
			//$this->template->cart = $this->cart->content;
			//HTTP::redirect(Route::url('cart'));
		}
	}
	
}