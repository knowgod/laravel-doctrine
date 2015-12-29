<?php
/**
 * Created by PhpStorm.
 * User: arkadij
 * Date: 14.12.15
 * Time: 18:43
 */

namespace App\Doctrination\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="Article", inversedBy="tags")
     * @var ArrayCollection|Tag[]
     */
    protected $articles;

    /**
     * Tag constructor.
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;

        $this->articles = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Article
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param Article $article
     */
    public function addArticle(Article $article)
    {
        if (!$this->hasArticle($article)) {
            $this->articles->add($article);
        }
        return $this;
    }

    /**
     * @param Article $article
     * @return boolean
     */
    public function hasArticle(Article $article)
    {
        return $this->articles->contains($article);
    }

}