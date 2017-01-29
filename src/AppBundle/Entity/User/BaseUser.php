<?php

namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * BaseUser
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\BaseUserRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *     "baseUser" = "BaseUser",
 *     "superAdmin" = "SuperAdminUser",
 *     "adminUser" = "AdminUser",
 * })
 */
class BaseUser implements UserInterface, AdvancedUserInterface, \Serializable
{
    const ROLE_SUPERADMIN = 'ROLE_SUPERADMIN';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';

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
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Category name must be at least {{ limit }} characters long",
     *      maxMessage = "Category name cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=255)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     * @Assert\Length(min="6")
     * @Assert\Regex(pattern="/^[A-Za-z0-9-_']+$/", message="Allowed only letters, numbers and symbols: '_', '-'.")
     */
    private $plainPassword;

    /**
     * @var boolean
     *
     * @ORM\Column(name="locked", type="boolean", options={"default"=0})
     */
    private $locked = 0;

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
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return BaseUser
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return BaseUser
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return BaseUser
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set plainPassword
     *
     * @param string $plainPassword
     *
     * @return BaseUser
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * Get plainPassword
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @return boolean
     */
    public function isLocked() {
        return $this->locked;
    }

    /**
     * @param boolean $locked
     */
    public function setLocked($locked) {
        $this->locked = $locked;
    }

    public function getUsername()
    {
        return $this->getEmail();
    }

    public function isAccountNonLocked()
    {
        return $this->isEnabled();
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return !$this->isLocked();
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * Removes sensitive data from the user.
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * @return Role[] The user roles
     */
    public function getRoles()
    {
        return [$this->getRole()];
    }

    /**
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->getId(),
            $this->getEmail()
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id
            ) = unserialize($serialized);
    }
}

