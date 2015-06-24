<?php
namespace Mrshll\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mrshll\SiteBundle\Entity\Council;
use Symfony\Component\HttpFoundation\Response;

class CouncilController extends Controller
{
  public function createAction()
  {
    // Get the JSON data from the request
    $data = json_decode($this->get('request')->getContent());

    // Create a council entity and set its name
    $council = new Council();
    $council->setName($data->name);

    // Store it
    $em = $this->getDoctrine()->getManager();
    $em->persist($council);
    $em->flush();

    // Return the response to the page
    return new Response('Council Created with ID: '.$council->getId());
  }

  public function deleteAction()
  {
    // Get the JSOn data from the request
    $data = json_decode($this->get('request')->getContent());

    // Retrieve the Council entity from the database
    $em = $this->getDoctrine()->getManager();
    $council = $this->getDoctrine()->getRepository('MrshllSiteBundle:Council')->find($data->id);

    // Remove it
    $em->remove($council);
    $em->flush();

    // Return the response
    return new Response('Council Item has been removed from the database');
  }
}
