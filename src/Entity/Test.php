<?php
/**
 * B2B nomenclatures entity
 * @author Martin Vágovszký
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="test")
 */
class Test
{

   /**
     * @ORM\Id
     * @ORM\Column(name="number", type="string", length=50, nullable=true)
     */
    private $id = null;


    /**
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     */
    private $name = null;

    /**
     * Gets as number
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets a new number
     *
     * @param string $number
     * @return self
     */
    public function setid($number)
    {
        $this->id = $number;
        return $this;
    }


    /**
     * Gets as name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets a new name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

 
}

