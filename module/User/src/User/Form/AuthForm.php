<?php

namespace User\Form;

use Zend\Form\Form;

class AuthForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('AuthForm');
        $this->setAttribute('method', 'post');
        $this->add(
            array(
                'name'       => 'email',
                'attributes' => array(
                    'class'     => 'form_category',
                    'type'     => 'email',
                    'required' => 'required',
                    'id'       => 'email',
                ),
                'options'    => array(
                    'label' => 'Email',
                ),
                'filters'    => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'EmailAddress',
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\EmailAddress::INVALID_FORMAT => 'Email adress format is invalid'
                            )
                        )
                    )
                )
            )
        );
        $this->add(
            array(
                'name'       => 'password',
                'attributes' => array(
                    'class'     => 'form_category',
                    'type' => 'password',
                    'required' => 'required',
                ),
                'options'    => array(
                    'label' => 'Пароль',
                )
            )
        );
        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Войти',
                'class' => 'btn_submit',
            ),
        ));
    }
}

?>