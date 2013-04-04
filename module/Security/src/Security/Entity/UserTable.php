<?php

namespace Security\Entity;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;

use Zend\Db\ResultSet\ResultSet;

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
        $this->hydrator = new \Zend\Stdlib\Hydrator\Reflection;

    }

    public function hydrate($data)
    {
        return $this->hydrator->hydrate($data
            ,new $this->entityPrototype()
        );
    }
    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
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
