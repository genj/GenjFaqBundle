<?php

namespace Genj\FaqBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class FaqController
 *
 * @package Genj\FaqBundle\Controller
 */
class FaqController extends Controller
{
    /**
     * Default index. Shows one category/question at a time. If you want to just show everything at once, use the
     * indexWithoutCollapse action instead.
     *
     * @param string $categorySlug
     * @param string $questionSlug
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($categorySlug, $questionSlug)
    {
        if (!$categorySlug || !$questionSlug) {
            $redirect = $this->generateRedirectToDefaultSelection($categorySlug, $questionSlug);
            if ($redirect) {
                return $redirect;
            }
        }

        // Otherwise get the selected category and/or question as usual
        $questions        = array();
        $categories       = $this->getCategoryRepository()->retrieveActive();
        $selectedCategory = $this->getSelectedCategory($categorySlug);
        $selectedQuestion = $this->getSelectedQuestion($questionSlug);

        if ($selectedCategory) {
            $questions = $selectedCategory->getSortedQuestions();
        }

        // Throw 404 if there is no category in the database
        if (!$categories) {
            throw $this->createNotFoundException('You need at least 1 active faq category in the database');
        }

        return $this->render(
            'GenjFaqBundle:Faq:index.html.twig',
            array(
                'categories'       => $categories,
                'questions'        => $questions,
                'selectedCategory' => $selectedCategory,
                'selectedQuestion' => $selectedQuestion,
                'categorySlug'     => $categorySlug,
                'questionSlug'     => $questionSlug
            )
        );
    }

    /**
     * Open first category or question if none was selected so far.
     *
     * @param string $categorySlug
     * @param string $questionSlug
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function generateRedirectToDefaultSelection($categorySlug, $questionSlug)
    {
        $doRedirect = false;
        $config     = $this->container->getParameter('genj_faq');

        if (!$categorySlug && $config['select_first_category_by_default']) {
            $firstCategory = $this->getCategoryRepository()->retrieveFirst();
            if ($firstCategory instanceof \Genj\FaqBundle\Entity\Category) {
                $categorySlug = $firstCategory->getSlug();
                $doRedirect   = true;
            } else {
                throw $this->createNotFoundException('Tried to open the first faq category by default, but there was none.');
            }
        }

        if (!$questionSlug && $config['select_first_question_by_default']) {
            $firstQuestion = $this->getQuestionRepository()->retrieveFirstByCategorySlug($categorySlug);
            if ($firstQuestion instanceof \Genj\FaqBundle\Entity\Question) {
                $questionSlug = $firstQuestion->getSlug();
                $doRedirect   = true;
            } else {
                throw $this->createNotFoundException('Tried to open the first faq question by default, but there was none.');
            }
        }

        if ($doRedirect) {
            return $this->redirect(
                $this->generateUrl('genj_faq_faq_index', array('categorySlug' => $categorySlug, 'questionSlug' => $questionSlug), true)
            );
        }

        return false;
    }

    /**
     * @param string $questionSlug
     *
     * @return \Genj\FaqBundle\Entity\Question
     */
    protected function getSelectedQuestion($questionSlug = null)
    {
        $selectedQuestion = null;

        if ($questionSlug !== null) {
            $selectedQuestion = $this->getQuestionRepository()->findOneBySlug($questionSlug);
        }

        return $selectedQuestion;
    }

    /**
     * @param string $categorySlug
     *
     * @return \Genj\FaqBundle\Entity\Category
     */
    protected function getSelectedCategory($categorySlug = null)
    {
        $selectedCategory = null;

        if ($categorySlug !== null) {
            $selectedCategory = $this->getCategoryRepository()->findOneBy(array('isActive' => true, 'slug' => $categorySlug));
        }

        return $selectedCategory;
    }

    /**
     * @return \Genj\FaqBundle\Entity\QuestionRepository
     */
    protected function getQuestionRepository()
    {
        return $this->container->get('genj_faq.entity.question_repository');
    }

    /**
     * @return \Genj\FaqBundle\Entity\CategoryRepository
     */
    protected function getCategoryRepository()
    {
        return $this->container->get('genj_faq.entity.category_repository');
    }
}
