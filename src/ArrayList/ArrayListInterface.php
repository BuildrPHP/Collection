<?php namespace BuildR\Collection\ArrayList;

use BuildR\Collection\Collection\CollectionInterface;

/**
 * Provides ArrayList specific functions
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package Collection
 * @subpackage ArrayList
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface ArrayListInterface extends CollectionInterface {

    /**
     * Add a new element to the collection. Returns TRUE when
     * the set is modified, FALSE otherwise.
     *
     * If the given index
     *
     * @param mixed $element
     *
     * @return bool
     */
    public function add($element);

    public function addTo($index, $element);

    public function equals(ArrayListInterface $collection);

    public function remove($element);

    public function removeAll($elements);

    public function removeAt($index);

    /**
     * Add all values from another collection, set or array
     *
     * This function may take an array as argument or another set or collection.
     *
     * @param array|\BuildR\Collection\Collection\CollectionInterface $elements
     */
    public function addAll($elements);

}
