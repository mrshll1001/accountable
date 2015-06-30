<?php

namespace Mrshll\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mrshll\SiteBundle\Model\OrgModel;
use Mrshll\SiteBundle\Helper\NorthumbriaCSVParser;
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
   * View Northumbria Council
   *
   */
   public function viewNorthumbriaAction()
   {
     $council = $this->getDoctrine()->getRepository('MrshllSiteBundle:Council')->findOneByName('Northumbria County Council');
     return $this->render('MrshllSiteBundle:Page/Council:councilStats.html.twig', array('council'=>$council));
   }



    /**
    * Test Action. Not to remain in the final Bundle
    */
    public function testAction()
    {
      // $parser = new NorthumbriaCSVParser('http://www.northumberland.gov.uk/idoc.ashx?docid=481680e7-8ca1-4bc1-a9f9-c31527163455&version=-1');
      $parser = new NorthumbriaCSVParser();
      $parser->scrapeData();
      return $this->render('MrshllSiteBundle:Page:test.html.twig', array());
    }

}
