<?php

namespace Genj\FaqBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class CategoryController
 *
 * @package Genj\FaqBundle\Controller
 */
class CategoryController extends Controller
{
    /**
     * shows questions within 1 category
     *
     * @param string $slug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($slug)
    {
        $category = $this->getCategoryRepository()->retrieveActiveBySlug($slug);

        if (!$category) {
            throw $this->createNotFoundException('category doesnt exists');
        }

        return $this->render(
            'GenjFaqBundle:Category:show.html.twig',
            array(
                'category' => $category
            )
        );
    }

    /**
     * list all active categories
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listActiveAction()
    {
        $categories = $this->getCategoryRepository()->retrieveActive();

        return $this->render(
            'GenjFaqBundle:Category:list_active.html.twig',
            array(
                'categories' => $categories
            )
        );
    }

    /**
     * @return \Genj\FaqBundle\Entity\CategoryRepository
     */
    protected function getCategoryRepository()
    {
        return $this->container->get('genj_faq.entity.category_repository');
    }
}
