<?php namespace BuildR\Collection\Tests;

use BuildR\Collection\Exception\CollectionException;
use BuildR\Collection\Tests\Fixtures\StrictlyTypedCollectionImpl;
use BuildR\TestTools\BuildR_TestCase;

class StrictlyTypedCollectionTest extends BuildR_TestCase {

    /**
     * @type \BuildR\Collection\Collection\StrictlyTypedCollectionTrait
     */
    private $strictTraitImpl;

    public function setUp() {
        parent::setUp();

        $this->strictTraitImpl = new StrictlyTypedCollectionImpl();
    }

    public function tearDown() {
        parent::tearDown();

        unset($this->strictTraitImpl);
    }

    public function typeCheckerDataProvider() {
        return [
            [
                'test', TRUE, NULL, NULL
            ],
            [
                25, FALSE, NULL, 'This element is not has valid type for this collection! (integer)'
            ],
            [
                TRUE, FALSE, 'String value expected!',
                'This element is not has valid type for this collection! (String value expected!)'
            ]
        ];
    }

    public function testIsSetStrictTypingCorrectly() {
        $this->assertFalse($this->strictTraitImpl->isStrict());

        $this->strictTraitImpl->setStrictType(function() {});

        $this->assertTrue($this->strictTraitImpl->isStrict());
    }

    public function testItStoreTypeCheckerFunctionsCorrectly() {
        $check = function($value) { return is_string($value); };
        $this->strictTraitImpl->setStrictType($check, 'Test message!');

        $stored = $this->getPropertyValue(StrictlyTypedCollectionImpl::class, 'typeChecker', $this->strictTraitImpl);
        $this->assertEquals($check, $stored);
    }

    /**
     * @dataProvider typeCheckerDataProvider
     */
    public function testItChecksInputTypesCorrectly($input, $expectedResult, $message, $expectedMessage) {
        $check = function($value) { return is_string($value); };
        $this->strictTraitImpl->setStrictType($check, $message);
        $opt = ['methodParams' => [$input]];

        try {
            $r = $this->invokeMethod(StrictlyTypedCollectionImpl::class, 'doTypeCheck', $this->strictTraitImpl, $opt);
            $this->assertEquals($expectedResult, $r);
        } catch(CollectionException $e) {
            if($expectedMessage !== NULL) {
                $this->assertEquals($expectedMessage, $e->getMessage());
            }
        }
    }

}
