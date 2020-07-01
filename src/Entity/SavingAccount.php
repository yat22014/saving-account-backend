<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SavingAccountRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class SavingAccount
{
    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $account;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AccountDebt", mappedBy="debtAccount", cascade={"persist", "remove"})
     */
    private $accountDebts;

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

    public function __construct()
    {
        $this->accountDebts = new ArrayCollection();
    }

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

    public function getAccount(): ?float
    {
        return $this->account;
    }

    public function setAccount(float $account): self
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @return Collection|AccountDebt[]
     */
    public function getAccountDebts(): Collection
    {
        return $this->accountDebts;
    }

    public function addAccountDebt(AccountDebt $accountDebt): self
    {
        if (!$this->accountDebts->contains($accountDebt)) {
            $this->accountDebts[] = $accountDebt;
            $accountDebt->setDebtAccount($this);
        }

        return $this;
    }

    public function removeAccountDebt(AccountDebt $accountDebt): self
    {
        if ($this->accountDebts->contains($accountDebt)) {
            $this->accountDebts->removeElement($accountDebt);
            // set the owning side to null (unless already changed)
            if ($accountDebt->getDebtAccount() === $this) {
                $accountDebt->setDebtAccount(null);
            }
        }

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
}
