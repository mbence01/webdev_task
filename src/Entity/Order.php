<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $grossAmount;

    /**
     * @ORM\Column(type="integer")
     */
    private $netAmount;

    /**
     * @ORM\Column(type="integer")
     */
    private $taxAmount;

    /**
     * @ORM\Column(type="integer")
     */
    private $addressType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $addressName;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $addressPhone;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $addressTax;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $addressCountry;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $addressPostCode;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $addressCity;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $addressDesc;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFormattedId(): string
    {
        return sprintf("%05d", $this->id);
    }

    public function getGrossAmount(): ?int
    {
        return $this->grossAmount;
    }

    public function setGrossAmount(int $grossAmount): self
    {
        $this->grossAmount = $grossAmount;

        return $this;
    }

    public function getNetAmount(): ?int
    {
        return $this->netAmount;
    }

    public function setNetAmount(int $netAmount): self
    {
        $this->netAmount = $netAmount;

        return $this;
    }

    public function getTaxAmount(): ?int
    {
        return $this->taxAmount;
    }

    public function setTaxAmount(int $taxAmount): self
    {
        $this->taxAmount = $taxAmount;

        return $this;
    }

    public function getAddressType(): ?int
    {
        return $this->addressType;
    }

    public function setAddressType(int $addressType): self
    {
        $this->addressType = $addressType;

        return $this;
    }

    public function getAddressName(): ?string
    {
        return $this->addressName;
    }

    public function setAddressName(string $addressName): self
    {
        $this->addressName = $addressName;

        return $this;
    }

    public function getAddressPhone(): ?string
    {
        return $this->addressPhone;
    }

    public function setAddressPhone(?string $addressPhone): self
    {
        if($addressPhone == null) return $this;

        $this->addressPhone = $addressPhone;

        return $this;
    }

    public function getAddressTax(): ?string
    {
        return $this->addressTax;
    }

    public function setAddressTax(?string $addressTax): self
    {
        if($addressTax == null) return $this;

        $this->addressTax = $addressTax;

        return $this;
    }

    public function getAddressCountry(): ?string
    {
        return $this->addressCountry;
    }

    public function setAddressCountry(string $addressCountry): self
    {
        $this->addressCountry = $addressCountry;

        return $this;
    }

    public function getAddressPostCode(): ?string
    {
        return $this->addressPostCode;
    }

    public function setAddressPostCode(?string $addressPostCode): self
    {
        $this->addressPostCode = $addressPostCode;

        return $this;
    }

    public function getAddressCity(): ?string
    {
        return $this->addressCity;
    }

    public function setAddressCity(string $addressCity): self
    {
        $this->addressCity = $addressCity;

        return $this;
    }

    public function getAddressDesc(): ?string
    {
        return $this->addressDesc;
    }

    public function setAddressDesc(string $addressDesc): self
    {
        $this->addressDesc = $addressDesc;

        return $this;
    }
}
