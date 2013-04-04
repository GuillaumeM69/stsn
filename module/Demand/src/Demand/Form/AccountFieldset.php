<?php

namespace Security\Form;

use Zend\Form\Fieldset; 
use Zend\InputFilter\InputFilterInterface; 
use Zend\InputFilter\InputFilterProviderInterface;

//Extends the FieldSet Class for registering a new account
class AccountFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('account');

        $this->add(
            array(
                'name' => 'firstname',
                'type' => 'Zend\Form\Element\Text',
                'options' => array(
                    'label' => 'firstname',
                )
            )
        );

        $this->add(
            array(
                'name' => 'lastname',
                'type' => 'Zend\Form\Element\Text',
                'options' => array(
                    'label' => 'lastname',
                )
            )
        );

        $this->add(
            array(
                'name' => 'email',
                'type' => 'Zend\Form\Element\Text',
                'options' => array(
                    'label' => 'email',
                )
            )
        );

        $this->add(
            array(
                'name' => 're-email',
                'type' => 'Zend\Form\Element\Email',
                'options' => array(
                    'label' => 're-email',
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

        $this->add(
            array(
                'name' => 're-password',
                'type' => 'Zend\Form\Element\Password',
                'options' => array(
                    'label' => 're-password',
                )
            )
        );

        $this->add(array(
            'name' => 'submit',
            'attributes' => array( 'type' => 'submit',
            'value' => 'Signup'
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

            'firstname' => array (
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim'
                    )
                ),
            ),

            'lastname' => array (
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim'
                    )
                ),
            ),
            'email' => array (
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim'
                    )
                ),
            ),
            're-email' => array (
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
            ),

            're-password' => array (
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim'
                    )
                ),
            ),
        );
    }
}
