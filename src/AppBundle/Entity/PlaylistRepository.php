<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PlaylistRepository extends EntityRepository
{
    public function withTracks($id)
    {
        $queryBuilder = $this->createQueryBuilder('p');

        $queryBuilder
            ->innerJoin('AppBundle:Track', 't')
            ->where('p.id = :id')
            ->setParameter('id', $id)
        ;

        $query = $queryBuilder->getQuery();

        $query->useQueryCache(true);
        $query->useResultCache(true, 3600);

        return $query->getSingleResult();
    }
}
