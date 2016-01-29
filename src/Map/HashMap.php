<?php namespace BuildR\Collection\Map;

use BuildR\Collection\ArrayList\ArrayList;
use BuildR\Collection\Collection\AbstractCollection;
use BuildR\Collection\Collection\FilterableCollectionTrait;
use BuildR\Collection\Exception\MapException;
use BuildR\Collection\Set\HashSet;

/**
 * MapInterface implementation
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
class HashMap extends AbstractCollection implements MapInterface {

    use FilterableCollectionTrait;

    /**
     * HashMap constructor.
     *
     * @param array|null $content
     */
    public function __construct($content = NULL) {
        if($content !== NULL && is_array($content)) {
            $this->putAll($content);
        }
    }

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
        return (array_search($value, $this->data, TRUE) === FALSE) ? FALSE : TRUE;
    }

    /**
     * {@inheritDoc}
     */
    public function contains($key, $value) {
        if(isset($this->data[$key]) && $this->data[$key] === $value) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * {@inheritDoc}
     */
    public function equals(MapInterface $map) {
        if($this->size() !== $map->size()) {
            return FALSE;
        }

        foreach($this->data as $key => $value) {
            if(!$map->contains($key, $value)) {
                return FALSE;
            }
        }

        return TRUE;
    }

    /**
     * {@inheritDoc}
     */
    public function each(callable $callback) {
        foreach($this->data as $key => $value) {
            call_user_func_array($callback, [$key, $value]);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function get($key, $defaultValue = NULL) {
        $this->checkKeyType($key);

        if(!$this->containsKey($key)) {
            return $defaultValue;
        }

        return $this->data[$key];
    }

    /**
     * {@inheritDoc}
     */
    public function keySet() {
        return new HashSet(array_keys($this->data));
    }

    /**
     * {@inheritDoc}
     */
    public function valueList() {
        return new ArrayList(array_values($this->data));
    }

    /**
     * {@inheritDoc}
     */
    public function merge(MapInterface $map) {
        $self = $this;

        $map->each(function($key, $value) use($self) {
            if(!$self->containsKey($key)) {
                $self->put($key, $value);
            }
        });
    }

    /**
     * {@inheritDoc}
     */
    public function put($key, $value) {
        $this->checkKeyType($key);
        $return = NULL;

        if($this->containsKey($key)) {
            $return = $this->get($key);
        }

        $this->data[$key] = $value;

        return $return;
    }

    /**
     * {@inheritDoc}
     */
    public function putAll($map) {
        if($map instanceof MapInterface) {
            $map = $map->toArray();
        }

        foreach($map as $key => $value) {
            $this->put($key, $value);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function putIfAbsent($key, $value) {
        $this->checkKeyType($key);

        if($this->containsKey($key)) {
            return $this->get($key);
        }

        $this->put($key, $value);

        return NULL;
    }

    /**
     * {@inheritDoc}
     */
    public function remove($key) {
        $this->checkKeyType($key);

        if($this->containsKey($key)) {
            $previousElement = $this->get($key);
            unset($this->data[$key]);

            return $previousElement;
        }

        return NULL;
    }

    /**
     * {@inheritDoc}
     */
    public function removeIf($key, $value) {
        $this->checkKeyType($key);

        if($this->contains($key, $value)) {
            $previousElement = $this->get($key);
            unset($this->data[$key]);

            return $previousElement;
        }

        return NULL;
    }

    /**
     * {@inheritDoc}
     */
    public function replace($key, $value) {
        $this->checkKeyType($key);

        if($this->containsKey($key)) {
            $previousValue = $this->get($key);
            $this->data[$key] = $value;

            return $previousValue;
        }

        return NULL;
    }

    /**
     * {@inheritDoc}
     */
    public function replaceIf($key, $oldValue, $newValue) {
        $this->checkKeyType($key);

        if($this->contains($key, $oldValue)) {
            $previousValue = $this->get($key);
            $this->data[$key] = $newValue;

            return $previousValue;
        }

        return NULL;
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
    protected function checkKeyType($key) {
        if(is_scalar($key)) {
            return TRUE;
        }

        throw MapException::notValidKey($key);
    }

}
