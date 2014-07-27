<?php

namespace Genj\FaqBundle\Entity;

/**
 * Class CategoryTest
 *
 * @package Genj\FaqBundle\Entity
 */
class CategoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Genj\FaqBundle\Entity\Category::__toString
     */
    public function testToString()
    {
        $category = new Category();
        $category->setHeadline('John Doe');

        $categoryToString = (string) $category;

        $this->assertSame('John Doe', $categoryToString);
    }
}