<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Item
 *
 * @ORM\Table(name="item")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ItemRepository")
 */
class Item
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="qty", type="integer")
     */
    private $qty;

    /**
     * @var float
     *
     * @ORM\Column(name="weight", type="float")
     */
    private $weight;

    /**
     * @var binary
     *
     * @ORM\Column(name="qr", type="binary")
     */
    private $qr;

    /**
     * @ORM\ManyToOne(targetEntity="Food", inversedBy="items")
     * @ORM\JoinColumn(name="food_id", referencedColumnName="id")
     */
    private $food;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="items")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

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
     * Set description
     *
     * @param string $description
     *
     * @return Item
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set qty
     *
     * @param integer $qty
     *
     * @return Item
     */
    public function setQty($qty)
    {
        $this->qty = $qty;

        return $this;
    }

    /**
     * Get qty
     *
     * @return int
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * Set weight
     *
     * @param float $weight
     *
     * @return Item
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set qr
     *
     * @param binary $qr
     *
     * @return Item
     */
    public function setQr($qr)
    {
        $this->qr = $qr;

        return $this;
    }

    /**
     * Get qr
     *
     * @return binary
     */
    public function getQr()
    {
        return $this->qr;
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
    public function getCategory() {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category) {
        $this->category = $category;
    }
}

