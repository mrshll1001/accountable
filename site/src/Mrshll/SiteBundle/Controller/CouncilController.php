<?php
namespace Mrshll\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mrshll\SiteBundle\Entity\Council;
use Mrshll\SiteBundle\Entity\Record;
use Symfony\Component\HttpFoundation\Response;

class CouncilController extends Controller
{
  /**
   * Creates a council in the database
   */
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

  /**
   * Removes a council from the database
   */
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

  /**
   * Adds a record to the council
   */
   public function addRecordAction()
   {
      // Get the data from the request
      $data = json_decode($this->get('request')->getContent());

      //  Create a new record and update its fields
      $record  =  new Record();
      $record->setVendor($data->vendor);
      $record->setAmount($data->amount);
      $record->setCategory($data->category);
      $record->setDate($data->date);
      $record->setService($data->service);
      $record->setDescription($data->description);

      // Retrieve the council from the database
      $council = $this->getDoctrine()->getRepository('MrshllSiteBundle:Council')->find($data->council);

      // Set the record to have this council, and persist the both of them.
      $record->setCouncil($council);

      $em = $this->getDoctrine()->getManager();
      $em->persist($council);
      $em->persist($record);

      // Flush, to action the changes
      $em->flush();

     return new Response('Record has been added successfully');
   }

   /**
    * Removes a record from the council
    */
    public function removeRecordAction()
    {
      // ...
      return new Response('Record has been removed successfully');
    }


}
