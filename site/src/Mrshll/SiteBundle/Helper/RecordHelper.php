<?php

/**
* Class to perform calculations over sets of CouncilRecord objects
*
*/


namespace Mrshll\SiteBundle\Helper;

use Mrshll\SiteBundle\Entity\CouncilRecord;

class RecordHelper
{

  /**
   * Array of records that calculations are performed on
   */
  private $records;

  /**
   * Constructor, constructed with an array of records
   */
  public function __construct($records)
  {
    $this->records = $records;
  }

  /**
  * Calculates the average spend of a set of records
  */
  public function spendData()
  {
    // Values array for returning data
    $values = array();

    // Count values and initialise total
    $values['count'] = count($this->records);
    $values['total'] = 0;
    $values['smallest'] = PHP_INT_MAX;
    $values['largest'] = 0;

    // Calculate the total, largest, and smallest spend
    foreach($this->records as $record)
    {
      $values['total'] = $values['total'] + $record->getValue();

      // Perform checks for largest and smallest
      if($record->getValue() > $values['largest'])
      {
        $values['largest'] = $record->getValue();
      }elseif ($record->getValue() < $values['smallest'] && $record->getValue() > 0)
      {
        $values['smallest'] = $record->getValue();
      }

    }

    // Set the average
    $values['average'] = $values['total'] / $values['count'];

    return $values;
  }

  /**
  * Returns a map of totals spent on/by a given service, ordered by spend
  */
  public function serviceMap()
  {
    // Build the mappings, if the key exists update the total, else create the key
    $mappings = array();
    foreach($this->records as $record)
    {

      if(array_key_exists(trim($record->getService()), $mappings))
      {
        $mappings[trim($record->getService())] = $mappings[trim($record->getService())] + $record->getValue();
      }else
      {
        $mappings[trim($record->getService())] = $record->getValue();
      }
    }

    // Sort the mappings from highest to lowest
    arsort($mappings);

    // Now we have mappings, we need to extract the key-value pairs properly so we don't actually need to know the key later!
    $map = array();
    foreach ($mappings as $key => $value) {
      $map[] = ['name'=>$key, 'value'=>$value];
    }
    return $map;

  }

  /**
  * Returns a map of the top n used vendors, by cost
  */
  public function topVendorsByCost($n)
  {
    // Set up the mappings
    $mappings = array();
    foreach($this->records as $record)
    {
      if(array_key_exists(trim($record->getVendor()), $mappings))
      {
        $mappings[trim($record->getVendor())] = $mappings[trim($record->getVendor())] + $record->getValue();
      } else
      {
        $mappings[trim($record->getVendor())] = $record->getValue();
      }

    }

    // Sort in descending order
    arsort($mappings);

    // Return a subset with the appropriate details
    return $this->vendorSubset($mappings, $n);


  }

  /**
  * Returns a map of the top n used vendors, by frequency
  */
  public function topVendorsByFrequency($n)
  {
    // Set up the mappings
    $mappings = array();
    foreach ($this->records as $record)
    {
      // Check the array key exists
      if(array_key_exists(trim($record->getVendor()), $mappings))
      {
        $mappings[trim($record->getVendor())] = $mappings[trim($record->getVendor())] + 1;
      } else
      {
        $mappings[trim($record->getVendor())] = 1;
      }

    }

    // Sort the array in descending order
    arsort($mappings);

    // Return a subset of the array with appropriate details
    return $this->vendorSubset($mappings, $n);


  }


  /**
   * Finds and returns a subset of the records based on whether any information is missing
   */
  public function missingAndRedacted()
  {
    // Create an array for the offending records
    $offenders = array();

    // Loop over the records, and find any that have blank fields or contain redacted information
    foreach($this->records as $record)
    {
      // First check for missing information
      if($this->hasMissing($record) || $this->hasRedacted($record))
      {
        array_push($offenders, $record);
        // Next check for redacted information
      }
    }

    return $offenders;
  }

  /**
   * Compares the spending of two record sets based on the percentage difference. Uses the formula for percentage increase, will return a negative number if it's a percentage decrease.
   */
   public function compareRecords($otherRecords)
   {
     // Total both this set of records and the other set
     $thisTotal = $this->total($this->records);
     $otherTotal = $this->total($otherRecords);

     // Calculate the percentage increase
     $percentageIncrease = (($thisTotal - $otherTotal) / $thisTotal) * 100;
     
     return $percentageIncrease;
   }

  // ================================================================================================================
  //  Private Helper Functions
  // ================================================================================================================

  /**
   * Returns the total value spent on a group of records
   */
   private function totalValue($records)
   {
     $total = 0;
     foreach($records as $record)
     {
       $total = $total + $record->getValue();
     }
     return $total;
   }

  /**
   * returns a true or false value based on whether a record has a missing field
   */
   private function hasMissing($record)
   {
     if($record->getVendor() === "" || $record->getService() === "" || $record->getReference() === "" || $record->getDescription() === "")
     {
       return true;
     }else
     {
       return false;
     }
   }

   /**
    * returns a true or false value based on whether a record has the term 'redacted' in it.
    */
    private function hasRedacted($record)
    {
      if(strpos(strtolower($record->getVendor()), 'redacted') !== false || strpos(strtolower($record->getService()), 'redacted') !== false || strpos(strtolower($record->getReference()), 'redacted') !== false || strpos(strtolower($record->getDescription()), 'redacted') !== false)
      {
        return true;
      }else
      {
        return false;
      }
    }

  /**
  * Returns a subset of n array, mapped by vendor name and value
  */
  private function vendorSubset($mappings, $n)
  {
    $map = array();
    foreach(array_slice($mappings, 0, $n) as $key=>$value)
    {
      $map[] = ['name'=>$key, 'value'=>$value];
    }
    return $map;
  }


}
