<?php  namespace BuildR\Collection\Collection;

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
 * @subpackage Collection
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface CollectionInterface extends Iterator, Countable, ArrayConvertibleInterface {

    /**
     * Reset the collection, remove all elements
     * and reset the collection index to 0. Returns itself.
     *
     * @return \Buildr\Collection\Collection\CollectionInterface
     */
    public function clear();

    /**
     * Determines that the given element is exist in
     * the current collection or not. Returns TRUE if exist
     * FALSE otherwise.
     *
     * @param mixed $element
     *
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
     * @param array|\BuildR\Collection\Collection\CollectionInterface $elements
     *
     * @return bool
     */
    public function containsAll($elements);

    /**
     * Check that from the given elements at least one exist in this collection.
     * Returns TRUE when at least on element is existed, FALSE otherwise.
     *
     * This function may tak an array as argument or another collection.
     *
     * @param array|\Buildr\Collection\Collection\CollectionInterface $elements
     *
     * @return bool
     */
    public function containsAny($elements);

    /**
     * Determines that the current collection is empty or not
     *
     * @return bool
     */
    public function isEmpty();

    /**
     * Returns the size off the current collection.
     *
     * @return int
     */
    public function size();

}
