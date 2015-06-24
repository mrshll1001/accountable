<?php

namespace Mrshll\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Mrshll\SiteBundle\Model\OrgModel;

use Mrshll\SiteBundle\Helper\CouncilCSVParser;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MrshllSiteBundle:Page:index.html.twig', array());
    }


    /**
    * Controller for the organisation Page
    */
    public function orgAction()
    {

      $orgs = OrgModel::getAll();
      return $this->render('MrshllSiteBundle:Page/Org:orgList.html.twig', array('orgs'=>$orgs));
    }



    public function mockupAction()
    {
      $org = new OrgModel();

      $org->setName("Marshall's Charity");
      $org->setDescription("This is the description of Marshall's Charity");
      $org->setWebsite("http://www.mrshll.uk");
      $org->getAllProjects();

      return $this->render('MrshllSiteBundle:Page/Org:org.html.twig', array('organisation'=>$org));
    }

    /**
    * Overview Page (GRAPHSSSS)
    */
    public function overviewAction()
    {

      $nodes = OrgModel::getAllAsGraph();
      return $this->render('MrshllSiteBundle:Page/Overview:overview.html.twig', array('nodes'=>$nodes));
    }


    /**
    * Test Action. Not to remain in the final Bundle
    */
    public function testAction()
    {

      $scraper = new CouncilCSVParser('http://www.northumberland.gov.uk/idoc.ashx?docid=481680e7-8ca1-4bc1-a9f9-c31527163455&version=-1');
      $scraper->fetchData();
      $output = $scraper->getData();
      var_dump($output[0]);
      return $this->render('MrshllSiteBundle:Page:test.html.twig', array());
    }

}
