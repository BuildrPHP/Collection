<?php namespace BuildR\Collection\Tests;

use BuildR\Collection\ArrayList\ArrayList;
use BuildR\Collection\Exception\ListException;
use BuildR\TestTools\BuildR_TestCase;

class ArrayListTest extends BuildR_TestCase {

    /**
     * @type \BuildR\Collection\ArrayList\ArrayList
     */
    protected $list;

    public function setUp() {
        parent::setUp();

        $this->list = new ArrayList();
    }

    public function tearDown() {
        parent::tearDown();

        unset($this->list);
    }

    public function mixedTypeMultiProvider() {
        return [
            [3, ['test', ['array', 10e2], TRUE]],
            [3, [254, (new \stdClass()), function() {}]],
        ];
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
            [[$class], $filterTwo, [254, $class, function() {}]],
        ];
    }

    public function indexTestingProvider() {
        return [
            ['test', ListException::class, 'The key must be numeric, string given in!', NULL],
            [[['test' => 'value']], ListException::class, 'The key must be numeric, array given in!', NULL],
            [[(new \stdClass())], ListException::class, 'The key must be numeric, object given in!', NULL],
            [[fopen('php://input', 'r')], ListException::class, 'The key must be numeric, resource given in!', NULL],
            [[NULL], ListException::class, 'The key must be numeric, NULL given in!', NULL],
            [3.75, NULL, NULL, 3],
            [2e4, NULL, NULL, 20000],
            [2, NULL, NULL, 2],
        ];
    }

    /**
     * @dataProvider indexTestingProvider
     */
    public function testItValidatesIndexCorrectly($index, $expectedExceptionClass, $expectedExceptionMessage, $eRes) {
        if($expectedExceptionClass !== NULL) {
            $this->setExpectedException($expectedExceptionClass, $expectedExceptionMessage);
        }

        $options = ['methodParams' => $index];
        $result = $this->invokeMethod(ArrayList::class, 'checkIndex', $this->list, $options);

        $this->assertEquals($eRes, $result);
    }

    public function testItConstructWithNewElementsCorrectly() {
        $list = new ArrayList(['test', ['data']]);

        $this->assertCount(2, $list);
        $this->assertTrue($list->containsAll([['data'], 'test']));
    }

    public function testItAddsElementsAfterTheLastElementWhenFreeSpotAvaialble() {
        $this->list->add('test');
        $this->list->add(25);

        //Ensure element is added
        $this->assertEquals(1, $this->list->indexOf(25));

        //Remove it
        $this->list->removeAt(1);
        $this->assertFalse($this->list->containsAt(1));

        //Add new element
        $this->list->add('dummy');
        $this->assertTrue($this->list->containsAt(2));
        $this->assertEquals('dummy', $this->list->get(2));
    }

    /**
     * @dataProvider mixedTypeMultiProvider
     */
    public function testAddAllWorks($expectedCount, $elements) {
        $this->list->addAll($elements);

        $this->assertCount($expectedCount, $this->list);
        $this->assertTrue($this->list->containsAll($elements));
    }

    public function testAddToWorking() {
        $this->list->addAll(['test', 4e2, FALSE, ['key' => 'value']]);

        $this->list->addTo(1, 77);

        $this->assertEquals('test', $this->list->get(0));
        $this->assertEquals(77, $this->list->get(1));
        $this->assertEquals(4e2, $this->list->get(2));
        $this->assertEquals(FALSE, $this->list->get(3));
        $this->assertArrayHasKey('key', $this->list->get(4));
    }

    public function testGetShouldReturnNullWhenNoElementInPosition() {
        foreach(range(0, 9) as $key) {
            $this->assertNull($this->list->get($key));
        }
    }

    /**
     * @dataProvider filteringProvider
     */
    public function testFilteringWorks($expectedResult, callable $filter, $data) {
        $this->list->addAll($data);

        /** @type \BuildR\Collection\ArrayList\ArrayList $result */
        $result = $this->list->filter($filter);

        $this->assertEquals($expectedResult, $result->toArray());
        $this->assertCount(count($expectedResult), $result);
    }

    /**
     * @dataProvider mixedTypeMultiProvider
     */
    public function testSetIsWorking($expectedCount, $elements) {
        $this->list->addAll($elements);

        $expectedResult = $this->list->get(1);
        $result = $this->list->set(1, 'newValue');

        $this->assertEquals($expectedResult, $result);

        $this->assertNull($this->list->set(rand(20, 30), 'anotherNewValue'));
    }

    /**
     * @dataProvider mixedTypeMultiProvider
     */
    public function testContainsWorks($expectedCount, $elements) {
        $this->list->addAll($elements);
        $randElement = $this->list->get(rand(0, $expectedCount - 1));

        $this->assertTrue($this->list->contains($randElement));
    }

    /**
     * @dataProvider mixedTypeMultiProvider
     */
    public function testContainsAtWorks($expectedCount, $elements) {
        $this->list->addAll($elements);
        $randElement = rand(0, $expectedCount - 1);

        $this->assertTrue($this->list->containsAt($randElement));
    }

    /**
     * @dataProvider mixedTypeMultiProvider
     */
    public function testContainsAllWorks($expectedCount, $elements) {
        $this->list->addAll($elements);

        //Contains the original
        $this->assertTrue($this->list->containsAll($elements));

        //Add a new random element
        $this->list->add($this->getFaker()->word);

        $this->assertTrue($this->list->containsAll($elements));

        $elements[] = $this->getFaker()->word;
        $this->assertFalse($this->list->containsAll($elements));
    }

    /**
     * @dataProvider mixedTypeMultiProvider
     */
    public function testContainsAnyWorks($expectedCount, $elements) {
        $this->list->addAll($elements);
        $randomElement = $this->list->get(rand(0, $expectedCount - 1));

        $test = [];
        foreach(range(0, 4) as $item) {
            if($item == 0) {
                $test[] = $randomElement;

                continue;
            }

            $test[] = $this->getFaker()->word;
        }

        $this->assertTrue($this->list->containsAny($test));
        $this->assertFalse($this->list->containsAny(['nonExistElement', 37]));
    }

    /**
     * @dataProvider mixedTypeMultiProvider
     */
    public function testIndexOfWorks($expectedCount, $elements) {
        $this->list->addAll($elements);
        $randValue = rand(0, $expectedCount - 1);
        $randomElement = $this->list->get($randValue);

        $this->assertEquals($randValue, $this->list->indexOf($randomElement));
    }

    public function testEqualsWorks() {
        $listOne = new ArrayList(['test', 2e6, FALSE]);

        //False when size not equals
        $this->assertFalse($this->list->equals($listOne));

        //False wit same size
        $this->list->addAll(['hello', (new \stdClass()), function() {}]);
        $this->assertFalse($this->list->equals($listOne));

        //Equals
        $this->list->clear();
        $this->list->addAll($listOne->toArray());
        $this->assertTrue($this->list->equals($listOne));
    }

    /**
     * @dataProvider mixedTypeMultiProvider
     */
    public function testRemoveAllWorks($expectedCount, $elements) {
        $this->list->addAll($elements);
        $randomValue = rand(0, $expectedCount - 1);

        $remove = [];
        foreach(range(0, $randomValue) as $random) {
            $remove[] = $this->list->get($random);
        }

        $expectedCount = $expectedCount - count($remove);

        $this->list->removeAll($remove);
        $this->assertCount($expectedCount, $this->list);
    }

    /**
     * @dataProvider mixedTypeMultiProvider
     */
    public function testRetainAll($expectedCount, $elements) {
        $this->list->addAll($elements);
        $randomValue = rand(0, $expectedCount - 1);

        $retain = [];
        foreach(range(0, $randomValue) as $random) {
            $retain[] = $this->list->get($random);
        }

        $expectedCount = count($retain);

        $this->list->retainAll($retain);

        $this->assertCount($expectedCount, $this->list);
        $this->assertEquals($retain, $this->list->toArray());
    }

    public function testSubListWorks() {
        $this->list->addAll(['test', 2e9, ['array'], PHP_INT_MAX, FALSE, function() {}, (new \stdClass())]);

        $subList = $this->list->subList(1, 2);

        $this->assertFalse($this->list === $subList);
        $this->assertCount(2, $subList);
        $this->assertArraySubset([2e9, ['array']], $subList->toArray());
    }


}
