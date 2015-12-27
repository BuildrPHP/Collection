<?php  namespace BuildR\Collection\Interfaces;

use BuildR\Foundation\Object\ArrayConvertibleInterface;
use \Iterator;
use \Countable;

/**
 * Common interface for all collection type
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package Collection
 * @subpackage Interfaces
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface CollectionInterface extends Iterator, Countable, ArrayConvertibleInterface {

    /**
     * Add a new element to the collection. Returns TRUE when
     * the collection is modified, FALSE otherwise.
     *
     * @param mixed $element
     * @return bool
     */
    public function add($element);

    /**
     * Add all values from another collection or array
     *
     * This function may take an array as argument or another collection.
     *
     * @param array|\BuildR\Collection\Interfaces\CollectionInterface $elements
     */
    public function addAll($elements);

    /**
     * Reset the collection, remove all elements
     * and reset the collection index to 0. Returns itself.
     *
     * @return \Buildr\Collection\Interfaces\CollectionInterface
     */
    public function clear();

    /**
     * Determines that the given element is exist in
     * the current collection or not. Returns TRUE if exist
     * FALSE otherwise.
     *
     * @param mixed $element
     * @return bool
     */
    public function contains($element);

    /**
     * Check that the given elements contained by this collection.
     * This check use logical AND. Returns TRUE when all elements
     * is exist, FALSE if at least one not exist.
     *
     * This function may take an array as argument or another collection.
     *
     * @param array|\BuildR\Collection\Interfaces\CollectionInterface $elements
     * @return mixed
     */
    public function containsAll($elements);

    /**
     * Check that from the given elements at least one exist in this collection.
     * Returns TRUE when at least on element is existed, FALSE otherwise.
     *
     * This function may tak an array as argument or another collection.
     *
     * @param array|\Buildr\Collection\Interfaces\CollectionInterface $elements
     * @return mixed
     */
    public function containsAny($elements);

    /**
     * Check that two collections are identical by its contents.
     * Returns TRUE when identical, FALSE otherwise.
     *
     * @param \BuildR\Collection\Interfaces\CollectionInterface $collection
     * @return bool
     */
    public function equals(CollectionInterface $collection);

    /**
     * Determines that the current collection is empty or not
     *
     * @return bool
     */
    public function isEmpty();

    /**
     * Remove the given element from the collection. Returns TRUE when collection
     * is modified, FALSE otherwise.
     *
     * @param mixed $element
     * @return bool
     */
    public function remove($element);

    /**
     * Remove all element from the collection by a given array, or another collection.
     *
     * This function may tak an array as argument or another collection.
     *
     * @param array|\BuildR\Collection\Interfaces\CollectionInterface $elements
     */
    public function removeAll($elements);

    /**
     * Retain only those elements that contained by the given collection, other
     * elements gets removed from the collection.
     *
     * This function may tak an array as argument or another collection.
     *
     * @param array|\BuildR\Collection\Interfaces\CollectionInterface $elements
     */
    public function retainAll($elements);

    /**
     * Returns the size off the current collection.
     *
     * @return int
     */
    public function size();

}