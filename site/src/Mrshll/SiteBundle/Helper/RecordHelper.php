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
   * Calculates the average spend of a set of records
   */
  public function spendData($records)
  {
    // Values array for returning data
    $values = array();

    // Count values and initialise total
    $values['count'] = count($records);
    $values['total'] = 0;
    $values['smallest'] = PHP_INT_MAX;
    $values['largest'] = 0;

    // Calculate the total, largest, and smallest spend
    foreach($records as $record)
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
   public function serviceMap($records)
   {
     // Build the mappings, if the key exists update the total, else create the key
     $mappings = array();
     foreach($records as $record)
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
    public function topVendorsByCost($records, $n)
    {
      // Set up the mappings
      $mappings = array();
      foreach($records as $record)
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
     public function topVendorsByFrequency($records, $n)
     {
       // Set up the mappings
       $mappings = array();
       foreach ($records as $record)
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
