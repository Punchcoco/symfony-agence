<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PropertyRepository;

class HomeController extends AbstractController{


  /**
  * @Route("/", name="home")
  */
  public function index(PropertyRepository $repository): Response
  {
    $property = $repository->findAll();
      return $this->render('pages/home.html.twig',['properties' => $property]);
  }

}


 ?>
