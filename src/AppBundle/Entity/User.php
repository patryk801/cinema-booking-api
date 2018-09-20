<?php

namespace AppBundle\Entity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="users")
 * @UniqueEntity("username", groups={"Default", "Patch"})
 */
class User implements UserInterface
{
    const ROlE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"Default", "Deserialize"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank(groups={"Default"})
     * @Serializer\Groups({"Default", "Deserialize"})
     */
    private $username;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank(groups={"Default"})
     * @Serializer\Groups({"Deserialize"})
     */
    private $password;

    /**
     * @var string
     * @Assert\NotBlank(groups={"Default"})
     * @Assert\Expression(
     *     "this.getPassword() === this.getRetypedPassword()",
     *     message="Passwords are not the same.",
     *     groups={"Default", "Patch"}
     * )
     * @Serializer\Type("string")
     * @Serializer\Groups({"Deserialize"})
     */
    private $retypedPassword;

    /**
     * @var array
     * @ORM\Column(type="simple_array")
     * @Serializer\Exclude()
     */
    private $roles;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function setRetypedPassword(string $retypedPassword): void
    {
        $this->retypedPassword = $retypedPassword;
    }

    public function getRetypedPassword(): ?string
    {
        return $this->retypedPassword;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}