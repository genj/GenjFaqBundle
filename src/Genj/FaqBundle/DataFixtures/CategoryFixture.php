<?php

namespace Genj\FaqBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Genj\FaqBundle\Entity\Category;


/**
 * Class CategoryFixture
 *
 * @package Genj\FaqBundle\Tests\Fixtures
 */
class CategoryFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setHeadline('Subscription');
        $category->setIsActive(true);
        $category->setRank(0);
        $manager->persist($category);

        $this->addReference('category-subscription', $category);


        $category = new Category();
        $category->setHeadline('Website');
        $category->setIsActive(true);
        $category->setRank(1);
        $manager->persist($category);

        $this->addReference('category-website', $category);


        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}
