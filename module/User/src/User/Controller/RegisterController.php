<?php
namespace User\Controller;

use Application\Controller\BaseAdminController as BaseController;
use Zend\View\Model\ViewModel;
use User\Form\RegisterForm;
use User\Entity\Users;
use Zend\View\Model\JsonModel;
use User\Form\RegisterFilter;

class RegisterController extends BaseController
{
    public function indexAction()
    {
        $form = new RegisterForm();
        $form->setInputFilter(new RegisterFilter());
        return array('form' => $form);
    }

    public function processAction()
    {
        $status = $message = '';
        $em = $this->getEntityManager();
        $form = new RegisterForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $users = new Users();
                $users->exchangeArray($form->getData());

                var_dump($users->setDate($request->getPost()->date));
                $em->persist($users);
                $em->flush();
                $status = 'success';
                $message = 'Регистрация прошла успешно';

            } else {
                $status = 'error';
                $message = 'Ошибка параметров';
            }
        } else {
            return array('form' => $form);
        }
        if ($message) {
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }
        return $this->redirect()->toRoute('register/confirm/');
    }

    public function confirmAction()
    {

    }

    public function groupAction()
    {
        $request = $this->getRequest();
        $email = $_POST['textData'];



        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('i')->from('User\Entity\Users', 'i')->where('i.email = :email')->setParameter('email', $email);
        $rows = $query->getQuery();
        $a = $rows->getResult();
        if (empty($a)) {
            $status = false;
        }
        else {
            $status = true;
        }
        $result = new JsonModel (
            array(

                'name' => $status
            )
        );
        return $result;

    }
}
