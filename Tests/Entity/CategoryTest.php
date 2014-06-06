<?php

namespace Genj\FaqBundle\Tests\Entity;

use Genj\FaqBundle\Entity\Category;

/**
 * Class CategoryTest
 *
 * @package Genj\FaqBundle\Tests\Entity
 */
class CategoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return void
     */
    public function testToString()
    {
        $category = new Category();
        $category->setHeadline('John Doe');

        $categoryToString = (string) $category;

        $this->assertEquals('John Doe', $categoryToString);
    }
}
