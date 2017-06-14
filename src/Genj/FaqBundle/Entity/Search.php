<?php

namespace Genj\FaqBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Search
 *
 * @ORM\MappedSuperclass
 * @ORM\Entity(repositoryClass="Genj\FaqBundle\Entity\SearchRepository")
 * @ORM\Table(
 *     name="genj_faq_search",
 *     indexes={@ORM\Index(name="search_count_idx", columns={"search_count"})}
 * )
 *
 * @package Genj\FaqBundle\Entity
 */
class Search
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $headline;

    /**
     * @ORM\Column(type="integer")
     */
    protected $searchCount;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * @Gedmo\Slug(fields={"headline"}, updatable=false)
     * @ORM\Column(type="string", length=100)
     */
    protected $slug;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set headline
     *
     * @param string $headline
     *
     * @return Search
     */
    public function setHeadline($headline)
    {
        $this->headline = $headline;

        return $this;
    }

    /**
     * Get headline
     *
     * @return string
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * Get searchCount
     *
     * @return int
     */
    public function getSearchCount()
    {
        return $this->searchCount;
    }

    /**
     * Set searchCount
     *
     * @param int $searchCount
     *
     * @return Search
     */
    public function setSearchCount($searchCount)
    {
        $this->searchCount = $searchCount;

        return $this;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Search
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Search
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Search
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Returns a string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getHeadline();
    }

    /**
     * Returns the route name for url generation
     *
     * @return string
     */
    public function getRouteName()
    {
        return 'genj_faq_search_show';
    }

    /**
     * Returns the route parameters for url generation
     *
     * @return array
     */
    public function getRouteParameters()
    {
        return array(
            'slug' => $this->getSlug()
        );
    }
}
