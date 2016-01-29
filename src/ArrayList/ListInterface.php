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
interface ListInterface extends CollectionInterface {

    /**
     * Add a new element to list. This method append the
     * element ot the end of the set
     *
     * @param mixed $element
     */
    public function add($element);

    /**
     * Add all values from another collection, or array. Elements are pushed to the end
     * of the stack.
     *
     * This function may take an array as argument or another set or collection.
     *
     * @param array|\BuildR\Collection\Collection\CollectionInterface $elements
     */
    public function addAll($elements);

    /**
     * Add a new element to the list at the specified position. If the given position
     * is occupied shifts the element currently at that position and any subsequent elements to the right
     * (Add one to all element index)
     *
     * @param int $index
     * @param mixed $element
     */
    public function addTo($index, $element);

    /**
     * Get an element at the given index. If no element at the given index
     * returns NULL.
     *
     * @param int $index
     *
     * @return mixed|NULL
     */
    public function get($index);

    /**
     * Returns a new list that only contains the element which the filter is returned.
     * The filter is accept any callable type.
     *
     * The callable takes two argument, the first is the key and the second is the
     * value of the element.
     *
     * @param callable $filter
     *
     * @return \BuildR\Collection\ArrayList\ListInterface
     */
    public function filter(callable $filter);

    /**
     * Set the given index to contains the given element. Any element in the given
     * index will be overwritten by the new value.
     *
     * If the index is not empty returns the previous element, if not returns NULL
     *
     * @param int $index
     * @param mixed $element
     *
     * @return mixed|NULL
     */
    public function set($index, $element);

    /**
     * Determines that this collection contains an element.
     *
     * @param mixed $element
     *
     * @return bool
     */
    public function contains($element);

    /**
     * It determines there is an element already o the given index.
     *
     * @param int $index
     *
     * @return bool
     */
    public function containsAt($index);

    /**
     * Determines that the current list contains all given value.
     * The input of this method can be an other collection or
     * an array
     *
     * @param \BuildR\Collection\Collection\CollectionInterface|array $elements
     *
     * @return bool
     */
    public function containsAll($elements);

    /**
     * Determines that the current list is contains any value by the input.
     * The input of this method will be an other collection or an array.
     *
     * @param \BuildR\Collection\Collection\CollectionInterface|array $elements
     *
     * @return bool
     */
    public function containsAny($elements);

    /**
     * Determines that the given element is exist in the list and returns the index
     * of the first occurrence. Returns FALSE when no element found
     *
     * @param mixed $element
     *
     * @return int|bool|string
     */
    public function indexOf($element);

    /**
     * Check that two list are equals, by comparing all elements of the lists.
     *
     * @param \BuildR\Collection\ArrayList\ListInterface $collection
     *
     * @return bool
     */
    public function equals(ListInterface $collection);

    /**
     * Removes an element in the given index.
     *
     * @param int $index
     */
    public function removeAt($index);

    /**
     * Removes all element with the given index
     *
     * @param array $elements
     */
    public function removeAll($elements);

    /**
     * Create a new sub-list form this list by extracting element by the
     * given indices.
     *
     * @param int $offset
     * @param int $length
     *
     * @return \BuildR\Collection\ArrayList\ListInterface
     *
     * @see http://php.net/manual/fa/function.array-slice.php
     */
    public function subList($offset, $length);

    /**
     * Retain only those elements that index contained by the given array.
     * An other element will be removed. This function not modify
     * retained elements index.
     *
     * @param \BuildR\Collection\Collection\CollectionInterface|array $elements
     */
    public function retainAll($elements);

}
