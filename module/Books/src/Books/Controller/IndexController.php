<?php
namespace Books\Controller;

use Application\Controller\BaseAdminController as BaseController;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use User\Entity\Books;
use Zend\Paginator\Paginator;
use Zend\Http\PhpEnvironment\RemoteAddress;
use Zend\Session\Container;
use Books\Form\ReviewsAddForm;
use User\Entity\Reviews;
use Doctrine\DBAL\DriverManager;
use Books\Form\KorzinForm;
use User\Entity\Viewed;
use Doctrine\ORM\Query\Expr\Join;

class IndexController extends BaseController
{
    public $i;

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

    public function showAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        $remote = new RemoteAddress();

        $korzinForm = new KorzinForm();
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('i')->from('User\Entity\Books', 'i')->where('i.isbn = :isbn')->setParameter('isbn', $id);
        $rows = $query->getQuery();
        $a = $rows->getResult();

        $query->select('a')->from('User\Entity\Reviews', 'a')->where('a.isbn = :isbn')->setParameter('isbn', $id);
        $rowsForReviews = $query->getQuery();
        $b = $rowsForReviews->getResult();


        $ip = $remote->getIpAddress();

        $em = $this->getEntityManager();

        $qb = $em->createQueryBuilder()
            ->select(array('b.title','b.author','b.picturename','b.isbn'))
            ->from('User\Entity\Viewed', 'v')
            ->leftJoin('User\Entity\Books', 'b',Join::WITH, 'b.isbn = v.isbn');
        $query2 = $qb->getQuery()->getResult();

        $qb = $em->createQueryBuilder()
            ->select (array('IDENTITY(b.category)','b.title','b.author','b.picturename','b.isbn'))
            ->from('User\Entity\Viewed', 'v')
            ->leftJoin('User\Entity\Books', 'b',Join::WITH, 'v.isbn = b.isbn')
;
        $query3 = $qb->getQuery()->getResult();

        $qb = $em->createQueryBuilder()
            ->select (array('IDENTITY(b.category)','b.title','b.author','b.picturename','b.isbn'))
            ->from('User\Entity\Books', 'b')
            ->leftJoin('User\Entity\Viewed', 'v',Join::WITH, 'v.isbn = b.isbn')
            ->where('b.isbn = :isbn')
            ->setParameter('isbn', $id)
        ;
        $query4 = $qb->getQuery()->getResult();


        $qb = $em->createQueryBuilder()
            ->select(array('b.title','b.author','b.picturename','b.isbn'))
            ->from('User\Entity\Books', 'b')
            ->where('b.author = :author')
            ->andWhere($qb->expr()->not($qb->expr()->eq('b.isbn', '?1')))
            ->setParameter(1, $id)
            ->setParameter('author',$query4[0]['author'] )
            ;
        $query5 = $qb->getQuery()->getResult();

$pr = array();
        for($i =0; $i < count($query3); ++$i )
        {
            array_push($pr, $query3[$i][1]);
        }

        $dql = "SELECT b.title, b.author, b.picturename, b.isbn FROM User\Entity\Books b WHERE b.category IN (?1)
               AND NOT  EXISTS ( SELECT  b1.isbn FROM User\Entity\Books b1 WHERE b.isbn IN (?2))";
        //$dql = "SELECT b.title, b.author, b.picturename, b.isbn FROM User\Entity\Books b WHERE b.category IN (?1)";
        $query6 = $em->createQuery($dql)
            ->setParameter(1, $pr)
            ->setParameter(2, $id)
            ->setMaxResults(6);

        $result = $query6->getResult();

        shuffle($result);

        $container = new Container('user');

        $this->ipInsert($ip,$a[0]->getIsbn());

          if ($container->user == 'Гость') {
              $reviewsUser = false;
          } else {
              $reviewsUser = new ReviewsAddForm();
          }

        return array('books' => $a, 'ip' => $ip, 'reviews' => $b, 'form' => $reviewsUser, 'korzin' => $korzinForm,
            'prosm' => $query2, 'books_author' =>$query5, 'books_recomend' =>$result);
    }

    public function reviewsAdd($data)
    {
        $config = new \Doctrine\DBAL\Configuration();

        $connectionParams = array(
            'host'     => 'localhost',
            'port'     => '3306',
            'user'     => 'root',
            'password' => '',
            'dbname'   => 'bukva',
            'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
        );

        $conn = DriverManager::getConnection($connectionParams, $config);

        $authenticationService = $this->getServiceLocator()->get('Auth');
        $loggedUser = $authenticationService->getIdentity();
       $query = $conn->createQueryBuilder()->select('id')->from('Users')->where('email = ?')->setParameter(0, $loggedUser->getEmail());
        $idUser = $query->execute()->fetchColumn();

        $queryx = $conn->createQueryBuilder();
        $resultx = $queryx->execute();

        $request = $this->request;
        $data = $request->getPost()->toArray();
        $data['date'] = new \DateTime('now');
        $user = new Container('user');

        $data['isbn'] = "d22";
        $queryx->insert('Reviews')->values(
            array(
                'id' => '?',
                'isbn' => '?',
                'id_user' => '?',
                'date' => '?',
                'text' => '?',
            ))->setParameter(0,3) ->setParameter(1,'978-5-386-06458-7')->setParameter(2,  1)->setParameter(3, $data['date'])->setParameter(4, $data['text']);

    }
    public function korzinAction()
    {
        $b = new Container('korzin');
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('i')->from('User\Entity\Books', 'i')->where('i.isbn = :isbn')->setParameter('isbn', $b->isbn);
        $rows = $query->getQuery();
        //$a = $rows->getResult();
        $a = $rows->getResult();
        $request = $this->request;
        if($request->isPost())
        {
            $status = $message = '';

            $isbn = $request->getPost()->isbn_korzin;
            /*$query = $this->getEntityManager()->createQueryBuilder();
            $query->select('i')->from('User\Entity\Books', 'i')->where('i.isbn = :isbn')->setParameter('isbn', $isbn);
            $rows = $query->getQuery();
            $a = $rows->getResult();*/
            $status = 'success';
            $message = 'Книга добавлена';
            $b = new Container('korzin');
            $b->isbn = array();

            array_push($b->isbn, $isbn);
           // $result = array();
           // for($i = 0; $i < count($b->books); ++$i)
           // {
                $query = $this->getEntityManager()->createQueryBuilder();
                $query->select('i')->from('User\Entity\Books', 'i')->where('i.isbn = :isbn')->setParameter('isbn', $isbn);
                $rows = $query->getQuery();
                //$a = $rows->getResult();
                $a = $rows->getResult();

         //   }
            if($message)
            {
                $this->flashMessenger()->setNamespace($status)->addMessage($message);
            }

        }
        return array('books' => $a);

    }

    public function ipInsert($ip, $isbn)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('i')
            ->from('User\Entity\Viewed', 'i')
            ->where('i.ip = :ip','i.isbn = :isbn')
            ->setParameter('ip', $ip)
            ->setParameter('isbn', $isbn);
        $result = $query->getQuery()->getResult();
        if(empty($result)) {
            $viewed = new Viewed();
            $viewed->setIsbn($isbn);
            $viewed->setIp($ip);
            $em = $this->getEntityManager();
            $em->persist($viewed);
            $em->flush();
        }

    }


}
