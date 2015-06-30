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
      }elseif ($record->getValue() < $values['smallest'])
      {
        $values['smallest'] = $record->getValue();
      }

    }

    // Set the average
    $values['average'] = $values['total'] / $values['count'];

    return $values;
  }
}
