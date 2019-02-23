<?php

namespace Medidor\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Medidor\Repository\MedidorRepository")
 * @ORM\Table(name="lectura")
 */
class Lectura
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /** @ORM\ManyToOne(targetEntity="Medidor", inversedBy="lecturas") */
    private $medidor;
    /** @ORM\Column(type="integer") */
    private $medicion;
    /** @ORM\Column(type="datetime") */
    private $fecha;
    
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
    
    public function getMedicion()
    {
        return $this->medicion;
    }
    
    public function setMedicion($medicion)
    {
        $this->medicion = $medicion;
    }
    
    public function getFecha()
    {
        return $this->fecha;
    }
    
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }
    
    public function exchangeArray(array $data)
    {
        $this->id       = ! empty($data['id']) ? $data['id'] : null;
        $this->medidor  = ! empty($data['medidor']) ? $data['medidor'] : null;
        $this->medicion = ! empty($data['medicion']) ? $data['medicion'] : null;
        $this->fecha    = ! empty($data['fecha']) ? $data['fecha'] : null;
    }
}