<?php
namespace SecurityTest\Entity;

use Security\Entity\User;
use PHPUnit_Framework_TestCase;

class UserTest extends PHPUnit_Framework_TestCase
{
    public function testUserInitialState()
    {
        //$user = new User();

        //$this->assertNull($user->getId(), '"id" should initially be null');
        //$this->assertNull($user->getUsername(), '"username" should initially be null');
        //$this->assertNull($user->getPassword(), '"password" should initially be null');
        //$this->assertNull($user->getEmail(), '"email" should initially be null');
        //$this->assertNull($user->getFirstname(), '"firstname" should initially be null');
        //$this->assertNull($user->getLastname(), '"lastname" should initially be null');
        //$this->assertNull($user->getLoginType(), '"login_type" should initially be null');
    }

    //public function testExchangeArraySetsPropertiesCorrectly()
    //{
        //$user = new User();
        //$data  = array('id' => 1,
                       //'username'     => 'username',
                       //'password'     => 'password',
                       //'email'     => 'email',
                       //'firstname'     => 'firstname',
                       //'lastname'     => 'lastname',
                       //'login_type'  => 'Software Engineer');

        //$user->exchangeArray($data);

        //$this->assertSame($data['id'], $user->getId(), '"id" was not set correctly');
        //$this->assertSame($data['username'], $user->getUsername(), '"username" was not set correctly');
        //$this->assertSame($data['password'], $user->getPassword(), '"password" was not set correctly');
        //$this->assertSame($data['email'], $user->getEmail(), '"email" was not set correctly');
        //$this->assertSame($data['firstname'], $user->getFirstname(), '"firstname" was not set correctly');
        //$this->assertSame($data['lastname'], $user->getLastname(), '"lastname" was not set correctly');
        //$this->assertSame($data['login_type'], $user->getLoginType(), '"login_type" was not set correctly');
    //}

    //public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    //{
        //$user = new User();

        //$user->exchangeArray(array('id' => 1,
                       //'username'     => 'username',
                       //'password'     => 'password',
                       //'email'     => 'email',
                       //'firstname'     => 'firstname',
                       //'lastname'     => 'lastname',
                       //'login_type'  => 'Software Engineer'));

        //$user->exchangeArray(array());

        //$this->assertNull($user->getId(), '"id" should initially be null');
        //$this->assertNull($user->getUsername(), '"username" should initially be null');
        //$this->assertNull($user->getPassword(), '"password" should initially be null');
        //$this->assertNull($user->getEmail(), '"email" should initially be null');
        //$this->assertNull($user->getFirstname(), '"firstname" should initially be null');
        //$this->assertNull($user->getLastname(), '"lastname" should initially be null');
        //$this->assertNull($user->getLoginType(), '"login_type" should initially be null');
    //}
}

