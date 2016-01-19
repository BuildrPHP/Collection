<?php namespace BuildR\Collection\Tests;

use BuildR\Collection\Exception\CollectionException;
use BuildR\Collection\Set\Set;
use BuildR\TestTools\BuildR_TestCase;

class SetTest extends BuildR_TestCase {

    /**
     * @type \BuildR\Collection\Set\Set
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
            [2, ['test', 'data', 'data']],
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
            $this->assertArraySubset($this->set->toArray(), $testData);
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
        $this->assertFalse($this->set->containsAny(['nonExistElement', NULL, 99]));
    }

    /**
     * @dataProvider validTypeDataProvider
     */
    public function testCollectionEqualityWithSameContent($itemCount, $testData) {
        $c1 = new Set($testData);
        $c2 = new Set($testData);

        $this->assertTrue($c1->equals($c2));
    }

    public function testEqualsReturnFalseWhenTheCollectionsNotHaveSameSize() {
        $c1 = new Set(['test']);
        $c2 = new Set(['test', 99]);

        $this->assertFalse($c1->equals($c2));
    }

    public function testIsEmpty() {
        $this->assertTrue($this->set->isEmpty());

        $this->set->add('test');

        $this->assertFalse($this->set->isEmpty());
    }

    public function testItRemovesElementsProperly() {
        $this->set->add('test');

        //Removes non-existing element returns false
        $this->assertFalse($this->set->remove('nonExistingElement'));

        //Returns true when set is modified
        $this->assertTrue($this->set->remove('test'));
        $this->assertCount(0, $this->set);
    }

    public function testIsRemoveMoreElementWithRemoveAll() {
        $this->set->addAll(['many', 'test', 'data', 'actually', 5]);

        //Return FALSE when set is not modified
        $this->assertFalse($this->set->removeAll(['non', 'existing', 'elements']));

        //Return TRUE when at least on element will be removed
        $this->assertTrue($this->set->removeAll(['many', 'non', 'existing', 'element']));
    }

    public function testSetRetainOnlyTheGivenElements() {
        $this->set->addAll(['many', 'test', 'data', 'actually', 5]);

        //Returns FALSE when the set is not modified
        $this->assertFalse($this->set->retainAll(['many', 'test', 'data', 'actually', 5]));

        $this->assertTrue($this->set->retainAll(['many', 5]));
        $this->assertCount(2, $this->set);
    }

    public function testSetsCanUsedInIterators() {
        $this->set->addAll(['many', 'test', 'data', 'actually', 5]);

        $this->assertTrue($this->set instanceof \Traversable);
    }

    public function testIsConvertCollectionsToArrayProperly() {
        $setContent = ['test', 256, .84];
        $collection = new Set($setContent);

        $options = ['methodParams' => [$collection]];
        $result = $this->invokeMethod(Set::class, 'collectionToArray', NULL, $options);

        $this->assertTrue(is_array($result));
        $this->assertCount(3, $result);
        $this->assertEquals($setContent, $result);

    }

}
