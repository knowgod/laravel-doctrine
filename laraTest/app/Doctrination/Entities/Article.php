<?php
/**
 * Created by PhpStorm.
 * User: arkadij
 * Date: 14.12.15
 * Time: 18:21
 */

namespace App\Doctrination\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;

/**
 * Class Article
 *
 * @package App\Doctrination\Entities
 *
 * @ORM\Entity(repositoryClass="App\Doctrination\Repositories\ArticleRepository")
 * @ORM\Table(name="article")
 */
class Article
{

    use Timestamps;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="string")
     */
    protected $body;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", mappedBy="articles", cascade={"persist"})
     * @var ArrayCollection|Tag[]
     */
    protected $tags;

    /**
     * @ORM\Column(name="content_changed", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={"title", "body"})
     * @var \DateTime
     */
    protected $contentChanged;

    /**
     * Article constructor.
     *
     * @param $title
     * @param $body
     */
    public function __construct($title = null, $body = null)
    {
        if ($title) {
            $this->title = $title;
        }
        if ($body) {
            $this->body = $body;
        }

        $this->tags = new ArrayCollection();
    }

    /**
     * @return \DateTime
     */
    public function getContentChangedAt()
    {
        return $this->contentChanged;
    }

    /**
     * @return Tag[]|ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param $tag
     * @return Article
     */
    public function addTag(Tag $tag)
    {
        if (!$this->hasTag($tag)) {
            $tag->addArticle($this);
            $this->tags->add($tag);
        }
        return $this;
    }

    /**
     * @param Tag $tag
     * @return bool
     */
    public function hasTag(Tag $tag)
    {
        return $this->tags->contains($tag);
    }

    /**
     * @param Tag $tag
     * @return bool
     */
    public function removeTag(Tag $tag)
    {
        if ($this->hasTag($tag)) {
            return $this->tags->removeElement($tag);
        }
        return false;
    }

}
