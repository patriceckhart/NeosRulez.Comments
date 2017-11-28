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
        $result = $query->matching($query->equals('node', $node))->execute();
        return $result;
    }

}
