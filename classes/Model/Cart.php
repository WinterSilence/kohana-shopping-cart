<?php
/**
 * Shopping cart.
 *
 * @package Kohana\Cart
 * @author  info@ensostudio.ru
 * @license MIT
 */
abstract class Model_Cart
{
    /**
     * @var array Cart configuration.
     */
    protected $config = [
        'session_type' => 'native',
        'session_key' => __CLASS__,
        'session_lazy_write' => true,
    ];

    /**
     * @var Session Session instance
     */
    protected $session;

    /**
     * @var array Cart items.
     */
    protected $items = [];

    /**
     * @var float
     */
    protected $cost = 0.0;
    
    /**
     * @var float
     */
    protected $discount = 0.0;

    /**
     * @var int|float
     */
    protected $amount = 0;

    /**
     * @var self
     */
    protected static $instance;

    /**
     * @return self
     * @throws Cart_Item_Exception
     */
    public static function getInstance()
    {
        if (! static::$instance) {
            static::$instance = new static();
        }
        static::$instance->reloadItems();
        return static::$instance;
    }
    
    /**
     * Creates cart instance. Loads items from session, create new instance if not loaded.
     * 
     * @param iterable $config
     * @return void
     */
    public function __construct(iterable $config = null)
    {
        if (is_null($config)) {
            $config = Kohana::$config->load('cart')->as_array();
        } elseif (is_object($config)) {
            $config = iterator_to_array($config);
        }
        $this->config = array_merge($this->config, $config);
        
        $this->session = Session::instance($this->config['session_type']);
        $this->items = $this->session->get($this->config['session_key'], []);
        $this->session->bind($this->config['session_key'], $this->items);
    }

    /**
     * @return array Cart_Item instances
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return float
     */
    public function getCost(): float
    {
        return $this->cost;
    }

    /**
     * Returns calculated discount.
     * 
     * @return float
     */
    abstract protected function calculateDiscount(): float;

    /**
     * @return float
     */
    public function getDiscount(): float
    {
        return $this->discount;
    }

    /**
     * Recalculates items amount, cost, discount and save items in session (optional).
     * 
     * @return self
     */
    protected function reset(): self
    {
        $this->amount = $this->cost = $this->discount = 0.0;
        if ($this->items) {
            foreach ($this->items as $item) {
                $this->cost += $item->getQty() * $item->getPrice();
                $this->amount += $item->getQty();
            }
            $this->discount = $this->calculateDiscount();
        }
        if (empty($this->config['session_lazy_write'])) {
            $this->session->write();
        }
        return $this;
    }

    /**
     * Update items from storage.
     * 
     * @throws Cart_Item_Exception
     */
    public function reloadItems();
    
    /**
     * @param int|string $id
     * @return Cart_Item
     * @throws Cart_Item_Exception
     */
    public function getItem($id): Cart_Item
    {
        if (! $this->hasItem($id)) {
            throw (new Cart_Item_Exception('Not in cart'))->setId($id);
        }
        return $this->items[strval($id)];
    }
    
    /**
     * @param Cart_Item $item
     * @return self
     */
    public function setItem(Cart_Item $item): self
    {
        $this->items[strval($item)] = $item;
        return $this->reset();
    }

    /**
     * @param int|string|Cart_Item $item Item ID or Cart_Item instance.
     * @return bool
     */
    public function hasItem($item): bool
    {
        return isset($this->items[strval($item)]);
    }

    /**
     * @param int|string|Cart_Item $item Item ID or Cart_Item instance.
     * @return self
     */
    public function deleteItem($item): self
    {
        unset($this->items[strval($item)]);
        return $this->reset();
    }
    
    /**
     * @return self
     */
    public function deleteAllItems(): self
    {
        $this->items = [];
        return $this->reset();
    }
}

