<div id="widget-cart">
	<h3><?=__('Shopping Cart')?></h3>
	<?php if ($cart->getItems()): ?>
	<div class="cart-not-empty">
		<div><?=__('Amount')?>: <b id="cart-amount"><?=$cart->getAmount()?></b></div>
		<?php if ($cart->getDiscount()): ?>
		<div><?=__('Discount')?>: <b id="cart-discount"><?=$cart->getDiscount()?></b></div>
		<?php endif; ?>
		<div><?=__('Count')?>: <b id="cart-count"><?=$cart->getCount()?></b></div>
		<div><?=HTML::anchor(Route::url('cart'), __('Go to cart'))?></div>
	</div>
	<?php else: ?>
	<div class="cart-empty"><?=__('Empty cart')?></div>
	<?php endif; ?>
</div>
