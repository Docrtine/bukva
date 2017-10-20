<?php

namespace Books\Form;

use Zend\Form\Form;

class KorzinForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('KorzinForm');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'submit2',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Добавить в корзину',
                'class' => 'btn_submit_korzin',
            ),
        ));
        $this->add(array(
            'name' =>'isbn_korzin',
            'type' => 'hidden',
        ));

    }
}