<?php
namespace Medidor\Repository;

use Doctrine\ORM\EntityRepository;

class ReciboRepository extends EntityRepository
{
    public function getLast($medidor)
    {
        $querybuilder = $this->createQueryBuilder('recibo');
        $query = $querybuilder->select('recibo')
                    ->where('recibo.medidor = :medidor')
                    ->orderBy('recibo.periodoHasta', 'DESC')
                    ->setMaxResults(1)
                    ->getQuery();
        $query->setParameter('medidor', $medidor);

        return $query->getOneOrNullResult();
    }
}