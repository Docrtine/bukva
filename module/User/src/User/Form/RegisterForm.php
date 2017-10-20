<?php

namespace User\Form;

use Zend\Form\Form;

class RegisterForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('RegisterForm');
        $this->setAttribute('method', 'post');
         $this->setAttribute('class', 'bs');
       // $date = date('Y');
        $this->add(array(
            'name' =>'name',
            'type' => 'Text',
            'options' => array(
                'min' => 3,
                'max' => 100,
                'label' => 'Имя',
            ),
            'attributes' => array(
                'class'     => 'form_category',
                'required' => 'required',
            ),
        ));
        $this->add(array(
            'name' =>'secondName',
            'type' => 'Text',
            'options' => array(
                'min' => 3,
                'max' => 100,
                'label' => 'Фамилия',
            ),
            'attributes' => array(
                'class'     => 'form_category',
                'required' => 'required',
            ),
        ));
        $this->add(array(
            'name' =>'email',
            'type' => 'Email',

            'options' => array(
                'label' => 'E-mail',

            ),
            'attributes' => array(
                'class'     => 'form_category',
                'required' => 'required',
                'id'   => 'check_email',
                'onblur' => 'check()',

            ),
        ));
        $this->add(array(
            'name' =>'password',
            'type' => 'password',
            'options' => array(
                'min' => 5,
                'max' => 40,
                'label' => 'Пароль',
            ),
            'attributes' => array(
                'class'     => 'form_category',
                'required' => 'required',
            ),
        ));
        $this->add(array(
            'name' =>'date',
            'type' => 'date',
            'options' => array(
                'label' => 'Дата рождения'
            ),
                'attributes' => array(
                    'class' => 'form_category',
                    'required' => 'required',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Регистрация',
                'id'    => 'btn_submit',
                'class' => 'btn_submit',
            ),
        ));
    }
}