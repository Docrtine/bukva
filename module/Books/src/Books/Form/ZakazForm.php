<?php

namespace Books\Form;

use Zend\Form\Form;

class ZakazForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('ZakazForm');
        $this->setAttribute('method', 'post');
        // $this->setAttribute('class', 'bs');

        $this->add(array(
            'name' =>'name',
            'type' => 'text',
            'options' => array(
                'label' => 'Èìÿ',
            ),
            'attributes' => array(
                'class'     => 'form_category',
                'required' => 'required',
            ),
        ));
    }
}