<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Food
 *
 * @ORM\Table(name="food")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FoodRepository")
 */
class Food
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
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="food")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="Item", mappedBy="food")
     */
    private $items;

    /**
     * Food constructor.
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->items = new ArrayCollection();
    }

    /**
     * @return \AppBundle\Entity\datetime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * @param \AppBundle\Entity\datetime $createdAt
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \AppBundle\Entity\datetime
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * @param \AppBundle\Entity\datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
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
     * @return Food
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
    public function getCategories() {
        return $this->categories;
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories) {
        $this->categories = $categories;
    }

    /**
     * @return mixed
     */
    public function getItems() {
        return $this->items;
    }

    /**
     * @param mixed $items
     */
    public function setItems($items) {
        $this->items = $items;
    }
}

