<?php

namespace Medidor\Repository;

use Doctrine\ORM\EntityRepository;

class LecturaRepository extends EntityRepository
{
    public function getLast($medidor)
    {
        $querybuilder = $this->createQueryBuilder('lectura');
        $query = $querybuilder->select('lectura')
                    ->where('lectura.medidor = :medidor')
                    ->orderBy('lectura.fecha', 'DESC')
                    ->setMaxResults(1)
                    ->getQuery();
        $query->setParameter('medidor', $medidor);
        
        return $query->getResult();
    }
}