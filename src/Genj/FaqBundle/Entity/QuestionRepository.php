<?php

namespace Genj\FaqBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class QuestionRepository
 *
 * @package Genj\FaqBundle\Entity
 */
class QuestionRepository extends EntityRepository
{
    /**
     * @param string $categorySlug
     *
     * @return Question|null
     */
    public function retrieveFirstByCategorySlug($categorySlug)
    {
        $query = $this->createQueryBuilder('q')
            ->join('q.category', 'c')
            ->where('c.slug = :categorySlug')
            ->orderBy('q.rank', 'ASC')
            ->setMaxResults(1)
            ->getQuery();

        $query->setParameter('categorySlug', $categorySlug);

        return $query->getOneOrNullResult();
    }

    /**
     * @param string $slug
     *
     * @return Question|null
     */
    public function retrieveActiveBySlug($slug)
    {
        $query = $this->createQueryBuilder('q')
            ->join('q.category', 'c')
            ->where('q.slug = :slug')
            ->setMaxResults(1)
            ->getQuery();

        $query->setParameter('slug', $slug);

        return $query->getOneOrNullResult();
    }

    /**
     * @param int $max
     *
     * @return DoctrineCollection|null
     */
    public function retrieveMostRecent($max)
    {
        $query = $this->createQueryBuilder('q')
            ->join('q.category', 'c')
            ->orderBy('q.createdAt', 'ASC')
            ->setMaxResults($max)
            ->getQuery();

        return $query->getResult();
    }
}