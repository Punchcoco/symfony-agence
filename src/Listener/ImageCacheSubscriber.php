<?php
namespace App\Listener;

use Doctrine\Common\EventSubscriber;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class ImageCacheSubscriber implements EventSubscriber{

  private $cacheManager;

  private $uploaderHelper;

  public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper){

    $this->cacheManager = $cacheManager;
    $this->uploaderHelper = $uploaderHelper;
  }

  public function getSubscribedEvents()
  {
    return [
      'preRemove',
      'preUpdate'
    ];
  }

  public function preRemove(LifecycleEventArgs $args){
    $entity = $args->getEntity();
    if(!$entity instanceof Property){
      return;
    }
    $this->cacheManager->remove($this->uploaderHelper->asset($entity,'imageFile'));

  }

  public function preUpdate(PreUpdateEventArgs $args){
    $entity = $args->getEntity();
    if(!$entity instanceof Property){
      return;
    }
    if($entity->getImageFile() instanceof UploadedFile){
      $this->cacheManager->remove($this->uploaderHelper->asset($entity,'imageFile'));
    }

  }
}
?>
