<?php
namespace NeosRulez\Comments\Domain\Model;

/*
 * This file is part of the NeosRulez.Comments package.
 */

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Comment
{

    /**
     * @var string
     */
    protected $node;

    /**
     * @return string
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * @param string $node
     * @return void
     */
    public function setNode($node)
    {
        $this->node = $node;
    }

    /**
     * @var string
     */
    protected $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @var string
     */
    protected $email;

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @var string
     */
    protected $emailmd5;

    /**
     * @return string
     */
    public function getEmailmd5()
    {
        return $this->emailmd5;
    }

    /**
     * @param string $emailmd5
     * @return void
     */
    public function setEmailmd5($emailmd5)
    {
        $this->emailmd5 = $emailmd5;
    }

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $comment;

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @return void
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @var string
     * @ORM\Column(nullable=true)
     * @ORM\Column(type="text")
     */
    protected $answer;

    /**
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param string $answer
     * @return void
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
    }

    /**
     * @var integer
     */
    protected $deleted;

    /**
     * @return integer
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param integer $deleted
     * @return void
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @var \DateTime
     */
    protected $created;


    public function __construct() {
        $this->created = new \DateTime();
    }

    /**
     * @return string
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * @ORM\Column(nullable=true)
     * @var \DateTime
     */
    protected $answercreated;

    /**
     * @return \DateTime
     */
    public function getAnswercreated()
    {
        return $this->answercreated;
    }

    /**
     * @param \DateTime $answercreated
     * @return void
     */
    public function setAnswercreated($answercreated)
    {
        $this->answercreated = $answercreated;
    }

}
