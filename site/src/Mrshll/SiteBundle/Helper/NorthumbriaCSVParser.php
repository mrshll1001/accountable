<?php

/**
* Class to scrape a CSV file based on the url given; specific to the council
*/

namespace Mrshll\SiteBundle\Helper;


class NorthumbriaCSVParser
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

    // Convert the string of 'Amount Exc' to an actual numeric value we can run calculations on
    // Apparently we need yet another array, because of some weird PHP behaviour where I'm unable to modify the original records in $mappedData
    $fixedData = array();
    foreach ($mappedData as $record)
    {
      $record['cost-value'] = $this->convertCostToNumeric($record['Amount Exc']);
      $record['date'] = $this->convertDateFormat($record['Payment ']);
      array_push($fixedData, $record);
    }


    // Reset $this->data to be the mapped data
    $this->data = $fixedData;
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


  /**
  * Takes the information in $this->data and converts the comma separated strings into numeric values
  *
  * @return boolean success
  */
  private function convertCostToNumeric($costString)
  {
    return floatval(str_replace(',', '', $costString));
  }

  /**
   * Takes in the Northumbria date format, parses it and returns an appropriate DateTime oci_fetch_object
   * @return DateTime date
   */
   private function convertDateFormat($dateString)
   {
      //  Explode the string
       $tokens = explode('-', $dateString);

      //  Get the day and year as that's easy
      $day = $tokens[0];
      $year = '20'.$tokens[2];

      // Map the month to a number
      $month = 0;
      // var_dump($tokens[1]);
      switch ($tokens[1]) {
        case 'Jan':
          $month = 1;
          break;
        case 'Feb':
          $month = 2;
          break;
        case 'Mar':
          $month = 3;
          break;
        case 'Apr':
          $month = 4;
          break;
        case 'May':
          $month = 5;
          break;
        case 'Jun':
          $month = 6;
          break;
        case 'Jul':
          $month = 7;
          break;
        case 'Aug':
          $month = 8;
          break;
        case 'Sep':
          $month = 9;
          break;
        case 'Oct':
          $month = 10;
          break;
        case 'Nov':
          $month = 11;
          break;
        case 'Dec':
          $month = 12;
          break;
        default:
          $month = 0;
          break;

      }
      // var_dump($year);
      // Return the proper datestring
      return date_create($year."/".$month."/".$day);
   }
}
