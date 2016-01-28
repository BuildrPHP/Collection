<?php namespace BuildR\Collection\Exception;

use BuildR\Foundation\Exception\Exception;

/**
 * Class MapException
 * @package BuildR\Collection\Exception
 *
 * @codeCoverageIgnore
 */
class MapException extends Exception {

    const MESSAGE_NON_VALID_KEY = "Only scalar keys allowed, %s given in!";

    const MESSAGE_NON_VALID_ARRAY = "This function only takes associative array as argument. Sequential given";

    /**
     * @param mixed $key
     *
     * @return self
     */
    public static function notValidKey($key) {
        $type = gettype($key);

        return self::createByFormat(self::MESSAGE_NON_VALID_KEY, [$type]);
    }

    /**
     * @return self
     */
    public function sequentialArray() {
        return self::createByFormat(self::MESSAGE_NON_VALID_ARRAY);
    }

}
