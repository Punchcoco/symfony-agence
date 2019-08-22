<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch{

  /**
   *  @var int|null
   */
  private $maxPrice;

  /**
   *  @var int|null
   *  @Assert\Range(min=10,max=400)
   */
  private $minSurface;

  /**
   *  @return int|null
   */
  public function getMaxPrice(){
    return $this->maxPrice;
  }
  /**
   *  @return int|null
   */
  public function getMinSurface(){
    return $this->minSurface;
  }

  public function setMaxPrice(int $maxPrice){
    $this->maxPrice = $maxPrice;
    return $this;
  }
  public function setMinSurface(int $minSurface){
    $this->minSurface = $minSurface;
    return $this;
  }
}
 ?>
