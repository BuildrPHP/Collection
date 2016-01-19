<?php namespace BuildR\Collection\Collection;

use BuildR\Collection\Interfaces\CollectionInterface;
use BuildR\Foundation\Object\ArrayConvertibleInterface;

/**
 * Abstract collection implementation
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package Collection
 * @subpackage Collection
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
abstract class AbstractCollection implements CollectionInterface {

    /**
     * @type array
     */
    protected $data = [];

    /**
     * {@inheritdoc}
     */
    public function toArray() {
        return array_map(function($value) {
            if((is_object($value) && method_exists($value, 'toArray'))
                || ($value instanceof ArrayConvertibleInterface)) {
                return $value->toArray();
            }

            return $value;
        }, $this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function clear() {
        $this->data = [];
    }

    /**
     * {@inheritdoc}
     */
    public function contains($element) {
        return (array_search($element, $this->data, TRUE) === FALSE) ? FALSE : TRUE;
    }

    /**
     * {@inheritdoc}
     */
    public function containsAll($elements) {
        $elements = $this->collectionToArray($elements);

        $result = TRUE;

        foreach($elements as $item) {
            if($this->contains($item) === FALSE) {
                $result = FALSE;

                break;
            }
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function containsAny($elements) {
        $elements = $this->collectionToArray($elements);

        foreach($elements as $item) {
            if($this->contains($item) === TRUE) {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * {@inheritdoc}
     */
    public function equals(CollectionInterface $collection) {
        //First check the size, if this not equals the tow collection
        //not be identical
        if($collection->size() !== $this->size()) {
            return FALSE;
        }

        //Use strict comparison to check arrays are equals
        //(Values and orders)
        return $collection->toArray() === $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty() {
        return empty($this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function size() {
        return (is_array($this->data)) ? count($this->data) : 0;
    }

    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function current() {
        return $this->data[$this->position];
    }

    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function next() {
        return next($this->data);
    }

    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function key() {
        return key($this->data);
    }

    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function valid() {
        return key($this->data) !== NULL;
    }

    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function rewind() {
        return reset($this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function count() {
        return $this->size();
    }

    /**
     * @param array|\BuildR\Collection\Interfaces\CollectionInterface $elements
     *
     * @return array
     */
    protected function collectionToArray($elements) {
        if($elements instanceof CollectionInterface) {
            $elements = $elements->toArray();
        }

        return $elements;
    }

}
