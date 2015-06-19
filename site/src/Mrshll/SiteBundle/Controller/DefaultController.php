<?php

namespace Mrshll\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Mrshll\SiteBundle\Model\OrgModel;

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

      $orgs = null;
      return $this->render('MrshllSiteBundle:Page/Org:orgList.html.twig', array());
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

}
