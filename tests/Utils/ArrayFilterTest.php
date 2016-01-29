<?php namespace BuildR\Collection\Tests\Utils;

use BuildR\Collection\Utils\ArrayFilter;
use BuildR\TestTools\BuildR_TestCase;

class ArrayFilterTest extends BuildR_TestCase {

    public function filteringProvider() {
        $class = new \stdClass();
        $class->property = 'test';

        $filterOne = function($index, $element) {
            if(is_string($element) || is_array($element)) {
                return TRUE;
            }
        };

        $filterTwo = function($index, $element) {
            if(($element instanceof \stdClass) && isset($element->property)) {
                return TRUE;
            }
        };

        return [
            [['test', ['array', 10e2]], $filterOne, ['test', ['array', 10e2], TRUE]],
            [[1 => $class], $filterTwo, [254, $class, function() {}]],
        ];
    }

    /**
     * @dataProvider filteringProvider
     */
    public function testItWorksCorrectly($expectedResult, callable $filter, $data) {
        $result = ArrayFilter::execute($data, $filter);

        $this->assertEquals($expectedResult, $result);
        $this->assertCount(count($expectedResult), $result);
    }

}