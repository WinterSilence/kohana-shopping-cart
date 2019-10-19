<?php
/**
 * Shopping cart item.
 * 
 * @package Kohana\Cart
 * @author  info@ensostudio.ru
 * @license MIT
 */
abstract class Model_Cart_Item
{
    /**
     * @var int|string SKU or ID
     */
    protected $id;
    /**
     * @var float One item price
     */
    protected $price = 0.0;
    /**
     * @var float The quantity being purchased.
     */
    protected $qty = 0.0;
    /**
     * @var float Minimal quantity.
     */
    protected $minQty = 0.0;
    /**
     * @var float|null Maximal quantity (optional).
     */
    protected $maxQty;
    /**
     * @var array Additional properties.
     */
    protected $data = [];
    /**
     * @var string Escaped name.
     */
    protected $name;
    
    /**
     * Create instance of cart item
     * 
     * @param int|string $id
     * @param int|float $price
     * @param int|float|null $qty
     * @param int|float $minQty
     * @param int|float|null $maxQty
     * @param iterable $data
     * @return void
     */
    public function __construct(
        $id,
        $price,
        $qty = null,
        $minQty = 1,
        $maxQty = null,
        iterable $data = []
    ) {
        $this->id = $id;
        $this->setPrice($price)
             ->setMinQty($minQty)
             ->setMaxQty($maxQty)
             ->setQty($qty)
             ->set($data);
    }
    
    /**
     * 
     * 
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * 
     * 
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }
    
    /**
     * 
     * 
     * @return float
     */
    public function getQty(): float
    {
        return $this->qty;
    }
    
    /**
     * 
     * 
     * @return float
     */
    public function getMinQty(): float
    {
        return $this->minQty;
    }
    
    /**
     * 
     * 
     * @return float|null
     */
    public function getMaxQty(): ?float
    {
        return $this->maxQty;
    }
    
    /**
     * 
     * 
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }
    
    /**
     * 
     * 
     * @param iterable $data
     * @return self
     */
    public function set(iterable $data): self
    {
        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                continue;
            }
            if (property_exists($this, $key)) {
                $method = 'set' . ucfirst($key);
                if (method_exists($this, $method)) {
                    $this->{$method}($value);
                } else {
                    $this->data[$key] = $value;
                }
            }
        }
        return $this;
    }
    
    /**
     * 
     * 
     * @param float $price;
     * @return self
     */
    public function setPrice($price): self
    {
        if (0 >= $price) {
            throw (new Cart_Item_Exception('Price less or equal to zero'))->setItem($this);
        }
        $this->price = (float) $price;
        return $this;
    }
    
    /**
     * 
     * 
     * @param int|float $minQty
     * @return self
     */
    public function setMinQty($minQty): self
    {
        if (0 >= $minQty) {
            throw (new Cart_Item_Exception('Minimal quantity less or equal to zero'))->setItem($this);
        }
        if ($this->maxQty && $minQty > $this->maxQty) {
            throw (new Cart_Item_Exception('Minimal quantity more than maximal'))->setItem($this);
        }
        if ($this->qty && $minQty > $this->qty) {
            throw (new Cart_Item_Exception('Minimal quantity more than added in cart'))->setItem($this);
        }
        $this->minQty = (float) $minQty;
        return $this;
    }
    
    /**
     * 
     * 
     * @param int|float|null $maxQty
     * @return self
     */
    public function setMaxQty($maxQty): self
    {
        if ($maxQty) {
            if ($this->minQty > $maxQty) {
                throw (new Cart_Item_Exception('Maximal quantity less than mininal'))->setItem($this);
            }
            if ($this->qty > $maxQty) {
                throw (new Cart_Item_Exception('Maximal quantity less than added in cart'))->setItem($this);
            }
        }
        $this->maxQty = $maxQty ? (float) $maxQty : null;
        return $this;
    }
    
    /**
     * 
     * 
     * @param int|float|null $qty
     * @return self
     */
    public function setQty($qty): self
    {
        $qty = is_null($qty) ? $this->minQty : (float) $qty;
        if ($qty < $this->minQty) {
            throw (new Cart_Item_Exception('Quantity less than minimal'))->setItem($this);
        }
        if ($this->maxQty && $qty > $this->maxQty) {
            throw (new Cart_Item_Exception('Quantity more than maximal'))->setItem($this);
        }
        $this->qty = $qty;
        return $this;
    }
    
    /**
     * 
     * 
     * @param string $name
     * @return self
     */
    public function setName($name): self
    {
        $this->name = htmlentities(strval($name));
        return $this;
    }
    
    /**
     * Returns array of properties.
     * 
     * @return array
     */
    public function asArray(): array
    {
        return get_object_vars($this);
    }
    
    
    /**
     * Returns serializing properties. 
     * Note: don't override method unless necessary - items stored in session.
     * 
     * @return array
     */
    public function __sleep()
    {
        $properties = get_class_vars(__CLASS__);
        unset($properties['data']);
        return array_keys($properties);
    }
    
    /**
     * Getter/setter for data.
     * 
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $method, array $arguments = [])
    {
        $prefix = substr($method, 0, 3);
        if (in_array($prefix, ['get', 'set'])) {
            $key = lcfirst(substr($method, 3));
            if (array_key_exists($key, $this->data)) {
                if ($prefix == 'get') {
                    return $this->data[$key];
                } else {
                    $this->data[$key] = array_shift($arguments[0]);
                    return $this;
                }
            }
        }
        $ex = new Cart_Item_Exception('Called method :name not exists', [':name' => $method]);
        throw $ex->setItem($this);
    }
    
    /**
     * Returns string with item ID.
     * 
     * @return string
     */
    public function __toString()
    {
        return (string) $this->id;
    }
}

