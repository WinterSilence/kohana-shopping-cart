<?php defined('SYSPATH') OR die('No direct script access.'); ?>

<div id="cart_short">
	<h3><?php echo __('Shopping Cart') ?></h3>
	<?php if (isset($cart['total'])): ?>
	<div class="full">
		<div><?php echo __('Total cost') ?>:<b id="cart_total_cost"><?php echo $cart['total']['cost'] ?></b></div>
		<?php if ($cart['total']['discount'] > 0): ?>
		<div><?php echo __('Discount') ?>:<b id="cart_total_discount"><?php echo $cart['total']['discount'] ?></b></div>
		<?php endif; ?>
		<div><?php echo __('Total count') ?>:<b id="cart_total_count"><?php echo $cart['total']['count'] ?></b></div>
		<div><?php echo HTML::anchor(Route::url('cart'), __('Go to cart')) ?></div>
	</div>
	<?php else: ?>
	<div class="empty"><?php echo __('Open cart') ?></div>
	<?php endif; ?>
</div>