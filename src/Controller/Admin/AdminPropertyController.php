<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\PropertyRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Property;
use App\Form\PropertyType;

class AdminPropertyController extends AbstractController
{

  private $repository;
  private $em;

  public function __construct(PropertyRepository $repository, ObjectManager $em){

      $this->repository = $repository;
      $this->em = $em;
  }

  /**
   * @Route("/admin", name="admin.property.index")
   */
  public function index(){

    $properties = $this->repository->findAll();
    return $this->render('admin/property/index.html.twig', compact('properties'));
  }

  /**
   * @Route("/admin/property/create", name="admin.property.new")
   */
  public function new(Request $request){

    $property = new Property();
    $form = $this->createForm(PropertyType::class, $property);

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){

      $this->em->persist($property);
      $this->em->flush();
      $this->addFlash('success', 'Bien créer avec succés');
      return $this->redirectToRoute('admin.property.index');
    }

    return $this->render('admin/property/new.html.twig', [
      'property' => $property,
      'form' => $form->createView()
    ]);
  }

  /**
   * @Route("/admin/property/{id}", name="admin.property.edit", methods="GET|POST")
   */
  public function edit(Property $property, Request $request)
  {


    $form = $this->createForm(PropertyType::class, $property);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){
      $this->em->flush();
      $this->addFlash('success', 'Bien modifié avec succés');
      return $this->redirectToRoute('admin.property.index');
    }

    return $this->render('admin/property/edit.html.twig', [
      'property' => $property,
      'form' => $form->createView()
    ]);
  }

  /**
   * @Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
   */
  public function delete(Property $property, Request $request)
  {
    if($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))){

      $this->em->remove($property);
      $this->em->flush();
      $this->addFlash('success', 'Bien supprimé avec succés');
    }

    return $this->redirectToRoute('admin.property.index');
  }


}
 ?>
