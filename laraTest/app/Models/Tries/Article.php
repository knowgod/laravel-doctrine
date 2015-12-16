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
     * @ORM\OneToMany(targetEntity="Tag", mappedBy="article", cascade={"persist"})
     * @var ArrayCollection|Tag[]
     */
    protected $tags;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTime
     */
    protected $created_at;

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
        $this->created_at = new \DateTime();

        $this->tags = new ArrayCollection();
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
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at->format('Y-m-d H:i:s');
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
