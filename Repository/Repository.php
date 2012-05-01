<?php
namespace TJM\Bundle\BaseBundle\Repository;

use Doctrine\ORM\EntityRepository;

class Repository extends EntityRepository{
	public function getCount($where = null) {
		$qb = $this->_em->createQueryBuilder();
		$query = $qb->select("COUNT(e)")->from($this->getEntityName(), "e");
		if($where){
			$query->where($where);
		}
		$result = $query->getQuery()->getResult();
		return (int) $result[0][1];
	}
}

