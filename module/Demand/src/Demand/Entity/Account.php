<?php
namespace Demand\Entity;

class Account
{
    protected $id;
    protected $firstname;
    protected $lastname;
    protected $email;
    protected $userId;
    protected $username;
    protected $photo;

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->username = (isset($data['username'])) ? $data['username'] : $data['email'];
        $this->userId  = (isset($data['user_id'])) ? md5($data['user_id']) : null;
        $this->email  = (isset($data['email'])) ? $data['email'] : null;
        $this->firstname  = (isset($data['firstname'])) ? $data['firstname'] : null;
        $this->lastname  = (isset($data['lastname'])) ? $data['lastname'] : null;
        $this->photo  = (isset($data['photo'])) ? $data['photo'] : null;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }
}

