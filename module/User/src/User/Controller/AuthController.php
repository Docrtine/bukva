<?php
namespace User\Controller;

use Application\Controller\BaseAdminController as BaseController;
use User\Form\AuthForm;


class AuthController extends BaseController
{
    public function indexAction()
    {
        $form = new AuthForm();
        return array('form' => $form);
    }
    public function loginAction()
    {
        $data = $this->getRequest()->getPost();

// If you used another name for the authentication service, change it here
        $authService = $this->getServiceLocator()->get('Auth');

        $adapter = $authService->getAdapter();
        $adapter->setIdentityValue($data['email']);
        $adapter->setCredentialValue($data['password']);
        $authResult = $authService->authenticate();

        if ($authResult->isValid())
        {
            return $this->redirect()->toRoute('home');
        }

        return array('message' => 'Error');
    }

}