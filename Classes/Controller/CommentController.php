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

        if($sendMails==true) {
            $adminMail = $this->settings['adminMail'];
            $name = $newComment->getName();
            $email = $newComment->getEmail();
            $comment = $newComment->getComment();
            $date = date('d.m.Y', time());

            $mailsubject = 'Kommentar';
            $mailbody = '<p><strong>'.$name.' schrieb am '.$date.':</strong></p><p>'.$comment.'</p>'.'<p>'.$backlink.'</p>';

            $confirmation = new \Neos\SwiftMailer\Message();
            $confirmation->setFrom(array($email))
                ->setTo(array($adminMail))
                ->setSubject($mailsubject)
                ->setBody($mailbody, 'text/html')
                ->send();
        }

        $this->redirectToUri($backlink);
    }

    /**
     * @return void
     */
    public function indexAction() {
        $this->view->assign('comments', $this->commentRepository->findAll());
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
        $this->commentRepository->update($comment);
        $this->redirect('index');
    }


}
