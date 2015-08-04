<?php

namespace Mrshll\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mrshll\SiteBundle\Model\OrgModel;
use Mrshll\SiteBundle\Helper\CSVParser;
use Mrshll\SiteBundle\Helper\RecordHelper;
use Mrshll\SiteBundle\Entity\Council;
class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MrshllSiteBundle:Page:index.html.twig', array());
    }

  /**
   * Council list page
   *
   */
    public function viewCouncilsAction()
    {
      // Hard coding information now for speed rather than mess with trying to get them in the database.
      // $councilList = $this->getDoctrine()->getRepository('MrshllSiteBundle:Council')->findAll();

      return $this->render('MrshllSiteBundle:Page/Council:councillist.html.twig', array());
    }

    /**
     * View a council based off of councilcode
     */
     public function viewOneCouncilAction($councilcode)
     {
       $records = $this->getDoctrine()->getRepository('MrshllSiteBundle:CouncilRecord')->findByCouncilcode($councilcode);
       $helper = new RecordHelper($records);

       // Get the data for display
       $name = ucfirst($councilcode);
       $spendData = $helper->spendData();
       $serviceMap = $helper->serviceMap();
       $n = 10;
       $offenders = $helper->missingAndRedacted();
       $vendors = ['n'=>$n, 'byCost'=>$helper->topVendorsByCost($n), 'byFrequency'=>$helper->topVendorsByFrequency($n)];
       $serviceList = $helper->serviceList();

       // Set up the council list
       $councilList = array();
       $councilList['northumberland'] = "Northumberland";
       $councilList['newcastle'] = "Newcastle";
       unset($councilList[$councilcode]);


       return $this->render('MrshllSiteBundle:Page/Council:councilStats.html.twig', array('name'=>$name, 'spend'=>$spendData, 'servicemap'=>$serviceMap, 'vendors'=>$vendors, 'serviceList'=>$serviceList, 'offenders'=>$offenders, 'councils'=>$councilList));
     }

     /**
      * View the Non-Profit Organisation page
      */
      public function viewNonProfitAction()
      {
        return $this->render('MrshllSiteBundle:Page/NPO:npo.html.twig', array());
      }

      /**
       * View a specific non Profit Page
       */
       public function viewOneCharityAction($charitycode)
       {
         return $this->render('MrshllSiteBundle:Page/NPO:npoStats.html.twig');
       }

    /**
    * Test Action. Not to remain in the final Bundle
    */
    public function testAction()
    {
      // $parser = new NorthumbriaCSVParser('http://www.northumberland.gov.uk/idoc.ashx?docid=481680e7-8ca1-4bc1-a9f9-c31527163455&version=-1');
      // $parser = new CSVParser($this->getDoctrine()->getManager());
      // $parser->getNorthumbriaData();
      return $this->render('MrshllSiteBundle:Page:test.html.twig', array());
    }

}
