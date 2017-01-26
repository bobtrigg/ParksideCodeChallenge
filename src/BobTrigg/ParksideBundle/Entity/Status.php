<?php

namespace BobTrigg\ParksideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Status
 *
 * @ORM\Table(name="statuses")
 * @ORM\Entity(repositoryClass="BobTrigg\ParksideBundle\Repository\StatusRepository")
 */
class Status
{
    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="Loan", mappedBy="status") 
     */
    private $loans;
    
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
     * @ORM\Column(name="status", type="string", length=20)
     */
    private $status;
    
    public function __construct() {
        $this->loans = new ArrayCollection();
    }

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
     * Set status
     *
     * @param string $status
     *
     * @return Status
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add loan
     *
     * @param \BobTrigg\ParksideBundle\Entity\Loan $loan
     *
     * @return Status
     */
    public function addLoan(\BobTrigg\ParksideBundle\Entity\Loan $loan)
    {
        $this->loans[] = $loan;

        return $this;
    }

    /**
     * Remove loan
     *
     * @param \BobTrigg\ParksideBundle\Entity\Loan $loan
     */
    public function removeLoan(\BobTrigg\ParksideBundle\Entity\Loan $loan)
    {
        $this->loans->removeElement($loan);
    }

    /**
     * Get loans
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLoans()
    {
        return $this->loans;
    }
    /**
     * Return status as a string
     * @return string
     */
    public function __toString() {
        return $this->getStatus();
    }
}
