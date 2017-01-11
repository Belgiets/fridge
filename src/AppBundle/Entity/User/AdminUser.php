<?php

namespace AppBundle\Entity\User;

use AppBundle\Entity\Category;
use AppBundle\Entity\Food;
use AppBundle\Entity\Item;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\AdminUserRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class AdminUser extends BaseUser
{
    use SoftDeleteableEntity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var |DateTime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Category", mappedBy="createdBy")
     */
    private $categories;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Food", mappedBy="createdBy")
     */
    private $foods;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Item", mappedBy="createdBy")
     */
    private $items;

    public function __construct()
    {
        parent::__construct();

        $this->setRole(self::ROLE_ADMIN);
        $this->setCreatedAt(new \DateTime());
        $this->categories = new ArrayCollection();
        $this->foods = new ArrayCollection();
        $this->items = new ArrayCollection();
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }



    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories() {
        return $this->categories;
    }

    /**
     * @param \AppBundle\Entity\Category $category
     * @return $this
     */
    public function addCategory(Category $category)
    {
        if (!$this->getCategories()->contains($category)) {
            $this->getCategories()->add($category);
        }

        return $this;
    }

    /**
     * @param \AppBundle\Entity\Category $category
     * @return $this
     */
    public function removeCategory(Category $category)
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFoods() {
        return $this->foods;
    }

    /**
     * @param \AppBundle\Entity\Food $food
     * @return $this
     */
    public function addFood(Food $food)
    {
        if (!$this->getFoods()->contains($food)) {
            $this->getFoods()->add($food);
        }

        return $this;
    }

    /**
     * @param \AppBundle\Entity\Food $food
     * @return $this
     */
    public function removeFood(Food $food)
    {
        $this->categories->removeElement($food);

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
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
}

