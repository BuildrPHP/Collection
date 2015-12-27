<?php namespace BuildR\Collection;

use BuildR\Collection\Interfaces\CollectionInterface;

class Set implements CollectionInterface {

    private $data = [];

    private $position = 0;

    public function __construct($values = NULL) {
        if(is_array($values)) {
            $this->addAll($values);
        }
    }

    /**
     * @inheritDoc
     */
    public function __toArray() {
        return $this->data;
    }

    /**
     * @inheritDoc
     */
    public function add($element) {
        $this->data[] = $element;
    }

    /**
     * @inheritDoc
     */
    public function addAll($elements) {
        $elements = $this->checkAndConvertInputCollection($elements);

        foreach($elements as $item) {
            $this->add($item);
        }
    }

    /**
     * @inheritDoc
     */
    public function clear() {
        $this->data = [];
    }

    /**
     * @inheritDoc
     */
    public function contains($element) {
        if(isset($this->data[$element])) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * @inheritDoc
     */
    public function containsAll($elements) {
        $elements = $this->checkAndConvertInputCollection($elements);

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
     * @inheritDoc
     */
    public function containsAny($elements) {
        $elements = $this->checkAndConvertInputCollection($elements);

        foreach($elements as $item) {
            if($this->contains($item) === TRUE) {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * @inheritDoc
     */
    public function equals(CollectionInterface $collection) {
        //First check the size, if this not equals the tow collection
        //not be identical
        if($collection->size() !== $this->size()) {
            return FALSE;
        }

        //Use strict comparison to check arrays are equals
        //(Values and orders)
        return $collection->__toArray() === $this->data;
    }

    /**
     * @inheritDoc
     */
    public function isEmpty() {
        return empty($this->data);
    }

    /**
     * @inheritDoc
     */
    public function remove($element) {
        if(isset($this->data[$element])) {
            unset($this->data[$element]);

            return TRUE;
        }

        return FALSE;
    }

    /**
     * @inheritDoc
     */
    public function removeAll($elements) {
        $elements = $this->checkAndConvertInputCollection($elements);

        $result = FALSE;

        foreach($elements as $item) {
            if(isset($this->data[$item])) {
                unset($this->data[$item]);

                $result = TRUE;
            }
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function retainAll($elements) {
        $elements = $this->checkAndConvertInputCollection($elements);

        $result = FALSE;

        foreach($elements as $item) {
            if(!isset($this->data[$item])) {
                unset($this->data[$item]);

                $result = TRUE;
            }
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function size() {
        return (is_array($this->data)) ? count($this->data) : 0;
    }

    /**
     * @inheritDoc
     */
    public function current() {
        return $this->data[$this->position];
    }

    /**
     * @inheritDoc
     */
    public function next() {
        $this->position++;
    }

    /**
     * @inheritDoc
     */
    public function key() {
        return $this->position;
    }

    /**
     * @inheritDoc
     */
    public function valid() {
        return isset($this->data[$this->position]);
    }

    /**
     * @inheritDoc
     */
    public function rewind() {
        $this->position--;
    }

    /**
     * @inheritDoc
     */
    public function count() {
        return $this->size();
    }

    /**
     * @param array|\BuildR\Collection\Interfaces\CollectionInterface $elements
     *
     * @return array
     */
    protected function checkAndConvertInputCollection($elements) {
        if($elements instanceof CollectionInterface) {
            $elements = $elements->__toArray();
        }

        return $elements;
    }

}
