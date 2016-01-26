<?php namespace BuildR\Collection\Tests;

use BuildR\Collection\Exception\MapException;
use BuildR\Collection\Map\HashMap;
use BuildR\TestTools\BuildR_TestCase;

class HashMapTest extends BuildR_TestCase {

    /**
     * @type \BuildR\Collection\Map\HashMap
     */
    protected $map;

    /**
     * @inheritDoc
     */
    protected function setUp() {
        parent::setUp();

        $this->map = new HashMap();
    }

    /**
     * @inheritDoc
     */
    protected function tearDown() {
        parent::tearDown();

        unset($this->map);
    }

    public function invalidKeyDataProvider() {
        return [
            [['test'], 'Only scalar keys allowed, array given in!'],
            [(new \stdClass()), 'Only scalar keys allowed, object given in!'],
            [fopen('php://input', 'r'), 'Only scalar keys allowed, resource given in!'],
            [function() {}, 'Only scalar keys allowed, object given in!'],
        ];
    }

    public function validRandomizedDataProvider() {
        $returned = [];

        $dataSetCount = rand(2, 5);
        $dataSetOne = [];
        for($i = 0; $i <= $dataSetCount; $i++) {
            $dataSetOne[] = $this->getFaker()->word;
        }
        $returned[] = [count($dataSetOne), $dataSetOne];

        $dataSetCount = rand(2, 5);
        $dataSetTwo = [];
        for($i = 0; $i <= $dataSetCount; $i++) {
            $dataSetTwo[] = $this->getFaker()->randomDigit;
        }
        $returned[] = [count($dataSetTwo), $dataSetTwo];

        $dataSetCount = rand(2, 5);
        $dataSetThree = [];
        for($i = 0; $i <= $dataSetCount; $i++) {
            $dataSetThree[] = $this->getFaker()->randomFloat();
        }
        $returned[] = [count($dataSetThree), $dataSetThree];

        $dataSetCount = rand(2, 5);
        $dataSetFour = [];
        for($i = 0; $i <= $dataSetCount; $i++) {
            $dataSetFour[] = $this->getFaker()->randomElements(['test', 25, ['array'], 2e90], 3);
        }

        $returned[] = [count($dataSetFour), $dataSetFour];

        return $returned;
    }

    /**
     * @dataProvider invalidKeyDataProvider
     */
    public function testItValidatesTheKeysProperly($key, $expectedExceptionMessage) {
        $this->setExpectedException(MapException::class, $expectedExceptionMessage);

        $options = ['methodParams' => [$key]];
        $this->invokeMethod(HashMap::class, 'checkKeyType', $this->map, $options);
    }

    /**
     * @dataProvider validRandomizedDataProvider
     */
    public function testContainsFunctionsWorks($elementCount, $elements) {
        $this->map->putAll($elements);

        $randElementNum = rand(0, count($elements) - 1);
        $randElement = $elements[$randElementNum];

        $this->assertTrue($this->map->containsKey($randElementNum));
        $this->assertTrue($this->map->contains($randElementNum, $randElement));
        $this->assertTrue($this->map->containsValue($randElement));
    }

}
