<?php

namespace Mrshll\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mrshll\SiteBundle\Helper\NorthumbriaCSVParser;
use Mrshll\SiteBundle\Entity\Record;


class ScraperController extends Controller
{

  /**
   * Parse a given northumbria csv file
   */
   public function parseOneNorthumbriaAction()
   {
     //  Fetch the URL from the JSOn data
     $data = json_decode($this->get('request')->getContent());
     $parser = new NorthumbriaCSVParser($data->url);

     // Fetch the CSV data from the URL
     $parser->fetchData();
     $councilData = $parser->getData();

     // Get the entity manager to save the records
     $em = $this->getDoctrine()->getManager();
     $council = $this->getDoctrine()->getRepository('MrshllSiteBundle:Council')->findOneByName('Northumbria County Council');
     // Begin creating Record entities for storage
     foreach($councilData as $item)
     {
       $record = new Record();
      //  $record->setVendor

      //  FINISH ME!!!!!
      return true;
     }
   }

   /**
    * 

}
