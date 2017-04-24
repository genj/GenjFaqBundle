<?php

namespace Genj\FaqBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
        $question = $this->getQuestionRepository()->retrieveActiveBySlug($slug);

        if (!$question) {
            throw $this->createNotFoundException('question doesnt exists');
        }

        return $this->render(
            'GenjFaqBundle:Question:show.html.twig',
            array(
                'question' => $question
            )
        );
    }

    /**
     * list most recent added questions based on createdAt
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
     * @return \Genj\FaqBundle\Entity\QuestionRepository
     */
    protected function getQuestionRepository()
    {
        return $this->container->get('genj_faq.entity.question_repository');
    }
}
