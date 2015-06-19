<?php

namespace Mrshll\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Mrshll\SiteBundle\Model\OrgModel;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MrshllSiteBundle:Default:index.html.twig', array());
    }

    public function mockupAction()
    {
      $org = new OrgModel();
      return $this->render('MrshllSiteBundle:Page:mockup.html.twig', array());
    }
}
