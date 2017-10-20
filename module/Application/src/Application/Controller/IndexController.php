<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;



class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $container = new Container('user');

        $authenticationService = $this->getServiceLocator()->get('Auth');
        $loggedUser = $authenticationService->getIdentity();
        if(empty($loggedUser))
        {
            $container->user = 'Гость';
        }
        else
        {
            $container->user = $loggedUser->getName().' '.  $loggedUser->getSecondName();
        }
        return new ViewModel();
    }
}
