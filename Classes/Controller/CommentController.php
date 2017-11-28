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
    }

    /**
     * @param \NeosRulez\Comments\Domain\Model\Comment $newComment
     * @return void
     */
    public function createAction(Comment $newComment) {
        $newComment->setDeleted(0);
        $email = $newComment->getEmail();
        $newComment->setEmailmd5(md5($email));
        $this->commentRepository->add($newComment);
        //$this->addFlashMessage('Kommentar gespeichert.');
        $backlink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $this->redirectToUri($backlink);
    }

}
