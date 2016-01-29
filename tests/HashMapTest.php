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
    public function testFilteringWorks($expectedResult, callable $filter, $data) {
        $this->map->putAll($data);

        /** @type \BuildR\Collection\Map\MapInterface $result */
        $result = $this->map->filter($filter);

        $this->assertInstanceOf(HashMap::class, $this->map);
        $this->assertEquals($expectedResult, $result->toArray());
        $this->assertCount(count($expectedResult), $result);
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

    /**
     * @dataProvider validRandomizedDataProvider
     */
    public function testCalculateEqualityCorrectly($elementCount, $elements) {
        $this->map->putAll($elements);
        $map = new HashMap($elements);
        $mapIncorrectSize = new HashMap();
        $mapIncorrectSize->put('test', 'testingValue');
        $mapCorrectSizeWithDifferentValue = new HashMap();
        $mapCorrectSizeWithDifferentValue->putAll($this->getFaker()->randomElements(
            ['test', 25, ['array'], 2e90, TRUE, .75],
            $elementCount
        ));

        $this->assertFalse($this->map->equals($mapIncorrectSize));
        $this->assertFalse($this->map->equals($mapCorrectSizeWithDifferentValue));
        $this->assertTrue($this->map->equals($map));
    }

    /**
     * @dataProvider validRandomizedDataProvider
     */
    public function testForeachFunctionalityWorks($elementCount, $elements) {
        $this->map->putAll($elements);

        $result = [];
        $this->map->each(function($key, $value) use(&$result) {
           $result[$key] = $value;
        });

        $this->assertCount($elementCount, $result);
        $this->assertArraySubset($result, $this->map->toArray());
    }

    /**
     * @dataProvider validRandomizedDataProvider
     */
    public function testGetValueWorks($elementCount, $elements) {
        $this->map->putAll($elements);
        $randomIndex = rand(0, $elementCount - 1);
        $randomReturnValue = $this->getFaker()->randomElements(['test', 25, ['array'], 2e90], 1)[0];

        $this->assertEquals($elements[$randomIndex], $this->map->get($randomIndex));
        $this->assertNull($this->map->get(99));
        $this->assertEquals($randomReturnValue, $this->map->get(99, $randomReturnValue));
    }

    /**
     * @dataProvider validRandomizedDataProvider
     */
    public function testReturnsTheKeySetAndValueListCorrectly($elementCount, $elements) {
        $this->map->putAll($elements);
        $set = $this->map->keySet();
        $keys = array_keys($elements);
        $values = array_values($elements);
        $list = $this->map->valueList();

        $this->assertEquals($this->map->size(), $set->size());
        $this->assertArraySubset($keys, $set->toArray());

        $this->assertEquals($this->map->size(), $list->size());
        $this->assertArraySubset($values, $list->toArray());
    }

    /**
     * @dataProvider validRandomizedDataProvider
     */
    public function testMergeMapsCorrectly($elementCount, $elements) {
        $this->map->putAll($elements);
        $firstHalf = (int) floor($elementCount - rand(1, $elementCount - 1));
        $lastHalf = (int) $elementCount - $firstHalf;

        $mapOne = new HashMap();
        $mapTwo = new HashMap();

        $resultOne = array_slice($elements, 0, $firstHalf, TRUE);
        $resultTwo = array_slice($elements, $firstHalf, $lastHalf, TRUE);

        $mapOne->putAll($resultOne);
        $mapTwo->putAll($resultTwo);

        $this->assertCount($firstHalf, $mapOne);
        $this->assertCount($lastHalf, $mapTwo);

        $mapOne->merge($mapTwo);

        $this->assertTrue($this->map->equals($mapOne));
    }

    /**
     * @dataProvider validRandomizedDataProvider
     */
    public function testPutFunctionalityWorks($elementCount, $elements) {
        $randomValue = $this->getFaker()->word;
        $randomKey = $this->getFaker()->word;

        $this->assertNull($this->map->put($randomKey, $elements));
        $this->assertEquals($elements, $this->map->put($randomKey, $randomValue));
        $this->assertEquals($randomValue, $this->map->get($randomKey));
    }

    /**
     * @dataProvider validRandomizedDataProvider
     */
    public function testPutAllFunctionalityWorks($elementCount, $elements) {
        $this->map->putAll($elements);
        $testMap = new HashMap();
        $testMap->putAll($this->map);

        $this->assertTrue($this->map->equals($testMap));
    }

    /**
     * @dataProvider validRandomizedDataProvider
     */
    public function testPutIfAbsentFunctionalityWorks($elementCount, $elements) {
        $randomElement = (string) rand(0, $elementCount - 1);
        $randomElementValue = $elements[$randomElement];
        $randomKey = $this->getFaker()->word;

        $this->assertNull($this->map->putIfAbsent($randomKey, $randomElementValue));
        $this->assertEquals($randomElementValue, $this->map->putIfAbsent($randomKey, 'testValue'));
    }

    /**
     * @dataProvider validRandomizedDataProvider
     */
    public function testRemoveFunctionalityWorks($elementCount, $elements) {
        $this->map->putAll($elements);
        $randomKey = rand(0, $elementCount - 1);
        $randomValue = $elements[$randomKey];
        $randomNonExistKey = $this->getFaker()->word;

        $this->assertNull($this->map->remove($randomNonExistKey));
        $this->assertEquals($randomValue, $this->map->remove($randomKey));
        $this->assertCount($elementCount - 1, $this->map);
        $this->assertArrayNotHasKey($randomKey, $this->map->toArray());
    }

    /**
     * @dataProvider validRandomizedDataProvider
     */
    public function testRemoveIfFunctionalityWorks($elementCount, $elements) {
        $this->map->putAll($elements);
        $randomKey = rand(0, $elementCount - 1);
        $randomValue = $elements[$randomKey];
        $randomNonExistingValue = $this->getFaker()->word;

        $this->assertNull($this->map->removeIf($randomKey, $randomNonExistingValue));
        $this->assertCount($elementCount, $this->map);

        $this->assertEquals($randomValue, $this->map->removeIf($randomKey, $randomValue));
        $this->assertCount($elementCount - 1, $this->map);
        $this->assertArrayNotHasKey($randomKey, $this->map->toArray());
    }

    /**
     * @dataProvider validRandomizedDataProvider
     */
    public function testReplaceFunctionalityWorks($elementCount, $elements) {
        $this->map->putAll($elements);
        $randomKey = rand(0, $elementCount - 1);
        $randomValue = $elements[$randomKey];
        $randomNonExistKey = $this->getFaker()->word;

        $this->assertNull($this->map->replace($randomNonExistKey, 'test'));
        $this->assertEquals($randomValue, $this->map->replace($randomKey, 'testerValue'));
        $this->assertCount($elementCount, $this->map);
        $this->assertEquals('testerValue', $this->map->get($randomKey));
    }

    /**
     * @dataProvider validRandomizedDataProvider
     */
    public function testReplaceIfIfFunctionalityWorks($elementCount, $elements) {
        $this->map->putAll($elements);
        $randomKey = rand(0, $elementCount - 1);
        $randomValue = $elements[$randomKey];
        $randomNonExistingValue = $this->getFaker()->word;

        $this->assertNull($this->map->replaceIf($randomKey, $randomNonExistingValue, 'tester'));
        $this->assertCount($elementCount, $this->map);

        $this->assertEquals($randomValue, $this->map->replaceIf($randomKey, $randomValue, 'testerValue'));
        $this->assertCount($elementCount, $this->map);
        $this->assertEquals('testerValue', $this->map->get($randomKey));
    }


}
