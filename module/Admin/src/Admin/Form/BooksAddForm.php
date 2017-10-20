<?php

namespace Admin\Form;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\Form\Form;
//use Zend\Form\Element;


use Admin\Filter\BooksAddInputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use User\Entity\Books;

class BooksAddForm extends Form implements ObjectManagerAwareInterface
{
    protected $objectManager;

    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function getObjectManager()
    {
        return $this->objectManager;
    }

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('booksAddForm');
        //  $this->setAttribute('method', 'post');
        $this->setObjectManager($objectManager);
        $this->createElements();
    }

    public function createElements()
    {
        $this->setAttribute('method', 'post');
        // $this->setAttribute('class', 'bs-example form-horizontal');

        $this->setInputFilter(new BooksAddInputFilter());
        $this->add(
            array(
                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'name' => 'category',
                'options' => array(
                    'label' => 'Категория',
                    'empty_option' => 'Выберете категорию...',
                    'object_manager' => $this->getObjectManager(),
                    'target_class' => 'User\Entity\Category',
                    'property' => 'category',
                ),
                'attributes' => array(
                    'class' => 'form-control',
                    'required' => 'required',
                ),
            )
        );
        $this->add(
            array(
                'name' => 'isbn',
                'type' => 'Text',
                'options' => array(
                    'label' => 'ISBN',
                ),
                'attributes' => array(
                    'class' => 'form-control',
                    'required' => 'required'
                ),
            )
        );
        $this->add(
            array(
                'name' => 'author',
                'type' => 'Text',
                'options' => array(
                    'label' => 'Автор',
                ),
                'attributes' => array(
                    'class' => 'form-control',
                    'required' => 'required'
                ),
            )
        );
        $this->add(
            array(
                'name' => 'title',
                'type' => 'Text',
                'options' => array(
                    'label' => 'Название',
                ),
                'attributes' => array(
                    'class' => 'form-control',
                    'required' => 'required'
                ),
            )
        );
        $this->add(
            array(
                'name' => 'anotation',
                'type' => 'Textarea',
                'options' => array(
                    'label' => 'Аннотация',
                ),
                'attributes' => array(
                    'rows' => 5,
                    'cols' => 80,
                    'class' => 'form-category',
                    'required' => 'required'
                ),
            )
        );
        $this->add(
            array(
                'name' => 'pages',
                'type' => 'Text',
                'options' => array(
                    'label' => 'Страниц',
                ),
                'attributes' => array(
                    'class' => 'form-control',
                    'required' => 'required'
                ),
            )
        );
        $this->add(
            array(
                'name' => 'price',
                'type' => 'Text',
                'options' => array(
                    'label' => 'Цена',
                ),
                'attributes' => array(
                    'class' => 'form-control',
                    'required' => 'required'
                ),
            )
        );
        $this->add(
            array(
                'name' => 'picturename',
                'type' => 'File',
                'options' => array(
                    'label' => 'Картинка',
                ),
                'attributes' => array(
                    'class' => 'form-control',
                    'required' => 'required',
                    'id' => 'image-file',
                ),
            )
        );

        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Сохранить',
                'id' => 'btn_submit',
                'class' => 'btn_submit',
            ),
        ));
    }

}