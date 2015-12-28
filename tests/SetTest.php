<?php namespace BuildR\Collection\Tests;

use BuildR\Collection\Exception\CollectionException;
use BuildR\Collection\Set;

class SetTest extends \PHPUnit_Framework_TestCase {

    /**
     * @type \BuildR\Collection\Set
     */
    protected $set;

    public function setUp() {
        $this->set = new Set();

        parent::setUp();
    }

    public function tearDown() {
        unset($this->set);

        parent::tearDown();
    }

    public function nonScalarTypeDataProvider() {
        return [
            //Array
            [['test'], CollectionException::class, 'This collection only store scalar types! array given!'],

            //Object
            [new \stdClass(), CollectionException::class, 'This collection only store scalar types! object given!'],

            //Resource
            [fopen('php://input', 'r'), CollectionException::class, 'This collection only store scalar types! resource given!'],

            //NULL
            [NULL, CollectionException::class, 'This collection only store scalar types! NULL given!'],
        ];
    }

    /**
     * Each set provides a valid chunk of data and the given data chunk length
     * Each chunk only contains one valid type of data
     */
    public function validTypeDataProvider() {
        return [
            [2, [TRUE, FALSE]],
            [5, [2, 154, 17854762, -99, PHP_INT_MAX]],
            [3 ,[17e10, .84, 0.002]],
            [3, ['test', 'asd', "test*Value"]],
        ];
    }

    /**
     * @dataProvider nonScalarTypeDataProvider
     */
    public function testIsThrowExceptionWhenTryToAddNonScalarTypes($value, $exClass, $exMessage) {
        $this->setExpectedException($exClass, $exMessage);

        $this->set->add($value);
    }

    /**
     * @dataProvider validTypeDataProvider
     */
    public function testItStoresValuesCorrectly($length, $testData) {
        $this->set->addAll($testData);

        $this->assertCount($length, $this->set);
        $this->assertEquals($length, $this->set->size());
        $this->assertTrue($this->set->containsAll($testData));

        foreach($testData as $item) {
            $this->assertTrue($this->set->contains($item));
            $this->assertEquals($testData, $this->set->__toArray());
        }
    }

    public function testItClearsSetProperly() {
        $testData = ['test', 'data', 2];

        $this->set->addAll($testData);

        $this->assertCount(3, $this->set);
        $this->set->clear();

        $this->assertFalse($this->set->containsAny($testData));
        $this->assertCount(0, $this->set);
    }

    /**
     * @dataProvider validTypeDataProvider
     */
    public function testContainsMethods($itemCount, $testData) {
        $this->set->addAll($testData);
        $randomElementIndex = rand(0, $itemCount - 1);
        $randomElement = $testData[$randomElementIndex];
        $anyTestData = ['nonExistElement', $randomElement];

        $this->assertTrue($this->set->containsAll($testData));
        $this->assertFalse($this->set->containsAll($anyTestData));

        $this->assertTrue($this->set->containsAny($anyTestData));
        $this->assertFalse($this->set->containsAny(['nonExistElement', NULL, TRUE]));

    }

}