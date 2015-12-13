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
class GenjFaqCategoryFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $categoryService = new Category();
        $categoryService->setHeadline('Service');
        $categoryService->setIsActive(true);
        $categoryService->setRank(0);
        $manager->persist($categoryService);
        $manager->flush();

        $this->addReference('category-service', $categoryService);

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}
