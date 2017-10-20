<?php

namespace Admin\Form;

use Zend\Form\Form;

class CategoryAddForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('categoryAddForm');
        $this->setAttribute('method', 'post');
       // $this->setAttribute('class', 'bs');

        $this->add(array(
            'name' =>'category',
            'type' => 'Text',
            'options' => array(
                'min' => 3,
                'max' => 100,
                'label' => 'Название',
            ),
            'attributes' => array(
                'class'     => 'form_category',
                'required' => 'required',
            ),
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