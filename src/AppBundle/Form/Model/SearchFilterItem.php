<?php
namespace AppBundle\Form\Model;

use AppBundle\Entity\Category;
use AppBundle\Entity\Food;
use AppBundle\Entity\Shelf;
use AppBundle\Entity\User\AdminUser;

class SearchFilterItem
{
    /**
     * @var string
     */
    private $description;

    /**
     * @var Food;
     */
    private $food;

    /**
     * @var Category
     */
    private $category;

    /**
     * @var Shelf
     */
    private $shelf;

    /**
     * @var \DateTime
     */
    private $createdStart;

    /**
     * @var \DateTime
     */
    private $createdEnd;

    /**
     * @var AdminUser
     */
    private $createdBy;

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return Food
     */
    public function getFood()
    {
        return $this->food;
    }

    /**
     * @param Food $food
     */
    public function setFood($food)
    {
        $this->food = $food;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return Shelf
     */
    public function getShelf()
    {
        return $this->shelf;
    }

    /**
     * @param Shelf $shelf
     */
    public function setShelf($shelf)
    {
        $this->shelf = $shelf;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedStart()
    {
        return $this->createdStart;
    }

    /**
     * @param \DateTime $createdStart
     */
    public function setCreatedStart($createdStart)
    {
        $this->createdStart = $createdStart;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedEnd()
    {
        return $this->createdEnd;
    }

    /**
     * @param \DateTime $createdEnd
     */
    public function setCreatedEnd($createdEnd)
    {
        $this->createdEnd = $createdEnd;
    }

    /**
     * @return AdminUser
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param AdminUser $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }
}