<?php

namespace Demand\Form;

use Zend\Form\Form;

class AccountForm extends Form
{
    public function __construct($name)
    {
        parent::__construct($name);

        $this->setAttribute('method','post');
        $this->setAttribute('action','/demand/account/edit');

    }

}

