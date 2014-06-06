<?php

namespace Genj\FaqBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Genj\FaqBundle\Entity\Category;


/**
 * Class LoadCategoryData
 *
 * @package Genj\FaqBundle\DataFixtures\ORM
 */
class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $categorySubscription = new Category();
        $categorySubscription->setHeadline('Subscription');
        $categorySubscription->setIsActive(true);
        $categorySubscription->setRank(0);
        $manager->persist($categorySubscription);
        $manager->flush();

        $this->addReference('category-subscription', $categorySubscription);


        $categoryWebsite = new Category();
        $categoryWebsite->setHeadline('Website');
        $categoryWebsite->setIsActive(true);
        $categoryWebsite->setRank(1);

        $manager->persist($categoryWebsite);
        $manager->flush();

        $this->addReference('category-website', $categoryWebsite);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}
