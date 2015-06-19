<?php

namespace Mrshll\SiteBundle\Model;

use Neoxygen\NeoClient\ClientBuilder;

class OrgModel {


  /**
  * Properties
  */
  private $id;
  private $name;
  private $description;
  private $website;
  private $totalEmployees;

  //======================================================
  // Basic Getter and setter stuff here
  //======================================================

  public function __construct($id = null)
  {
    // Do nothing for now
  }

  public function setName($name)
  {
    $this->name = $name;
  }

  public function getName()
  {
    return $this->name;
  }

  public function setDescription($description)
  {
    $this->description = $description;
  }

  public function getDescription()
  {
    return $this->description;
  }

  public function getWebsite()
  {
    return $this->website;
  }


  public function setWebsite($website)
  {
    $this->website = $website;
  }

  public function getTotalEmployees()
  {
    return $this->totalEmployees;
  }

  // ====================================================
  // Functions to interact with the graph here -- rememeber you should be returning arrays of nodes and edges from this node to the others ;-)
  // ====================================================

  public function addToGraph()
  {
    // Code to add project to the graph here. rememeber to do the null check on the id, only upload to graph if null as otherwise you'll be creating a new node.
  }

  public function addProject($project)
  {
    // Code to add a project here
  }

  public function getAllProjects()
  {
    return 0;
  }


  public function getActiveProjects()
  {
    return 0;
  }

  public function getInactiveProjects()
  {
    return 0;
  }

  public function getPendingProjects()
  {
    return 0;
  }

  public function getTotalIncome()
  {
    return 0.00;
  }

  public function getTotalExpenditure()
  {
    return 0.00;
  }

  public function getAvgSpendPerProject()
  {
    return 0.00;
  }


}
