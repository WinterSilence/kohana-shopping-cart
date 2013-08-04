<?php defined('SYSPATH') OR die('No direct script access.'); ?>

<div id="cart_main">

	<h3><?php echo __('Shopping Cart') ?></h3>
	
	<?php if ( ! empty($cart)): ?>
	
	<div class="clear"><?php echo HTML::anchor(Route::url('cart', array('act' => 'clear')), __('Clear')) ?></div>
	
	<?php echo Form::open(Route::url('cart')) ?>
	
	<table class="tbl">
		<tr>
			<th><?php echo __('Name') ?></th>
			<th><?php echo __('Price') ?></th>
			<th><?php echo __('Quantity') ?></th>
			<th></th>
		</tr>
		<?php foreach ($cart['products'] as $key => $product): ?>
		<tr>
			<td class="name"><?php echo $product['name'] ?></td>
			<td class="price"><?php echo $product['price'] ?></td>
			<td class="qty"><?php echo Form::input("cart[{$key}]", $product['qty']) ?></td>
			<td class="del"><?php echo HTML::anchor(Route::url('cart', array('act' => 'delete', 'id' => $key)), '[X]') ?></td>
		</tr>
		<?php endforeach ?>
	</table>
	
	<div class="update"><?php echo Form::submit('update', __('Update')) ?></div>
	
	<div class="total">
		<div><?php echo __('Total cost') ?>:<b id="cart_total_cost"><?php echo $cart['total']['cost'] ?></b></div>
		<?php if ($cart['total']['discount'] > 0): ?>
		<div><?php echo __('Discount') ?>:<b id="cart_total_discount"><?php echo $cart['total']['discount'] ?></b></div>
		<?php endif; ?>
		<div><?php echo __('Total count') ?>:<b id="cart_total_count"><?php echo $cart['total']['count'] ?></b></div>
	</div>
	
	<div class="checkout"><?php echo Form::submit('checkout', __('Checkout')) ?></div>
	
	<?php echo Form::close() ?>
	
	<?php else: ?>
	
	<div class="empty"><?php echo __('Empty cart') ?></div>
	
	<?php endif; ?>
	
</div>