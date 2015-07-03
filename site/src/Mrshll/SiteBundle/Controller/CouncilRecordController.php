<?php
namespace Mrshll\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Mrshll\SiteBundle\Entity\Record;

class CouncilRecordController extends Controller
{

    /**
     * Compares and gets the percentage difference between two sets of records
     */
     public function compareRecordsAction()
     {
       // Get the JSON data which contains the council codes and records to compare
       $data = json_decode();
     }

}
