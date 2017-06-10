<?php

namespace Genj\FaqBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class QuestionController
 *
 * @package Genj\FaqBundle\Controller
 */
class QuestionController extends Controller
{
    /**
     * shows question if active
     *
     * @param string $slug
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($slug)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        $question        = $this->getQuestionRepository()->findOneBySlug($slug);

        if (!$question || (!$question->isPublic() && !$securityContext->isGranted('ROLE_EDITOR'))) {
            throw $this->createNotFoundException('question not found');
        }

        return $this->render(
            'GenjFaqBundle:Question:show.html.twig',
            array(
                'question' => $question
            )
        );
    }

    /**
     * list most recent added questions based on publishAt
     *
     * @param int $max
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listMostRecentAction($max = 3)
    {
        $questions = $this->getQuestionRepository()->retrieveMostRecent($max);

        return $this->render(
            'GenjFaqBundle:Question:list_most_recent.html.twig',
            array(
                'questions' => $questions,
                'max'       => $max
            )
        );
    }

    /**
     * list questions which fitting the query
     *
     * @param string $query
     * @param int    $max
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listByQueryAction($query, $max = 30)
    {
        $questions = $this->getQuestionRepository()->retrieveByQuery($query, $max);

        return $this->render(
            'GenjFaqBundle:Question:list_by_query.html.twig',
            array(
                'questions' => $questions,
                'max'       => $max
            )
        );
    }

    /**
     * @param int       $id
     * @param \stdClass $object
     * @param string    $style
     * @param string    $source
     * @param string    $headline
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function teaserByIdOrObjectAction($id = null, $object = null, $style = null, $source = null, $headline = null)
    {
        $question = $object;

        if ($id !== null) {
            $question = $this->getQuestionRepository()->findOneById($id);
        }

        return $this->render(
            'GenjFaqBundle:Question:teaser_by_id_or_object.html.twig', array(
                'question' => $question,
                'style'    => $style,
                'source'   => $source,
                'headline' => $headline
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
}
