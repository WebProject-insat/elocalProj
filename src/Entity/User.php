<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *     fields={"email"},
 *     message="The entred email is already used")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="5",minMessage="Your password is too short")
     * @Assert\EqualTo(propertyPath="confirm_password",message="Please verify the entred password")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password",message="Please verify the entred password")
     */
    private $confirm_password;

    /**
     * @return mixed
     */
    public function getConfirmPassword()
    {
        return $this->confirm_password;
    }

    /**
     * @param mixed $confirm_password
     */
    public function setConfirmPassword($confirm_password): void
    {
        $this->confirm_password = $confirm_password;
    }

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(min="8",max="8",exactMessage="This phone number is invalid")
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $profession;

    /**
     * @ORM\ManyToOne(targetEntity=Gender::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gender;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $about;

    /**
     * @ORM\OneToMany(targetEntity=Announcement::class, mappedBy="UserOwner")
     */
    private $owner;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url(message="This is not a valid Url!")
     */
    private $image;

    /**
     * @ORM\OneToOne(targetEntity=Announcement::class, inversedBy="userColoc", cascade={"persist", "remove"})
     */
    private $coloc;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->owner = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(int $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(?string $about): self
    {
        $this->about = $about;

        return $this;
    }

    /**
     * @return Collection|Announcement[]
     */
    public function getOwner(): Collection
    {
        return $this->owner;
    }

    public function addOwner(Announcement $owner): self
    {
        if (!$this->owner->contains($owner)) {
            $this->owner[] = $owner;
            $owner->setUserOwner($this);
        }

        return $this;
    }

    public function removeOwner(Announcement $owner): self
    {
        if ($this->owner->contains($owner)) {
            $this->owner->removeElement($owner);
            // set the owning side to null (unless already changed)
            if ($owner->getUserOwner() === $this) {
                $owner->setUserOwner(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getColoc(): ?Announcement
    {
        return $this->coloc;
    }

    public function setColoc(?Announcement $coloc): self
    {
        $this->coloc = $coloc;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}
