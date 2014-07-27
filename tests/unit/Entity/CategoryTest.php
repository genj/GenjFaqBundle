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

    /**
     * @covers Genj\FaqBundle\Entity\Category::getRouteName
     */
    public function testGetRouteName()
    {
        $category  = new Category();
        $routeName = $category->getRouteName();

        $this->assertSame('genj_faq', $routeName);
    }

    /**
     * @covers Genj\FaqBundle\Entity\Category::getRouteParameters
     */
    public function testGetRouteParameters()
    {
        $category = new Category();
        $category->setSlug('my-foo-slug');

        $routeParameters = $category->getRouteParameters();

        $this->assertSame(array('categorySlug' => 'my-foo-slug'), $routeParameters);
    }
}