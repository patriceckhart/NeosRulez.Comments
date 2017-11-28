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

        /*$comments = '\NeosRulez\Comments\Domain\Model\Comment';
        $query = $this->persistenceManager->createQueryForType($comments);
        $result = $query->matching($query->equals('node', $node))->execute();
        $this->view->assign('comments', $result);*/
        
    }

    /**
     * @param \NeosRulez\Comments\Domain\Model\Comment $newComment
     * @return void
     */
    public function createAction(Comment $newComment) {
        $newComment->setDeleted(0);
        $this->commentRepository->add($newComment);
        $this->addFlashMessage('Kommentar gespeichert.');
        $backlink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $this->redirectToUri($backlink);
    }

}
