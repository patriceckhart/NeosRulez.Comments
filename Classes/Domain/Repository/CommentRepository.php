<?php
namespace NeosRulez\Comments\Domain\Repository;

/*
 * This file is part of the NeosRulez.Comments package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\Repository;

/**
 * @Flow\Scope("singleton")
 */
class CommentRepository extends Repository
{

    /**
     * @param string $node
     * @return void
     */
    public function getComments($node) {
        $comments = '\NeosRulez\Comments\Domain\Model\Comment';
        $query = $this->persistenceManager->createQueryForType($comments);
        $result = $query->matching($query->equals('node', $node))->setOrderings(array('created' => \Neos\Flow\Persistence\QueryInterface::ORDER_ASCENDING))->execute();
        return $result;
    }

    /**
     * @return void
     */
    public function getAllComments() {
        $comments = '\NeosRulez\Comments\Domain\Model\Comment';
        $query = $this->persistenceManager->createQueryForType($comments);
        $result = $query->setOrderings(array('created' => \Neos\Flow\Persistence\QueryInterface::ORDER_DESCENDING))->execute();
        return $result;
    }

}
