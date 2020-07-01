<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Transaction
{
    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $payTo;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AccountDebt", inversedBy="AccountTransaction")
     */
    private $accountDebt;

    /**
     * @ORM\Column(type="float")
     */
    private $currentAmountMark;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;


    public function getId(): ?string
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPayTo(): ?string
    {
        return $this->payTo;
    }

    public function setPayTo(?string $payTo): self
    {
        $this->payTo = $payTo;

        return $this;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    public function getAccountDebt(): ?AccountDebt
    {
        return $this->accountDebt;
    }

    public function setAccountDebt(?AccountDebt $accountDebt): self
    {
        $this->accountDebt = $accountDebt;

        return $this;
    }

    public function getCurrentAmountMark(): ?float
    {
        return $this->currentAmountMark;
    }

    public function setCurrentAmountMark(float $currentAmountMark): self
    {
        $this->currentAmountMark = $currentAmountMark;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
