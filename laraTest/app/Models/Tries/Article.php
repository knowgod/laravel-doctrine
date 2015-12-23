<?php
/**
 * Created by PhpStorm.
 * User: arkadij
 * Date: 14.12.15
 * Time: 18:21
 */

namespace App\Models\Tries;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;

/**
 * Class Article
 *
 * @package App\Models\Tries
 *
 * @ORM\Entity(repositoryClass="App\Models\Tries\ArticleRepository")
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
     * @ORM\ManyToMany(targetEntity="Tag", mappedBy="article", cascade={"persist"})
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
    }

    /**
     * @param $tag
     * @return Article
     */
    public function addTag(Tag $tag)
    {
        if (!$this->tags->contains($tag)) {
            $tag->setArticle($this);
            $this->tags->add($tag);
        }
    }

}
