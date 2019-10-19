<?php
/**
 * Shopping cart item exception.
 * 
 * @package Kohana\Cart
 * @author  info@ensostudio.ru
 * @license MIT
 */
class Cart_Item_Exception extends Kohana_Exception
{
    /**
     * @var string
     */
    protected $itemId;
    /**
     * @var Cart_Item
     */
    protected $item;
    
    /**
     * @param Cart_Item $item
     * @return self
     */
    public function setItem(Cart_Item $item): self
    {
        $this->message = __(
            $item->getName() ? 'Cart item ":name": :msg' : 'Cart item #:id: :msg',
            [':id' => $item->getId(), ':name' => $item->getName(), ':msg' => $this->message]
        );
        $this->item = $item;
        $this->itemId = $item->getId();
        return $this;
    }
    
    /**
     * @param int|string $id
     * @return self
     */
    public function setItemId($id): self
    {
        $this->message = __(
            'Cart item #:id: :msg', 
            [':id' => $id, ':msg' => $this->message]
        );
        $this->itemId = $id;
        return $this;
    }
}
