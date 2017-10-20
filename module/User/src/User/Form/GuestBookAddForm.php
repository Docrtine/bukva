<?php

namespace User\Form;

use Zend\Form\Form;
use Zend\I18n\Validator\DateTime;

class GuestBookAddForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('GuestBookAddForm');
        $this->setAttribute('method', 'post');
       // $this->setAttribute('class', 'bs');
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
            'name' =>'text',
            'type' => 'Text',
            'options' => array(
                'min' => 3,
                'max' => 100,
                'label' => 'Ваш отзыв',
            ),
            'attributes' => array(
                'class'     => 'form_category',
                'required' => 'required',
            ),
        ));
        $this->add(array(
            'name' =>'date',
            'type' => 'hidden',
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Сохранить',
                'id'    => 'btn_submit',
                'class' => 'btn_submit',
            ),
        ));
    }
}