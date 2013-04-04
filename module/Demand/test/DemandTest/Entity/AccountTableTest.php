<?php
namespace SecurityTest\Entity;

use Security\Entity\User;
use Security\Entity\UserTable;
use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;

class UserTableTest extends PHPUnit_Framework_TestCase
{
    public function testFetchAllReturnsAllUsers()
    {
        $resultSet        = new ResultSet();
        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway',
            array('select'), array(), '', false);
        $mockTableGateway->expects($this->once())
            ->method('select')
            ->with()
            ->will($this->returnValue($resultSet));

        $userTable = new UserTable($mockTableGateway);

        $this->assertSame($resultSet, $userTable->fetchAll());
    }
    public function testCanRetrieveAnUserByItsId()
    {
        $user = new User();
        $user->exchangeArray(array('id' => 1,
                       'username'     => 'username',
                       'password'     => 'password',
                       'email'     => 'email',
                       'firstname'     => 'firstname',
                       'lastname'     => 'lastname',
                       'login_type'  => 'Software Engineer'));

        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new User());
        $resultSet->initialize(array($user));

        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
        $mockTableGateway->expects($this->once())
            ->method('select')
            ->with(array('id' => 1))
            ->will($this->returnValue($resultSet));

        $userTable = new UserTable($mockTableGateway);

        $this->assertSame($user, $userTable->get(1));
    }

    public function testCanDeleteAnUserByItsId()
    {
        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('delete'), array(), '', false);
        $mockTableGateway->expects($this->once())
            ->method('delete')
            ->with(array('id' => 1));

        $userTable = new UserTable($mockTableGateway);
        $userTable->delete(1);
    }

    public function testSaveUserWillInsertNewUsersIfTheyDontAlreadyHaveAnId()
    {

        $data  = array(
                       'username'     => 'username',
                       'password'     => 'password',
                       'email'     => 'email',
                       'firstname'     => 'firstname',
                       'lastname'     => 'lastname',
                       'login_type'  => 'Software Engineer');

        $user     = new User();
        $user->exchangeArray($data);

        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('insert'), array(), '', false);
        $mockTableGateway->expects($this->once())
            ->method('insert')
            ->with($data);

        $userTable = new UserTable($mockTableGateway);
        $userTable->save($user);
    }

    public function testSaveUserWillUpdateExistingUsersIfTheyAlreadyHaveAnId()
    {
        $data  = array('id' => 1,
                       'username'     => 'username',
                       'password'     => 'password',
                       'email'     => 'email',
                       'firstname'     => 'firstname',
                       'lastname'     => 'lastname',
                       'login_type'  => 'Software Engineer');

        $updateData  = array(
                       'username'     => 'username',
                       'password'     => 'password',
                       'email'     => 'email',
                       'firstname'     => 'firstname',
                       'lastname'     => 'lastname',
                       'login_type'  => 'Software Engineer');

        $user     = new User();
        $user->exchangeArray($data);

        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new User());
        $resultSet->initialize(array($user));

        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway',
            array('select', 'update'), array(), '', false);
        $mockTableGateway->expects($this->once())
            ->method('select')
            ->with(array('id' => 1))
            ->will($this->returnValue($resultSet));
        $mockTableGateway->expects($this->once())
            ->method('update')
            ->with($updateData,
                array('id' => 1));

        $userTable = new UserTable($mockTableGateway);
        $userTable->save($user);
    }

    public function testExceptionIsThrownWhenGettingNonexistentUser()
    {
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new User());
        $resultSet->initialize(array());

        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
        $mockTableGateway->expects($this->once())
            ->method('select')
            ->with(array('id' => 1))
            ->will($this->returnValue($resultSet));

        $userTable = new UserTable($mockTableGateway);

        try
        {
            $userTable->get(1);
        }
        catch (\Exception $e)
        {
            $this->assertSame('Could not find row 1', $e->getMessage());
            return;
        }

        $this->fail('Expected exception was not thrown');
    }

}

