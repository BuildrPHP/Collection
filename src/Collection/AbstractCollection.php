<?php namespace BuildR\Collection\Collection;

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
        return (array) $this->data;
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
        return current($this->data);
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
     * @param array|\BuildR\Collection\Collection\CollectionInterface $elements
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
