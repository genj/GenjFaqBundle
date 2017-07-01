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

        // if we have a slug - there was a search before
        if ($slug) {
            /** @var \Genj\FaqBundle\Entity\Search $search */
            $search = $this->getSearchRepository()->findOneBySlug($slug);
        }

        // just without slug the query is interesting
        elseif ($query != '') {

            // is my query a plain number?
            // than redirect there right away
            /** @var \Genj\FaqBundle\Entity\Question $question */
            $question = $this->getQuestionRepository()->findOneById($query);

            if ($question) {
                return $this->redirectToRoute($question->getRouteName(), $question->getRouteParameters());
            }

            /** @var \Genj\FaqBundle\Entity\Search $search */
            $search = $this->getSearchRepository()->findOneByHeadline($query);
        }

        // and if we don't have anything yet - we start from scratch
        if (!$search and $query != '') {
            /** @var \Genj\FaqBundle\Entity\Search $search */
            $className = $this->getSearchRepository()->getClassName();
            $search    = new $className();
            $search->setHeadline($query);
        }

        // increase search count
        if ($search) {
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
     * @return \Genj\FaqBundle\Entity\QuestionRepository
     */
    protected function getQuestionRepository()
    {
        return $this->container->get('genj_faq.entity.question_repository');
    }

    /**
     * @return \Genj\FaqBundle\Entity\SearchRepository
     */
    protected function getSearchRepository()
    {
        return $this->container->get('genj_faq.entity.search_repository');
    }
}