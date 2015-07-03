<?php
namespace Mrshll\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Mrshll\SiteBundle\Entity\Record;
use Mrshll\SiteBundle\Helper\RecordHelper;

class CouncilRecordController extends Controller
{

    /**
     * Compares and gets the percentage difference between two sets of records by the council code and the service
     */
     public function compareRecordsByServiceAction()
     {
       // Get the JSON data which contains the council codes and records to compare
       $data = json_decode($this->get('request')->getContent());


       // Get a repository of the records
       $repo = $this->getDoctrine()->getRepository('MrshllSiteBundle:CouncilRecord');

       // Find by Council and service
       $recordsOne = $repo->findBy('councilcode'=>$data->councilOne, 'service'=>$data->serviceOne);
       $recordsTwo = $rep->findBy('councilcode'=>$data->councilTwo, 'service'=>$data->serviceTwo);

       // Instantiate a RecordHelper to perform the calculations, get the percentage difference
       $helper = new RecordHelper($recordsOne);
       $difference = $helper->percentageDifference($recordsTwo);

       return json_encode(array('difference'=>$difference));

     }

}
