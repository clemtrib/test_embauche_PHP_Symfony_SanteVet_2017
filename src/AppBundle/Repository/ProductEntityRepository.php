<?php

namespace AppBundle\Repository;

/**
 * ProductEntityRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductEntityRepository extends \Doctrine\ORM\EntityRepository
{
    
    public function findAllOrderBy($orderby, $name, $min, $max) {
        $dql1 = <<<DQL
            SELECT p 
            FROM AppBundle:ProductEntity p
            WHERE p.{$orderby} IS NOT NULL
DQL;
        $dql2 = <<<DQL
            SELECT p 
            FROM AppBundle:ProductEntity p
            WHERE p.{$orderby} IS NULL
DQL;
        //
        $dql1 .= $name ? " AND p.label LIKE '%{$name}%' " : '';
        $dql1 .= $min ? " AND p.price >= {$min} " : '';
        $dql1 .= $max ? " AND p.price <= {$max} " : '';
        $dql1 .= " ORDER BY p.{$orderby}";
        
        //
        $dql2 .= $name ? " AND p.label LIKE '%{$name}%' " : '';
        $dql2 .= " ORDER BY p.{$orderby}";
        
        //
        $wp1 = $this
            ->getEntityManager()
            ->createQuery($dql1)
            ->getResult();
        
        //
        $wp2 = $this
            ->getEntityManager()
            ->createQuery($dql2)
            ->getResult();
        
        return array_merge(
            $this
            ->getEntityManager()
            ->createQuery($dql1)
            ->getResult(),
            $this
            ->getEntityManager()
            ->createQuery($dql2)
            ->getResult()
        );
    }
    
}
