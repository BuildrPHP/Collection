<?php namespace BuildR\Collection\Map;

use BuildR\Collection\Collection\CollectionInterface;
use BuildR\Collection\Collection\StrictlyTypedCollectionInterface;

/**
 * Provides Map specific functions
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package Collection
 * @subpackage Map
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface MapInterface extends CollectionInterface, StrictlyTypedCollectionInterface {

    /**
     * Determines that the current map contains a mapping
     * for the given key.
     *
     * @param mixed $key
     *
     * @return bool
     */
    public function containsKey($key);

    /**
     * Determines that the current map maps one or more
     * keys fot the given value.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function containsValue($value);

    /**
     * Determines that the collection contains the exact value
     * with the given mapping. This is a combination of
     * containsKey() and containsValue() method.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return bool
     */
    public function contains($key, $value);

    /**
     * Checks that two maps are equals, by comparing
     * maps sizes and all of its key-value pairs
     *
     * @param \BuildR\Collection\Map\MapInterface $map
     *
     * @return mixed
     */
    public function equals(MapInterface $map);

    /**
     * Returns a new map that only contains the element which the filter is returned.
     * The filter is accept any callable type.
     *
     * The callable takes two argument, the first is the key and the second is the
     * value of the element.
     *
     * @param callable $filter
     *
     * @return \BuildR\Collection\Map\MapInterface
     */
    public function filter(callable $filter);

    /**
     * Execute the callback of this map each key-value pair.
     *
     * The callable takes two argument, the first is the key of
     * tha current element and the second is the element value.
     *
     * @param callable $callback
     */
    public function each(callable $callback);

    /**
     * Returns the element on the specified key. If the key not maps to
     * any element of this map, returns the default value.
     *
     * @param mixed $key
     * @param mixed|NULL $defaultValue
     *
     * @return mixed
     */
    public function get($key, $defaultValue = NULL);

    /**
     * Returns a Set that contains all key of this map.
     *
     * @return \BuildR\Collection\Set\SetInterface
     */
    public function keySet();

    /**
     * Returns a list that contains all value contained by
     * this map.
     *
     * @return \BuildR\Collection\ArrayList\ListInterface
     */
    public function valueList();

    /**
     * Merge two maps if the current map not contains the key.
     * If the element maps to a key the element will be skipped.
     *
     * @param \BuildR\Collection\Map\MapInterface $map
     */
    public function merge(MapInterface $map);

    /**
     * Put the given element to the map and maps to the given key.
     * If the key is already occupied by another element
     * the old element will be returned and overwrite
     * with the new value
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return NULL|mixed
     */
    public function put($key, $value);

    /**
     * Put all mappings from the given map to the current map.
     * The result is same as calling the put() method on
     * all element of the given map.
     *
     * This function takes another map or array as argument
     *
     * @param \BuildR\Collection\Map\MapInterface|array $map
     */
    public function putAll($map);

    /**
     * If the specified key is not already associated with a value
     * associates it with the given value and returns NULL
     * otherwise returns the current value.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return mixed
     */
    public function putIfAbsent($key, $value);

    /**
     * Removes the mapping for a key. If key not maps
     * to any element returns NULL, otherwise returns
     * the previous value.
     *
     * @param mixed $key
     *
     * @return NULL|mixed
     */
    public function remove($key);

    /**
     * Removes the mapping for a key, but only if the mapped key
     * value matches the given value. If the key not maps any value
     * or the values not equals returns NULL, otherwise
     * returns the previous element.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return NULL|mixed
     */
    public function removeIf($key, $value);

    /**
     * Replaces the entry for the specified key only if
     * it is currently mapped to some value.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return mixed
     */
    public function replace($key, $value);

    /**
     * Replaces the entry for the specified key only if
     * it is currently mapped to some value and the current
     * value matches to the given old value.
     *
     * @param mixed $key
     * @param mixed $oldValue
     * @param mixed $newValue
     *
     * @return mixed
     */
    public function replaceIf($key, $oldValue, $newValue);

}
