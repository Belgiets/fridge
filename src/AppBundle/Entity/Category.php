<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Food", inversedBy="categories")
     * @ORM\JoinColumn(name="food_id", referencedColumnName="id")
     */
    private $food;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User\AdminUser", inversedBy="categories")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="SET NULL")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User\AdminUser")
     */
    private $updatedBy;

    /**
     * @ORM\OneToMany(targetEntity="Item", mappedBy="category")
     */
    private $items;

    public function __construct() {
        $this->items = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getFood() {
        return $this->food;
    }

    /**
     * @param mixed $food
     */
    public function setFood($food) {
        $this->food = $food;
    }

    /**
     * @return mixed
     */
    public function getItems() {
        return $this->items;
    }

    /**
     * @param \AppBundle\Entity\Item $item
     * @return $this
     */
    public function addItem(Item $item)
    {
        if (!$this->getItems()->contains($item)) {
            $this->getItems()->add($item);
        }

        return $this;
    }

    /**
     * @param \AppBundle\Entity\Item $item
     * @return $this
     */
    public function removeItem(Item $item)
    {
        $this->items->removeElement($item);

        return $this;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy() {
        return $this->createdBy;
    }

    /**
     * @param mixed $createdBy
     */
    public function setCreatedBy($createdBy) {
        $this->createdBy = $createdBy;
    }

    /**
     * @return mixed
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * @param mixed $updatedBy
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }
}

