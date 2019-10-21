## Shopping cart module for Kohana7(KF7) framework

Abstract e-commerce cart for shop applications.

### Used terms:

**QTY** is defined as an abbreviation for "quantity" and means the number or amount of something.
**SKU** is a number assigned to a product by a store to identify the price, options and manufacturer of the merchandise.

### Install

1. Copy repository files in directory `modules/cart`.
2. Add module `cart` in `bootstrap.php`.
3. Create class `Cart` inherit `Model_Cart` and define methods `calculateDiscount`, `reloadItems`.
4. Optional, create config `config/modules/cart.php`.
4. Optional, create messages `messages/modules/cart/item.php`.

~~~
class Cart extends Model_Cart
{
    protected function calculateDiscount()
    {
        // Calculate total discount: `$this->discount`.
        // Optional, calculate discount for every item: `item->discount`.
    }
    
    protected function reloadItems()
    {
        /* 
        CREATE TABLE IF NOT EXISTS `shop_products` (
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL,
            `in_stock` INT(11) NOT NULL DEFAULT 0,
            `price` DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0,
            `available` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0
        );
        */
        $products = DB::select('id', 'name', ['in_stock', 'max_qty'], 'price')
            ->from('shop_products')
            ->where('id', 'IN', array_keys($this->items))
            ->and_where('available', '=', 1)
            ->execute()
            ->as_array('id');
        foreach ($this->items as $id = $item) {
            if (isset($products[$id])) {
                $item->set($products[$id]);
            } else {
                // If product not exists/available than set zero quantity.
                $item->setQty(0);
            }
        }
    }
}
~~~

### Usage

~~~
// Create cart
$cart = new Cart($optional_config_array);

// Get totals:
echo $cart->getCost();
echo $cart->getAmount();
echo $cart->getDiscount();

// Get items:
foreach ($cart->getItems() as $id => $item) {
   echo $item->getName().PHP_EOL;
}

// Get item and his properties:
echo $cart->getItem($id)->getMaxQty();

// Set item properties:
$cart->getItem($id)->setPrice(140)->setQty(5);
$cart->getItem($id)->set($array);

Create item:
$item = new Cart_Item($id, $qty, $minQty, $maxQty);

// Add item:
$cart->setItem($item);

// Update from storage(database):
$cart->reloadItems();

// Delete item:
$cart->deleteItem($id);
$cart->deleteItem($item);

// Check item:
if ($cart->hasItem($id)) {
}

// Delete all items:
$cart->clear();
~~~
