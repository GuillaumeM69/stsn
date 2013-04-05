<?php

namespace Security\Entity;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection as ReflectionHydrator;

class UserTable extends TableGateway
{
    protected $tableName  = 'stsn_users';
    protected $idCol = 'id';
    protected $entityPrototype = null;
    protected $hydrator = null;

    public function __construct($adapter)
    {
        parent::__construct(
            $this->tableName,
            $adapter
        );

        $this->entityPrototype = new User();
        // hydrator that uses the properties of the class
        $this->hydrator = new ReflectionHydrator();

    }
    /* a function that converts array data into an object
     */
    public function hydrate($data)
    {
        return $this->hydrator->hydrate($data
            ,new $this->entityPrototype()
        );
    }
    /* Return here an HydratingResultSet */    
    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet ;
    }

    public function get($id)
    {
        return $this->hydrator->hydrate(
            $this->select(array('id' => $id))->current()->getArrayCopy(),
            new $this->entityPrototype()
        );
    }

    public function save($entity)
    {
        return parent::insert($this->hydrator->extract($entity));
    }

    public function delete($id)
    {
        $this->delete(array('id' => $id));
    }
}
