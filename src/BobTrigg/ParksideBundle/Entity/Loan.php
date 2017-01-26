<?php

namespace BobTrigg\ParksideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Loan
 *
 * @ORM\Table(name="loans")
 * @ORM\Entity(repositoryClass="BobTrigg\ParksideBundle\Repository\LoanRepository")
 */
class Loan
{
    /**
     * @var Status
     * 
     * @ORM\ManyToOne(targetEntity="Status", inversedBy="loans")
     * @ORM\JoinColumn(name="status", referencedColumnName="id") 
     */
    private $status;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float")
     * @Assert\Range(
     *      min = 1,
     *      minMessage = "Loan amount must be greater than 0"
     * )
     */
    private $amount;

    /**
     * @var float
     *
     * @ORM\Column(name="property_value", type="float")
     * @Assert\Range(
     *      min = 1,
     *      minMessage = "Property value must be greater than 0"
     * )
     */
    private $propertyValue;

    /**
     * @var string
     *
     * @ORM\Column(name="SSN", type="string", length=11)
     * @Assert\Length(
     *   min = 9,
     *   minMessage = "Social Security Number must be exactly 9 digits."
     * )
     * @Assert\Length(
     *   max = 9,
     *   maxMessage = "Social Security Number must be exactly 9 digits."
     * )
     */
    private $sSN;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function setAcceptanceStatus() {
        
        $repository = $this->getDoctrine()->getManager()->getRepository('BobTriggParksideBundle:Status');
        
        if ($this->amount < ($this->propertyValue * .4)) {
           $this->status = $repository->findOneByStatus('Accepted');
        } else {
           $this->status = $repository->findOneByStatus('Rejected');
        }
    }

    /**
     * Set amount
     *
     * @param float $amount
     *
     * @return Loan
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set propertyValue
     *
     * @param float $propertyValue
     *
     * @return Loan
     */
    public function setPropertyValue($propertyValue)
    {
        $this->propertyValue = $propertyValue;

        return $this;
    }

    /**
     * Get propertyValue
     *
     * @return float
     */
    public function getPropertyValue()
    {
        return $this->propertyValue;
    }

    /**
     * Set sSN
     *
     * @param string $sSN
     *
     * @return Loan
     */
    public function setSSN($sSN)
    {
        $this->sSN = $sSN;

        return $this;
    }

    /**
     * Get sSN
     *
     * @return string
     */
    public function getSSN()
    {
        return $this->sSN;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Loan
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
}
