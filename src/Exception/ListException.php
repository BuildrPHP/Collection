<?php namespace BuildR\Collection\Exception;
use BuildR\Foundation\Exception\Exception;

/**
 * This exception is thrown by any ListInterface implementation
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package Collection
 * @subpackage Exception
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 *
 * @codeCoverageIgnore
 */
class ListException extends Exception {

    const MESSAGE_NON_NUMERIC_INDEX = 'The key must be numeric, %s given in!';

    public static function nonNumericIndex($actualType) {
        return self::createByFormat(self::MESSAGE_NON_NUMERIC_INDEX, [$actualType]);
    }

}
