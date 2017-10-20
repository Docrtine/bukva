<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Books
 *
 * @ORM\Table(name="books", uniqueConstraints={@ORM\UniqueConstraint(name="category", columns={"category"})}, indexes={@ORM\Index(name="author", columns={"author", "title"})})
 * @ORM\Entity
 */
class Books
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="isbn", type="string", length=255, nullable=false)
     */
    private $isbn = '';

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255, nullable=false)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="anotation", type="text", length=65535, nullable=false)
     */
    private $anotation;

    /**
     * @var integer
     *
     * @ORM\Column(name="pages", type="integer", nullable=false)
     */
    private $pages;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="pictureName", type="string", length=255, nullable=false)
     */
    private $picturename;

    /**
     * @var \User\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="User\Entity\Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category", referencedColumnName="id")
     * })
     */
    private $category;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set isbn
     *
     * @param string $isbn
     *
     * @return Books
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get isbn
     *
     * @return string
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Books
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Books
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set anotation
     *
     * @param string $anotation
     *
     * @return Books
     */
    public function setAnotation($anotation)
    {
        $this->anotation = $anotation;

        return $this;
    }

    /**
     * Get anotation
     *
     * @return string
     */
    public function getAnotation()
    {
        return $this->anotation;
    }

    /**
     * Set pages
     *
     * @param integer $pages
     *
     * @return Books
     */
    public function setPages($pages)
    {
        $this->pages = $pages;

        return $this;
    }

    /**
     * Get pages
     *
     * @return integer
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Books
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set picturename
     *
     * @param string $picturename
     *
     * @return Books
     */
    public function setPicturename($picturename)
    {
        $this->picturename = $picturename;

        return $this;
    }

    /**
     * Get picturename
     *
     * @return string
     */
    public function getPicturename()
    {
        return $this->picturename;
    }

    /**
     * Set category
     *
     * @param \User\Entity\Category $category
     *
     * @return Books
     */
    public function setCategory(\User\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \User\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
    public function getAnotationForTable()
    {
        $anotation = strip_tags($this->getAnotation());
        $anotation = mb_substr($anotation,0,100,'UTF-8') . '...';
        return $anotation;

    }
    public function exchangeArray($data)
    {
        foreach ($data as $key => $val)
        {
            if(property_exists($this, $key)) {
                $this->$key = ($val !== null) ? $val : null;
            }
        }
    }
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
