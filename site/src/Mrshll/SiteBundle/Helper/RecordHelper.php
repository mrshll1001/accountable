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
   * Returns a map of totals spent on/by a given service
   */
   public function serviceMap($records)
   {
     // Build the mappings, if the key exists update the total, else create the key
     $mappings = array();
     foreach($records as $record)
     {
       if(array_key_exists($record->getService(), $mappings))
       {
         $mappings[$record->getService()] = $mappings[$record->getService()] + $record->getValue();
       }else
       {
         $mappings[$record->getService()] = $record->getValue();
       }
     }

     // Now we have mappings, we need to extract the key-value pairs properly so we don't actually need to know the key later!
     $map = array();
     foreach ($mappings as $key => $value) {
       $map[] = ['name'=>$key, 'value'=>$value];
     }
     return $map;

   }
}
