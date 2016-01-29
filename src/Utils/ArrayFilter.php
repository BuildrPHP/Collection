<?php namespace BuildR\Collection\Utils;

/**
 * Implementation of PHP array_filter() method. This implmenetation
 * imitate ARRAY_FILTER_BOTH flag and works nicely on HHVM, with
 * absolutely minimal speed impact.
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package Collection
 * @subpackage Utils
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class ArrayFilter {

    /**
     * Execute the filter on the on the given data set. This function
     * will preserve array keys.
     *
     * @param array $data
     * @param callable $filter
     *
     * @return array
     */
    public static function execute($data, callable $filter) {
        $returnedData = [];

        foreach($data as $key => $value) {
            if($filter($key, $value) === TRUE) {
                $returnedData[$key] = $value;
            }
        }

        return $returnedData;
    }

}
