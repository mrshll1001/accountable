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

  public function setWebsite($website)
  {
    $this->website = $website;
  }

  // ====================================================
  // Functions to interact with the graph here
  // ====================================================

  public function getAllProjects()
  {
    return "This Organisation has no projects listed";
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
