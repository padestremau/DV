<?php

namespace DV\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pagina
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DV\MainBundle\Entity\PaginaRepository")
 */
class Pagina
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=255)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="contenido", type="text")
     */
    private $contenido;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ultimaModificacion", type="datetime")
     */
    private $ultimaModificacion;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Pagina
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Pagina
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set contenido
     *
     * @param string $contenido
     * @return Pagina
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;

        return $this;
    }

    /**
     * Get contenido
     *
     * @return string 
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Set ultimaModificacion
     *
     * @param \DateTime $ultimaModificacion
     * @return Pagina
     */
    public function setUltimaModificacion($ultimaModificacion)
    {
        $this->ultimaModificacion = $ultimaModificacion;

        return $this;
    }

    /**
     * Get ultimaModificacion
     *
     * @return \DateTime 
     */
    public function getUltimaModificacion()
    {
        return $this->ultimaModificacion;
    }
}
