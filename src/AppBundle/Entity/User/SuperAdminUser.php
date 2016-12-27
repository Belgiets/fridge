<?php

namespace AppBundle\Entity\User;

use AppBundle\Entity\Shelf;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\SuperAdminUserRepository")
 */
class SuperAdminUser extends BaseUser
{
    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\User\AdminUser", mappedBy="createdBy")
     */
    private $admins;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Shelf", mappedBy="createdBy")
     */
    private $shelves;

    public function __construct()
    {
        parent::__construct();

        $this->setRole(self::ROLE_SUPERADMIN);
        $this->admins = new ArrayCollection();
        $this->shelves = new ArrayCollection();
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdmins() {
        return $this->admins;
    }

    /**
     * @param \AppBundle\Entity\User\AdminUser $admin
     * @return $this
     */
    public function addAdmin(AdminUser $admin)
    {
        if (!$this->getAdmins()->contains($admin)) {
            $this->getAdmins()->add($admin);
        }

        return $this;
    }

    /**
     * @param \AppBundle\Entity\User\AdminUser $admin
     * @return $this
     */
    public function removeAdmin(AdminUser $admin)
    {
        $this->admins->removeElement($admin);

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getShelves() {
        return $this->shelves;
    }

    /**
     * @param \AppBundle\Entity\Shelf $shelf
     * @return $this
     */
    public function addShelf(Shelf $shelf)
    {
        if (!$this->getShelves()->contains($shelf)) {
            $this->getShelves()->add($shelf);
        }

        return $this;
    }

    /**
     * @param \AppBundle\Entity\Shelf $shelf
     * @return $this
     */
    public function removeShelf(Shelf $shelf)
    {
        $this->shelves->removeElement($shelf);

        return $this;
    }
}

