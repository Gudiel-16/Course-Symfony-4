<?php

namespace App\Entity;

use App\Repository\CategoriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoriaRepository::class)
 */
class Categoria
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Producto", mappedBy="categoria")
     */
    private $productos;
    // targetEntitya es la clase One, mappedBy es el nombre a la que se hara referencia a la clase Producto

    public function __construct($nombre=null)
    {
        $this->nombre = $nombre;
        $this->productos = new ArrayCollection(); // para la relacion oneToMany, para que lo haga tipo array
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    // para la relacion oneToMany
    public function agregarProducto(Producto $producto){
        $this->productos[] = $producto; // agregamos producto al array
    }
}
