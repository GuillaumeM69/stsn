<?php
namespace SecurityTest\Entity;

use Security\Entity\User;
use Security\Entity\UserTable;
use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection as ReflectionHydrator;
class UserTableTest extends PHPUnit_Framework_TestCase
{
    //
    public function testTable()
    {

        $mockAdapter = $this->getMock('Zend\Db\Adapter\Adapter', array(), array(), '', false);

        $resultSet        = new ResultSet();
        $mockTable = $this->getMock('Security\Entity\UserTable'
            ,array('fetchAll')
            ,array()
            ,''
            ,false
        );

        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway',
            array('select'), array(), '', false);
        $mockTableGateway->expects($this->once())
            ->method('select')
            ->with()
            ->will($this->returnValue($resultSet));

        $mockTable->expects($this->once())
            ->method('fetchAll')
            ->with()
            ->will($this->returnValue($resultSet));
        $this->assertSame($mockTableGateway->select(), $mockTable->fetchAll());
    }

    public function testGetById(){

        $user = new User();
        $data = array('id' => 1,
            'username'     => 'username',
            'password'     => 'password',
            'email'     => 'email',
            'firstname'     => 'firstname',
            'lastname'     => 'lastname',
            'loginType'  => 'Software Engineer');


        $hydrator = new \Zend\Stdlib\Hydrator\Reflection;
        $hydrator->hydrate($data, $user);


        $this->assertEquals('Software Engineer', $user->getLoginType());
    }

    public function testCanRetrieveAnUserByItsId()
    {
        //
        $user = new User();
        $data = array('id' => 1,
            'username'     => 'username',
            'password'     => 'password',
            'email'     => 'email',
            'firstname'     => 'firstname',
            'lastname'     => 'lastname',
            'loginType'  => 'Software Engineer');


        $hydrator = new \Zend\Stdlib\Hydrator\Reflection;
        $hydrator->hydrate($data, $user);

        $mockTable = $this->getMock('Security\Entity\UserTable'
            ,array('get')
            ,array()
            ,''
            ,false
        );
        $mockTable->expects($this->once())
            ->method('get')
            ->with(1)
            ->will($this->returnValue($user));

        $resultSet = new HydratingResultSet(new ReflectionHydrator(), new User());
        $resultSet->initialize(array(new User(), $user));

        
        //$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway',
            //array('select'), array(), '', false);

        //$mockTableGateway->expects($this->once())
            //->method('select')
            //->with(array('id' => 1))
            //->will($this->returnValue($resultSet));

        $mockTable->get(1);

        foreach ($resultSet as $row) {
            print var_export($row, true);
        }

        
        $this->assertSame(2,$resultSet->count() ); 
        
    }

    //public function testCanDeleteAnUserByItsId()
    //{
    //$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('delete'), array(), '', false);
    //$mockTableGateway->expects($this->once())
    //->method('delete')
    //->with(array('id' => 1));

    //$userTable = new UserTable($mockTableGateway);
    //$userTable->delete(1);
    //}

    //public function testSaveUserWillInsertNewUsersIfTheyDontAlreadyHaveAnId()
    //{

    //$data  = array(
    //'username'     => 'username',
    //'password'     => 'password',
    //'email'     => 'email',
    //'firstname'     => 'firstname',
    //'lastname'     => 'lastname',
    //'login_type'  => 'Software Engineer');

    //$user     = new User();
    //$user->exchangeArray($data);

    //$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('insert'), array(), '', false);
    //$mockTableGateway->expects($this->once())
    //->method('insert')
    //->with($data);

    //$userTable = new UserTable($mockTableGateway);
    //$userTable->save($user);
    //}

    //public function testSaveUserWillUpdateExistingUsersIfTheyAlreadyHaveAnId()
    //{
    //$data  = array('id' => 1,
    //'username'     => 'username',
    //'password'     => 'password',
    //'email'     => 'email',
    //'firstname'     => 'firstname',
    //'lastname'     => 'lastname',
    //'login_type'  => 'Software Engineer');

    //$updateData  = array(
    //'username'     => 'username',
    //'password'     => 'password',
    //'email'     => 'email',
    //'firstname'     => 'firstname',
    //'lastname'     => 'lastname',
    //'login_type'  => 'Software Engineer');

    //$user     = new User();
    //$user->exchangeArray($data);

    //$resultSet = new ResultSet();
    //$resultSet->setArrayObjectPrototype(new User());
    //$resultSet->initialize(array($user));

    //$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway',
    //array('select', 'update'), array(), '', false);
    //$mockTableGateway->expects($this->once())
    //->method('select')
    //->with(array('id' => 1))
    //->will($this->returnValue($resultSet));
    //$mockTableGateway->expects($this->once())
    //->method('update')
    //->with($updateData,
    //array('id' => 1));

    //$userTable = new UserTable($mockTableGateway);
    //$userTable->save($user);
    //}

    //public function testExceptionIsThrownWhenGettingNonexistentUser()
    //{
    //$resultSet = new ResultSet();
    //$resultSet->setArrayObjectPrototype(new User());
    //$resultSet->initialize(array());

    //$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
    //$mockTableGateway->expects($this->once())
    //->method('select')
    //->with(array('id' => 1))
    //->will($this->returnValue($resultSet));

    //$userTable = new UserTable($mockTableGateway);

    //try
    //{
    //$userTable->get(1);
    //}
    //catch (\Exception $e)
    //{
    //$this->assertSame('Could not find row 1', $e->getMessage());
    //return;
    //}

    //$this->fail('Expected exception was not thrown');
    //}

}

