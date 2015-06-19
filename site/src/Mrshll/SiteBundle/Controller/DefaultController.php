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
      return $this->render('MrshllSiteBundle:Page:mockup.html.twig', array());
    }
}
