<?php

namespace Medidor\Entity;

use Doctrine\Common\Collection\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="medidor")
 */
class Medidor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /** @ORM\Column(type="bigint", name="numero_servicio") */
    private $numeroServicio;
    /** @ORM\Column(length=128) */
    private $titular;
    /** @ORM\Column(type="integer") */
    private $tarifa;
    /** @ORM\Column(type="integer", name="ultima_lectura") */
    private $ultimaLectura;
    /** @ORM\column(type="datetime", name="fecha_ultima_lectura") */
    private $fechaUltimaLectura;
    /** @ORM\Column(type="integer", name="lectura_recibo") */
    private $lecturaRecibo;
    /** @ORM\Column(type="date", name="fecha_recibo") */
    private $fechaRecibo;
    /** @ORM\Column(type="integer", name="consumo_actual") */
    private $consumoActual;
    /** @ORM\Column(type="decimal", name="costo_actual") */
    private $costoActual;
    /** @ORM\Column(type="decimal", name="costo_proyectado") */
    private $costoProyectado;
    /**
     * @ORM\OneToMany(targetEntity="Lectura", mappedBy="medidor")
     */
    private $lecturas;
    /**
     * @ORM\OneToMany(targetEntity="Recibo", mappedBy="medidor")
     * @ORM\OrderBy({"periodoHasta" =  "DESC"})
     */
    private $recibos;
    
    public function __construct()
    {
        $this->lecturas = new ArrayCollection();
        $this->recibos = new ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getNumeroServicio()
    {
        return $this->numeroServicio;
    }
    
    public function setNumeroServicio( $numeroServicio )
    {
        $this->numeroServicio = $numeroServicio;
    }
    
    public function getTitular()
    {
        return $this->titular;
    }
    
    public function setTitular( $titular )
    {
        $this->titular = $titular;
    }
    
    public function getTarifa()
    {
        return $this->tarifa;
    }
    
    public function setTarifa( $tarifa )
    {
        $this->tarifa = $tarifa;
    }
    
    public function getUltimaLectura()
    {
        return $this->ultimaLectura;
    }
    
    public function setUltimaLectura($ultimaLectura)
    {
        $this->ultimaLectura = $ultimaLectura;
    }
    
    public function getFechaUltimaLectura()
    {
        return $this->fechaUltimaLectura;
    }
    
    public function setFechaUltimaLectura($fechaUltimaLectura)
    {
        $this->fechaUltimaLectura = $fechaUltimaLectura;
    }
    
    public function getLecturaRecibo()
    {
        return $this->lecturaRecibo;
    }
    
    public function setLecturaRecibo($lecturaRecibo)
    {
        $this->lecturaRecibo = $lecturaRecibo;
    }
    
    public function getFechaRecibo()
    {
        return $this->fechaRecibo;
    }
    
    public function setFechaRecibo($fechaRecibo)
    {
        $this->fechaRecibo = $fechaRecibo;
    }
    
    public function getConsumoActual()
    {
        return $this->consumoActual;
    }
    
    public function setConsumoActual($consumoActual)
    {
        $this->consumoActual = $consumoActual;
    }
    
    public function getCostoActual()
    {
        return $this->costoActual;
    }
    
    public function setCostoActual($costoActual)
    {
        $this->costoActual = $costoActual;
    }
    
    public function getCostoProyectado()
    {
        return $this->costoProyectado;
    }
    
    public function setCostoProyectado($costoProyectado)
    {
        $this->costoProyectado = $costoProyectado;
    }
    
    public function getLecturas()
    {
        return $this->lecturas;
    }
    
    public function removeLectura(Lectura $lectura)
    {
        if (false === $this->lecturas->contains($lectura)) {
            return;
        }
        $this->lecturas->removeElement($lectura);
    }
    
    public function addLectura(Lectura $lectura)
    {
        if (true === $this->lecturas->contains($lectura)) {
            return;
        }
        $this->lecturas->add($lectura);
    }

    public function getRecibos()
    {
        return $this->recibos;
    }

    public function removeRecibo(Recibo $recibo) 
    {
        if (false === $this->recibos->contains($recibo)) {
            return;
        }
        $this->recibos->removeElement($recibo);
    }
    
    public function addRecibo(Recibo $recibo)
    {
        if (true === $this->recibos->contains($recibo)) {
            return;
        }
        $this->recibos->add($recibo);
    }
    
    public function exchangeArray(array $data)
    {
        $this->id             = !empty($data['id']) ? $data['id'] : null;
        $this->numeroServicio = !empty($data['numeroServicio']) ? $data['numeroServicio'] : null;
        $this->titular        = !empty($data['titular']) ? $data['titular'] : null;
        $this->tarifa         = !empty($data['tarifa']) ? $data['tarifa'] : null;
    }
}