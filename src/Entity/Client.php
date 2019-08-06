<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use libphonenumber\PhoneNumber;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    /**
     * @var string|null
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     * @Assert\Uuid
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     */
    private $email;

    /**
     * @ORM\Column(type="phone_number")
     * @AssertPhoneNumber
     * @Assert\NotNull
     */
    private $phone;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $photoSaveDate;

    private $photoUrl;

    private $photoThumbnailUrl;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getPhone(): ?PhoneNumber
    {
        return $this->phone;
    }

    public function setPhone(PhoneNumber $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPhotoUrl()
    {
        
        return $this->photoUrl;
    }

    public function setPhotoUrl($photoUrl): self
    {
        $this->photoUrl = $photoUrl;

        return $this;
    }

    public function getPhotoThumbnailUrl()
    {
        return $this->photoThumbnailUrl;
    }

    public function setPhotoThumbnailUrl($photoThumbnailUrl): self
    {
        $this->photoThumbnailUrl = $photoThumbnailUrl;

        return $this;
    }

    public function getPhotoSaveDate()
    {
        return $this->photoSaveDate;
    }

    public function setPhotoSaveDate($photoSaveDateTime): self
    {
        $this->photoSaveDate = $photoSaveDateTime;

        return $this;
    }
}
