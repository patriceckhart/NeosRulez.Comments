<?php
namespace NeosRulez\Comments\Controller;

/*
 * This file is part of the NeosRulez.Comments package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use NeosRulez\Comments\Domain\Model\Comment;

class CommentController extends ActionController
{

    /**
     * @var array
     */
    protected $settings;

    /**
     * @param array $settings
     * @return void
     */
    public function injectSettings(array $settings) {
        $this->settings = $settings;
    }

    /**
     * @Flow\Inject
     * @var \NeosRulez\Comments\Domain\Repository\CommentRepository
     */
    protected $commentRepository;

    /**
     * @return void
     */
    public function commentsAction() {
        $documentnode = $this->request->getInternalArgument('__documentNode');
        $this->view->assign('documentnode', $documentnode);
        $comments = $this->commentRepository->getComments($documentnode);
        $this->view->assign('comments', $comments);
        $this->view->assign('gravatarImgSize', $this->settings['gravatarImgSize']);
        $this->view->assign('url', (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        $this->view->assign('adminName', $this->settings['adminName']);
        $this->view->assign('adminMailmd5', md5($this->settings['adminMail']));
        $this->view->assign('usingGravatar', $this->settings['usingGravatar']);
    }

    /**
     * @param \NeosRulez\Comments\Domain\Model\Comment $newComment
     * @param string $backlink
     * @return void
     */
    public function createAction(Comment $newComment, $backlink) {
        $newComment->setDeleted(0);
        $email = $newComment->getEmail();
        $newComment->setEmailmd5(md5($email));
        $this->commentRepository->add($newComment);
        $sendMails = $this->settings['sendMails'];
        $checkbacklink = strpos($backlink, '?');
        if ($checkbacklink === false) {
            $backlink = $backlink;
        } else {
            $backlink = strstr($backlink, '?', true);
        }
        $identifier =  $this->persistenceManager->getIdentifierByObject($newComment);
        if($sendMails==true) {
            $adminMail = $this->settings['adminMail'];
            $mailSubject = $this->settings['mailSubject'];
            $name = $newComment->getName();
            $email = $newComment->getEmail();
            $comment = $newComment->getComment();
            $date = date('d.m.Y, H:i', time());
            $mailbody = '<p><strong>'.$name.', '.$date.':</strong></p><p>'.$comment.'</p>'.'<p>'.$backlink.'</p>';
            $confirmation = new \Neos\SwiftMailer\Message();
            $confirmation->setFrom(array($email))
                ->setTo(array($adminMail))
                ->setSubject($mailSubject)
                ->setBody($mailbody, 'text/html')
                ->send();
        }
        $this->redirectToUri($backlink.'#comment'.$identifier);
    }

    /**
     * @return void
     */
    public function indexAction() {
        $this->view->assign('comments', $this->commentRepository->getAllComments());
    }

    /**
     * @param \NeosRulez\Comments\Domain\Model\Comment $comment
     * @return void
     */
    public function answerAction(Comment $comment)
    {
        $this->view->assign('comment', $comment);
    }

    /**
     * @param \NeosRulez\Comments\Domain\Model\Comment $comment
     * @return void
     */
    public function updateAction(Comment $comment)
    {
        $date = new \DateTime("now");
        $comment->setAnswercreated($date);
        $this->commentRepository->update($comment);
        $this->redirect('index');
    }

    /**
     * @param \NeosRulez\Comments\Domain\Model\Comment $comment
     * @return void
     */
    public function deleteAction(Comment $comment)
    {
        $comment->setDeleted("1");
        $this->commentRepository->update($comment);
        $this->redirect('index');
    }

    /**
     * @param \NeosRulez\Comments\Domain\Model\Comment $comment
     * @return void
     */
    public function activateAction(Comment $comment)
    {
        $comment->setDeleted("0");
        $this->commentRepository->update($comment);
        $this->persistenceManager->persistAll();
        $this->redirect('index');
    }


}
