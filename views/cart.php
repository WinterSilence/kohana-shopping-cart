
<div id="cart_main">
	<h3><?=__('Shopping Cart')?></h3>
	
	<?php if ($cart->getItems()): ?>
	
	<div class="clear"><?=HTML::anchor(Route::url('cart', ['act' => 'clear']), __('Clear'))?></div>
	
	<?=Form::open(Route::url('cart'))?>
	<table class="tbl">
		<tr>
			<th><?=__('Name')?></th>
			<th><?=__('Price')?></th>
			<th><?=__('Quantity')?></th>
			<th>&nbsp;</th>
		</tr>
		<?php foreach ($cart->getItems() as $id => $item): ?>
		<tr>
			<td class="name"><?=$item->getName()?></td>
			<td class="price"><?=$item->getPrice()?> / <=($item->getPrice() * $item->getQty())?></td>
			<td class="qty"><?=Form::input("cart[{$id}]", $item->getQty())?></td>
			<td class="del"><?=HTML::anchor(Route::url('cart', ['act' => 'delete', 'id' => $id]), '[X]')?></td>
		</tr>
		<?php endforeach ?>
	</table>
	<div class="update"><?=Form::submit('update', __('Update'))?></div>
	<div class="total">
		<div><?=__('Amount')?>: <b id="cart_cost"><?=$item->getCost()?></b></div>
		<?php if ($item->getDiscount()): ?>
		<div><?=__('Discount')?>: <b id="cart_discount"><?=$item->getDiscount()?></b></div>
		<?php endif; ?>
		<div><?=__('Total count')?>: <b id="cart_amount"><?=$item->getAmount()?></b></div>
	</div>
	<div class="checkout"><?=Form::submit('checkout', __('Checkout'))?></div>
	<?=Form::close()?>
	
	<?php else: ?>
	
	<div class="cart-empty"><?=__('Empty cart')?></div>
	
	<?php endif; ?>
</div>
