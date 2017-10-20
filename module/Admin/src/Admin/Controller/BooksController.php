<?php
namespace Admin\Controller;

use Application\Controller\BaseAdminController as BaseController;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use User\Entity\Books;
use Zend\Paginator\Paginator;
use Admin\Form\BooksAddForm;
use Admin\Form\CategoryAddForm;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;


class BooksController extends BaseController
{

    public function indexAction()
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('a')->from('User\Entity\Books', 'a')->orderBy('a.isbn', 'DESC');

        $adapter = new DoctrineAdapter(new ORMPaginator($query));

        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);
        $paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));

        return array('books' => $paginator);

    }

    public function addAction()
    {
        $em = $this->getEntityManager();
        $form = new BooksAddForm($em);
        //$form = new CategoryAddForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            // Make certain to merge the files info!
            $post = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );

            $form->setData($post);
            if ($form->isValid()) {
                $data = $form->getData();
                if(!empty($data['picturename']))
                {
                   // var_dump($data);
                    $pictureName = iconv('UTF-8','windows-1251',$data['picturename']['name']);
                    move_uploaded_file($data['picturename']['tmp_name'], 'C:\Webservers/domains/bukva.ua/public/img/verber/'.$pictureName);
                }
                // Form is valid, save the form!
               // return $this->redirect()->toRoute('upload-form/success');
            }
        }
       /* if ($request->isPost()) {
            $message = $status = '';

            $data = $request->getPost();

            $books = new Books();
            $form->setHydrator(new DoctrineHydrator($em, '\Books'));
            $form->bind($books);
            $form->setData($data);

            if ($form->isValid()) {
                $em->persist($books);
                $em->flush();

                $status = 'success';
                $message = 'Книга добавлена';

            } else {
                $status = 'error';
                $message = 'Ошибка параметров';
                foreach ($form->getInputFilter()->getInvalidInput() as $errors) {
                    foreach ($errors->getMessages() as $error) {
                        $message .= ' ' . $error;
                    }


                }
            }
        } else {
            return array('form' => $form);
        }
        if($message) {
            $this->flashMessenger()
                ->setNamespace($status)
                ->addMessage($message);
        }
        return $this->redirect()->toRoute('admin/books');*/
        return array('form' => $form);
    }
    public function showAction()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT u FROM User\Entity\Zakaz u ORDER BY u.id DESC'
        );
        $rows = $query->getResult();
        return array('zakaz' => $rows);
    }
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $em = $this->getEntityManager();

        $status = 'success';
        $message = 'Запись удалена';

        try
        {
            $repository = $em->getRepository('User\Entity\Zakaz');
            $category = $repository->find($id);
            $em->remove($category);
            $em->flush();
        }
        catch (\Exception $ex)
        {
            $status = 'error';
            $message = 'Ошибка удаления записи:' .$ex->getMessage();
        }
        $this->flashMessenger()->setNamespace($status)->addMessage($message);
        return $this->redirect()->toRoute('books/show/');
    }
    public function editAction()
    {
        $message = $status = '';
        $em = $this->getEntityManager();
        $form = new BooksAddForm($em);

        $isbn=  $this->params()->fromRoute('id',0);
       // $repository = $em->getRepository('User\Entity\Books');
       // $category = $repository->find(1);
       // $category = $em->find('User\Entity\Books', $isbn);
        $category = $em->createQueryBuilder()
            ->select('b')
            ->from('User\Entity\Books','b')
            ->where('b.isbn = :isbn')
            ->setParameter('isbn', $isbn)
            ->getQuery()
            ->getSingleResult();
        if(empty($category))
        {
            $message = 'Книга не найдена';
            $status  = 'error';
            $this->flashMessenger()->setNamespace($status)->addMessage($message);

            return $this->redirect()->toRoute('admin/books');
        }

        $form->bind($category);

        $request = $this->getRequest();

        if($request->isPost())
        {
            $data = $request->getPost();
            $form->setData($data);
            if($form->isValid())
            {
                $em->persist($category);
                $em->flush();

                $status = 'success';
                $message = 'Книга обновлена';
            }
            else
            {
                $status = 'error';
                $message = 'Ошибка параметров';


            }
        }
        else
        {
            return array('form' => $form, 'id' => $id);
        }

        if($message)
        {
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }
        return $this->redirect()->toRoute('admin/category');
    }
}