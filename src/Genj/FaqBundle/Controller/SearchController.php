<?php

namespace Genj\FaqBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SearchController
 *
 * @package Genj\FaqBundle\Controller
 */
class SearchController extends Controller
{
    /**
     * shows search results for previous queries
     *
     * @param Request $request
     * @param string  $slug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Request $request, $slug)
    {
        $query  = trim(strtolower(strip_tags($request->get('query', ''))));
        $search = null;

        // if we have a slu g- there was a search
        if ($slug) {
            /** @var Search $search */
            $search = $this->getSearchRepository()->findOneBySlug($slug);
        }

        // just than the query is interesting
        elseif ($query != '') {
            /** @var Search $search */
            $search = $this->getSearchRepository()->findOneByHeadline($query);
        }

        // and if we don't have anything yet - we start from scratch
        if (!$search and $query != '') {
            /** @var Search $search */
            $className = $this->getSearchRepository()->getClassName();
            $search    = new $className();
            $search->setHeadline($query);
        }

        if ($search) {
            // increase search count
            $search->setSearchCount($search->getSearchCount() + 1);

            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            $em->persist($search);
            $em->flush();
        }

        return $this->render(
            'GenjFaqBundle:Search:show.html.twig',
            array(
                'query'  => $query,
                'search' => $search
            )
        );
    }

    /**
     * list most popular search queries based on searchCount
     *
     * @param int $max
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listMostPopularAction($max = 3)
    {
        $queries = $this->getSearchRepository()->retrieveMostPopular($max);

        return $this->render(
            'GenjFaqBundle:Search:list_most_popular.html.twig',
            array(
                'queries' => $queries,
                'max'     => $max
            )
        );
    }

    /**
     * @return \Genj\FaqBundle\Entity\SearchRepository
     */
    protected function getSearchRepository()
    {
        return $this->container->get('genj_faq.entity.search_repository');
    }
}