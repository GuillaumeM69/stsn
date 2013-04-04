<?php

namespace Security\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name)
    {
        parent::__construct($name);

        $this->setAttribute('method','post');
        $this->setAttribute('action','/security/login');

    }

}

