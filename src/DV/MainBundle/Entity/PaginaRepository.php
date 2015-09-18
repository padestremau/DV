<?php

namespace DV\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PaginaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PaginaRepository extends EntityRepository
{
	public function findLatestOne() {
		return $this->createQueryBuilder('p')
					->orderBy('p.ultimaModificacion', 'DESC')
					->setMaxResults(1)
					->getQuery()
					->getResult();
	}
}