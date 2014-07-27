<?php

namespace Genj\FaqBundle\Entity;

/**
 * Class QuestionTest
 *
 * @package Genj\FaqBundle\Tests\Entity
 */
class QuestionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return void
     */
    public function testToString()
    {
        $question = new Question();
        $question->setHeadline('John Doe');

        $questionToString = (string) $question;

        $this->assertEquals('John Doe', $questionToString);
    }
}