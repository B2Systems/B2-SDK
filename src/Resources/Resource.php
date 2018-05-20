<?php

namespace B2Systems\B2\Resources;

use B2Systems\B2\B2;

class Resource
{
    /**
     * The resource attributes.
     *
     * @var array
     */
    public $attributes;

    /**
     * The B2 SDK instance.
     *
     * @var B2
     */
    protected $b2;

    /**
     * Create a new resource instance.
     *
     * @param  array $attributes
     * @param  B2 $b2
     * @return void
     */
    public function __construct(array $attributes, $b2 = null)
    {
        $this->attributes = $attributes;
        $this->b2 = $b2;
        $this->fill();
    }

    /**
     * Fill the resource with the array of attributes.
     *
     * @return void
     */
    private function fill()
    {
        foreach ($this->attributes as $key => $value) {
            $key = $this->camelCase($key);
            $this->{$key} = $value;
        }
    }
    
    /**
     * Convert the key name to camel case.
     *
     * @param $key
     */
    private function camelCase($key)
    {
        $parts = explode('_', $key);
        foreach ($parts as $i => $part) {
            if ($i !== 0) {
                $parts[$i] = ucfirst($part);
            }
        }
        return str_replace(' ', '', implode(' ', $parts));
    }
}
