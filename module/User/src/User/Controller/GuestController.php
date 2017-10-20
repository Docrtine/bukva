<?php
namespace User\Controller;

use Application\Controller\BaseAdminController as BaseController;
use User\Form\GuestBookAddForm;


class GuestController extends BaseController
{
    public function indexAction()
    {
        $form = new GuestBookAddForm();
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('a')->from('User\Entity\Guest', 'a')->orderBy('a.name', 'DESC');
        $rows = $query->getQuery();
        $a = $rows->getResult();

        return array('form' => $form, 'result' => $a);
    }
}