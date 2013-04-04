<?php

namespace Security\Form;

use Zend\Form\Fieldset; 
use Zend\InputFilter\InputFilterInterface; 
use Zend\InputFilter\InputFilterProviderInterface;
// Fieldset to be used to log-in already registered users
class LoginFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('login');

        $this->add(
            array(
                'name' => 'email',
                'attributes' => array(
                    'type' => 'Zend\Form\Element\Email',
                ),
                'options' => array(
                    'label' => 'email',
                )
            )
        );

        $this->add(
            array(
                'name' => 'password',
                'type' => 'Zend\Form\Element\Password',
                'options' => array(
                    'label' => 'password',
                )
            )
        );
        $this->add(array(
            'name' => 'submit',
            'attributes' => array( 'type' => 'submit',
            'value' => 'Login',
            'class' => 'btn btn-success',
        ), 

        'options' => array(
            'label' => ' ',
        ),
    )

);


    }

    public function getInputFilterSpecification()
    {
        return array(
            'email' => array (
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim'
                    )
                ),
            ),
            'password' => array (
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim'
                    )
                ),
            )
        );
    }
}
