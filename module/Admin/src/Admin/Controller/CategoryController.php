<?php
namespace Admin\Controller;

use Application\Controller\BaseAdminController as BaseController;
use Admin\Form\CategoryAddForm;
use User\Entity\Category;
use Zend\View\Model\ViewModel;

class CategoryController extends BaseController
{
    public function indexAction()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT u FROM User\Entity\Category u ORDER BY u.id '
        );
        $rows = $query->getResult();
        return array('category' => $rows);
        /* $view = new ViewModel();
         return $view;*/
    }

    public function addAction()
    {
        $form = new CategoryAddForm();
        $status = $message = '';
        $em = $this->getEntityManager();

        $request = $this->getRequest();
        if($request->isPost())
        {
            $form->setData($request->getPost());
            if ($form->isValid())
            {
                $category = new Category();
                $category->exchangeArray($form->getData());
                $em->persist($category);
                $em->flush();
                $status = 'success';
                $message = 'Категория добавлена';

            } else {
                $status = 'error';
                $message = 'Ошибка параметров';
            }
        }
        else
        {
            return array('form' => $form);
        }
        if($message)
        {
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }
        return $this->redirect()->toRoute('admin/category');
    }

    public function editAction()
    {
        $message = $status = '';
        $em = $this->getEntityManager();
        $form = new CategoryAddForm();

        $id = (int) $this->params()->fromRoute('id',0);

        $category = $em->find('User\Entity\Category', $id);

        if(empty($category))
        {
            $message = 'Категория не найдена';
            $status  = 'error';
            $this->flashMessenger()->setNamespace($status)->addMessage($message);

            return $this->redirect()->toRoute('admin/category');
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
                $message = 'Категория обновлена';
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

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $em = $this->getEntityManager();

        $status = 'success';
        $message = 'Запись удалена';

        try
        {
            $repository = $em->getRepository('User\Entity\Category');
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
        return $this->redirect()->toRoute('admin/category');
    }
}