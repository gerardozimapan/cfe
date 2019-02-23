<?php
namespace Medidor\Entity;

use Doctrine\Common\Collection\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tarifa")
 */
class tarifa
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /** @ORM\Column(length=256) */
    private $name;
    /** @ORM\Column(length=16) */
    private $acronym;
    /** @ORM\Column(type="decimal", name="fixed_cost") */
    private $fixedCost;
    /** @ORM\Column(type="text") */
    private $steps;

    /**
     * Returns tarifa Id
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets name
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns acronym.
     * @return string
     */
    public function getAcronym()
    {
        return $this->acronym;
    }

    /**
     * Sets acronym.
     * @param string $acronym
     */
    public function setAcronym($acronym)
    {
        $this->acronym = $acronym;
    }

    /**
     * Returns fixed cost.
     * @return float
     */
    public function getFixedCost()
    {
        return (float) $this->fixedCost;
    }

    /**
     * Sets fixed cost.
     * @param float $fixedCost
     */
    public function setFixedCost($fixedCost)
    {
        $this->fixedCost = $fixedCost;
    }

    /**
     * Returns steps.
     * @return array
     */
    public function getSteps()
    {
        return json_decode($this->steps);
    }

    /**
     * Sets steps.
     * @param array $steps
     */
    public function setSteps($steps)
    {
        $this->steps = json_encode($steps);
    }
}