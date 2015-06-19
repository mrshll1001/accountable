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

  // ====================================================
  // Static functions
  // ====================================================

  public static function getAll()
  {
    // Build the NeoClient
    $client = ClientBuilder::create()->addConnection('default', 'http', 'localhost', 7474, true, 'neo4j', 'BigdekubabA666')->setAutoFormatResponse(true)->build();

    // Query for all organisations
    $q = "MATCH (n:PERSON) return n";
    $result = $client->sendCypherQuery($q)->getResult();

    $orgs = array();
    foreach($result->getNodes() as $node)
    {
      $orgs[] = ['name'=>$node->getProperty('name'), 'id'=>$node->getId()];
    }

    return $orgs;

  }

  public static function getAllAsGraph()
  {
    // Build the NeoClient
    $client = ClientBuilder::create()->addConnection('default', 'http', 'localhost', 7474, true, 'neo4j', 'BigdekubabA666')->setAutoFormatResponse(true)->build();

    // Query for all organisations
    $q = "MATCH (n:PERSON) OPTIONAL MATCH (n)-[r]->(:PERSON) return n,r";
    $client->sendCypherQuery($q);

    // Map the organisations to arrays of nodes and edges
    $result = $client->getResult();

    $nodes = array();

    foreach($result->getNodes() as $node)
    {
      $nodes[] = ['name' => $node->getProperty('name'), 'id'=>$node->getId()];
    }

    $edges = array();
    foreach ($result->getRelationships() as $edge) {
      $edges[] = ['source'=>$edge->getStartNode()->getId(), 'target'=>$edge->getEndNode()->getId()];
    }

    return array('nodes'=>$nodes, 'edges'=>$edges);

  }


}
