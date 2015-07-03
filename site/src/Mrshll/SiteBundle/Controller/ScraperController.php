<?php

namespace Mrshll\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mrshll\SiteBundle\Helper\NorthumbriaCSVParser;
use Mrshll\SiteBundle\Entity\Record;
use Mrshll\SiteBundle\Helper\CSVParser;


class ScraperController extends Controller
{

   /**
    * Parses all records for a given council, based on code
    */
    public function parseCouncilAction($councilcode)
    {
      // Create the parser
      $parser = new CSVParser($this->getDoctrine()->getManager());

      // Switch on councilcode
      switch ($councilcode)
      {
        case 'northumberland':
          $parser->getNorthumberlandData();
          return 'Northumberland Data parsed';
          break;
        case: 'newcastle':
          $parser->getNewcastleData();
          return 'Newcastle Data parsed';
          break;
        default:
          return 'Invalid Council Code';
          break;
      }
    }

}
