<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AccountDebtRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class AccountDebt
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
     * @ORM\ManyToOne(targetEntity="App\Entity\SavingAccount", inversedBy="accountDebts")
     */
    private $debtAccount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reason;

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
     * @ORM\Column(type="float")
     */
    private $originalAmount;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="accountDebt")
     */
    private $accountTransaction;

    public function __construct()
    {
        $this->AccountTransaction = new ArrayCollection();
    }

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

    public function getDebtAccount(): ?SavingAccount
    {
        return $this->debtAccount;
    }

    public function setDebtAccount(?SavingAccount $debtAccount): self
    {
        $this->debtAccount = $debtAccount;

        return $this;
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

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): self
    {
        $this->reason = $reason;

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

    public function getOriginalAmount(): ?float
    {
        return $this->originalAmount;
    }

    public function setOriginalAmount(float $originalAmount): self
    {
        $this->originalAmount = $originalAmount;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getAccountTransaction(): Collection
    {
        return $this->accountTransaction;
    }

    public function addAccountTransaction(Transaction $accountTransaction): self
    {
        if (!$this->accountTransaction->contains($accountTransaction)) {
            $this->accountTransaction[] = $accountTransaction;
            $accountTransaction->setAccountDebt($this);
        }

        return $this;
    }

    public function removeAccountTransaction(Transaction $accountTransaction): self
    {
        if ($this->accountTransaction->contains($accountTransaction)) {
            $this->accountTransaction->removeElement($accountTransaction);
            // set the owning side to null (unless already changed)
            if ($accountTransaction->getAccountDebt() === $this) {
                $accountTransaction->setAccountDebt(null);
            }
        }

        return $this;
    }
}
