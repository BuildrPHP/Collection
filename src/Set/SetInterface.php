<?php namespace BuildR\Collection\Set;

use BuildR\Collection\Collection\CollectionInterface;

/**
 * This interface provide specific functionality for sets.
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package Collection
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface SetInterface extends CollectionInterface {

    /**
     * Add a new element to the collection. Returns TRUE when
     * the collection is modified, FALSE otherwise.
     *
     * @param mixed $element
     *
     * @return bool
     */
    public function add($element);

    /**
     * Add all values from another collection or array
     *
     * This function may take an array as argument or another collection.
     *
     * @param array|\BuildR\Collection\Collection\CollectionInterface $elements
     */
    public function addAll($elements);

    /**
     * Check that two collections are identical by its contents.
     * Returns TRUE when identical, FALSE otherwise.
     *
     * @param \BuildR\Collection\Set\SetInterface $collection
     *
     * @return bool
     */
    public function equals(SetInterface $collection);

    /**
     * Remove the given element from the collection. Returns TRUE when collection
     * is modified, FALSE otherwise.
     *
     * @param mixed $element
     *
     * @return bool
     */
    public function remove($element);

    /**
     * Remove all element from the collection by a given array, or another collection.
     *
     * This function may tak an array as argument or another collection.
     *
     * @param array|\BuildR\Collection\Set\SetInterface $elements
     */
    public function removeAll($elements);

    /**
     * Retain only those elements that contained by the given collection, other
     * elements gets removed from the collection.
     *
     * This function may tak an array as argument or another collection.
     *
     * @param array|\BuildR\Collection\Set\SetInterface $elements
     */
    public function retainAll($elements);

}
