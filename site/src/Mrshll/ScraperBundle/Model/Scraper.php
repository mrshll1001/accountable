<?php

/**
* Class to scrape a CSV file based on the url given; specific to the council
*/

namespace Mrshll\ScraperBundle\Model;


class Scraper
{
  private $file;
  private $url;
  private $data;


  public function __construct($url = null)
  {
    $this->url = $url;
  }


  /**
  * Fetches the CSV at the designated URL, turns it into an array and stores it
  * in the $data variable. Returns a boolean to indicate success
  *
  * @return boolean success
  */
  public function fetchData()
  {
    // Connect to the file and get the data.
    $this->data = array_map('str_getcsv', file($this->url));
    $headers = $this->data[4]; // Get the headers for the data

    // Unset all the useless guff (indices 0-5) that comes with it, including the headers as we have them.
    for ($i=0; $i < 6; $i++)
    {
      unset($this->data[$i]);
    }

    // Build up our new data array, each item in data being remapped to keys.
    $mappedData = array();
    foreach($this->data as $item)
    {
      $record = array(); // New array to hold the values for this record
      for ($i=0; $i < count($item); $i++) {
        $record[$headers[$i]] = $item[$i]; // Allocated the contents of item keys in the new record
      }
      array_push($mappedData, $record); // Complete and push data to the new data array
    }

    // Reset $this->data to be the mapped data
    $this->data = $mappedData;

    return true;
  }


  /**
  * Returns the data array for use elsewhere
  *
  * @return array $data
  */
  public function getData()
  {
    return $this->data;
  }
}
