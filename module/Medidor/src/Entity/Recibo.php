<?php
namespace Medidor\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Medidor\Repository\ReciboRepository")
 * @ORM\Table(name="recibo")
 */
class Recibo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /** @ORM\ManyToOne(targetEntity="Medidor", inversedBy="recibos") 
     *  @ORM\JoinColumn(name="medidor_id", referencedColumnName="id")
     */
    private $medidor;
    /** @ORM\Column(type="date") */
    private $bimestre;
    /** @ORM\Column(type="datetime", name="periodo_desde") */
    private $periodoDesde;
    /** @ORM\Column(type="datetime", name="periodo_hasta") */
    private $periodoHasta;
    /** @ORM\Column(type="integer", name="lectura_anterior") */
    private $lecturaAnterior;
    /** @ORM\Column(type="integer", name="lectura_actual") */
    private $lecturaActual;
    /** @ORM\Column(type="decimal") */
    private $importe;

    public function getId()
    {
        return $this->id;
    }

    public function getMedidor()
    {
        return $this->medidor;
    }

    public function setMedidor($medidor)
    {
        $this->medidor = $medidor;
    }

    public function getBimestre()
    {
        return $this->bimestre;
    }

    public function setBimestre($bimestre)
    {
        $this->bimestre = $bimestre;
    }

    public function getPeriodoDesde()
    {
        return $this->periodoDesde;
    }

    public function setPeriodoDesde($periodoDesde)
    {
        $this->periodoDesde = $periodoDesde;
    }

    public function getPeriodoHasta()
    {
        return $this->periodoHasta;
    }

    public function setPeriodoHasta($periodoHasta)
    {
        $this->periodoHasta = $periodoHasta;
    }

    public function getLecturaAnterior()
    {
        return $this->lecturaAnterior;
    }

    public function setLecturaAnterior($lecturaAnterior)
    {
        $this->lecturaAnterior = $lecturaAnterior;
    }

    public function getLecturaActual()
    {
        return $this->lecturaActual;
    }

    public function setLecturaActual($lecturaActual)
    {
        $this->lecturaActual = $lecturaActual;
    }

    public function getImporte()
    {
        return $this->importe;
    }

    public function setImporte($importe)
    {
        $this->importe = $importe;
    }
}
