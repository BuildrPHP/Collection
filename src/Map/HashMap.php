<?php namespace BuildR\Collection\Map;

use BuildR\Collection\Collection\AbstractCollection;
use BuildR\Collection\Exception\MapException;

class HashMap extends AbstractCollection implements MapInterface {

    /**
     * {@inheritDoc}
     */
    public function containsKey($key) {
        $this->checkKeyType($key);

        return isset($this->data[$key]);
    }

    /**
     * {@inheritDoc}
     */
    public function containsValue($value) {
        return array_search($value, $this->data, TRUE);
    }

    /**
     * {@inheritDoc}
     */
    public function contains($key, $value) {

    }

    /**
     * {@inheritDoc}
     */
    public function equals(MapInterface $map) {
        if($this->size() !== $map->size()) {
            return FALSE;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function each(callable $callback) {

    }

    /**
     * {@inheritDoc}
     */
    public function get($key, $defaultValue = NULL) {

    }

    /**
     * {@inheritDoc}
     */
    public function keySet() {

    }

    /**
     * {@inheritDoc}
     */
    public function valueList() {

    }

    /**
     * {@inheritDoc}
     */
    public function merge(MapInterface $map) {

    }

    /**
     * {@inheritDoc}
     */
    public function put($key, $value) {

    }

    /**
     * {@inheritDoc}
     */
    public function putAll(MapInterface $map) {

    }

    /**
     * {@inheritDoc}
     */
    public function putIfAbsent($key, $value) {

    }

    /**
     * {@inheritDoc}
     */
    public function remove($key) {

    }

    /**
     * {@inheritDoc}
     */
    public function removeIf($key, $value) {

    }

    /**
     * {@inheritDoc}
     */
    public function replace($key, $value) {

    }

    /**
     * {@inheritDoc}
     */
    public function replaceIf($key, $oldValue, $newValue) {

    }

    /**
     * Validate the given key. This map only allows scalar types
     * as items key. If the validation is fails, throws a MapException.
     *
     * @param mixed $key
     *
     * @return bool
     *
     * @throws \BuildR\Collection\Exception\MapException
     */
    private function checkKeyType($key) {
        if(is_scalar($key)) {
            return TRUE;
        }

        throw MapException::notValidKey($key);
    }

}
