<?php

namespace DEPI\ProyectosProductosBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ProyectosProductosRepository extends EntityRepository
{
	public function findProyectosProductos()
	{
		$em = $this->getEntityManager();

		$dql = $em->createQueryBuilder();
 
		$dql->select('projprod.id, projprod.cantidad, projprod.observaciones', 
			         'productos.meta', 
			         'proyectos.nombreCorto')
		    ->from('ProyectosProductosBundle:ProyectosProductos', 'projprod')
		    ->Join('projprod.productoAcademico', 'productos')
		    ->Join('projprod.proyecto', 'proyectos');

		return $dql->getQuery()->getResult();
	}
}