<?php

namespace App\Entity;

use App\Repository\FriendRepository;
use DateTimeInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FriendRepository::class)
 * @UniqueEntity(
 *     fields={"name", "birthdayDate"},
 *      message="A friend with the same name and the same birthday date already exists."
 * )
 */
class Friend
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="date")
     */
    private $birthdayDate;

    /**
     * Friend constructor.
     * @param string $name
     * @param DateTimeInterface $birthdayDate
     */
    public function __construct(string $name, DateTimeInterface $birthdayDate)
    {
        $this->name = $name;
        $this->birthdayDate = $birthdayDate;
    }


    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getBirthdayDate(): DateTimeInterface
    {
        return $this->birthdayDate;
    }

    /**
     * @param DateTimeInterface $birthdayDate
     * @return $this
     */
    public function setBirthdayDate(DateTimeInterface $birthdayDate): self
    {
        $this->birthdayDate = $birthdayDate;

        return $this;
    }
}
