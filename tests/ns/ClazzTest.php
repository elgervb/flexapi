<?php
namespace ns;

/**
 *
 * @author eaboxt
 *        
 */
class ClazzTest extends \PHPUnit_Framework_TestCase
{
    private $clazz;
    
    protected function setUp()
    {
        parent::setUp();
        $this->clazz = new Clazz();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }
    
    public function testName(){
        $expected = 'qwerty';
        $this->clazz->setName($expected);
        
        $this->assertEquals($expected, $this->clazz->getName());
    }
    
    public function testTitle(){
        $expected = 'qwerty';
        $this->clazz->setTitle($expected);
    
        $this->assertEquals($expected, $this->clazz->getTitle());
    }
    
}