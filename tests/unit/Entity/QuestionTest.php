<?php

namespace Genj\FaqBundle\Entity;

/**
 * Class QuestionTest
 *
 * @package Genj\FaqBundle\Entity
 */
class QuestionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Genj\FaqBundle\Entity\Question::__toString
     */
    public function testToString()
    {
        $question = new Question();
        $question->setHeadline('John Doe');

        $questionToString = (string) $question;

        $this->assertEquals('John Doe', $questionToString);
    }
}