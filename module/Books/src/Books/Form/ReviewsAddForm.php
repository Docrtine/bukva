<?php

namespace Books\Form;

use Zend\Form\Form;

class ReviewsAddForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('reviewsAddForm');
        $this->setAttribute('method', 'post');
        // $this->setAttribute('class', 'bs');

        $this->add(array(
            'name' =>'text',
            'type' => 'textArea',
            'options' => array(
                'label' => 'Отзыв',
            ),
            'attributes' => array(
                'rows' => 5,
                'cols' => 51,
                'value' => 'Ваш отзыв',
                'class'     => 'form_category_rev',
                'required' => 'required',
            ),
        ));

        $this->add(array(
            'name' =>'isbn',
            'type' => 'hidden',
            'attributes' => array(
            ),
        ));
        $this->add(array(
            'name' =>'date',
            'type' => 'hidden',
            'attributes' => array(
            ),
        ));
        $this->add(array(
            'name' =>'idUser',
            'type' => 'hidden',
            'attributes' => array(
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Сохранить',
                'class' => 'btn_submit_rev',
            ),
        ));
    }
}