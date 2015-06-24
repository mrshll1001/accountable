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
      $councilList = $this->getDoctrine()->getRepository('MrshllSiteBundle:Council')->findAll();

      return $this->render('MrshllSiteBundle:Page/Council:councillist.html.twig', array('councilList'=>$councilList));
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
      // Get a list of the councils
      $councilList = $this->getDoctrine()->getRepository('MrshllSiteBundle:Council')->findAll();
      return $this->render('MrshllSiteBundle:Page:test.html.twig', array('councilList'=>$councilList));
    }

}
