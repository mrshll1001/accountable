<?php

/**
 * Class to assist the parsing of CSV files into Record Objects
 */

 namespace Mrshll\SiteBundle\Helper;

 use Mrshll\SiteBundle\Entity\CouncilRecord;
 class CSVParser
 {
   private $em;

   private $northumbriaCode = 'NORTHUMBRIA';
   private $newcastleCode = 'NEWCASTLE';



   public function __construct(\Doctrine\ORM\EntityManager $em)
   {
     $this->em = $em;
   }
   /**
    * Retrieves all the Northumbria CSVs
    *
    */
    public function getNorthumbriaData()
    {
      // Get the folder where the CSVs are stored
      $dir = __DIR__.'/../../../../web/csv/northumbria/';
      $files = scandir($dir);

      // Iterate over the directory and parse the content
      foreach($files as $file)
      {
        if($file !== '.' && $file !== '..' && $file !== '.DS_Store')
        {
          // Parse the data, can't store it all as it's too big.
          $data = $this->parseNorthumbriaCSV($dir.$file);

          // var_dump(array_keys($data[0]));

          // Fix the data
          $data = $this->fixNorthumbriaData($data);

          // Next, since we can't pass it out (lack of memory I think)
          // We instead pass it to Doctrine to keep a hold of
          $this->storeFixedData($data, $this->northumbriaCode);

        }

      }

      return count($data).' records have been stored successfully';
    }


    /**
     * Stores Parsed (and fixed) data
     *
     */
     private function storeFixedData($data, $councilCode)
     {
       // Iterate over each item in data and update it in the database
       foreach($data as $item)
       {
        //  Dispense a CouncilRecord
        $record = new CouncilRecord();

        // Set the guff
        $record->setCouncilcode($councilCode);
        $record->setVendor($item['vendor']);
        $record->setValue($item['value']);
        $record->setService($item['service']);
        $record->setDescription($item['description']);
        $record->setReference($item['reference']);

        // Persist that mother
        $this->em->persist($record);
       }
       $this->em->flush();
       return;
     }

    /**
     * Fixes Parsed Northumbria data
     */
     private function fixNorthumbriaData($data)
     {
       $fixedData = array();

       // Iterate over the data array, and convert all the keys to stuff we can understand, encode to UTF8 so the database is OK, and trim whitespace to avoid problems elsewhere
       foreach($data as $item)
       {
         $fixedItem = array();
         $fixedItem['vendor'] = utf8_encode(trim($item['Vendor Name']));
         $fixedItem['value'] = floatval(str_replace(',', '', $item['Amount Exc']));
         $fixedItem['service'] = trim($item['Service Responsible for Spend']);
         $fixedItem['description'] = utf8_encode(trim($item['Subjective']));
         $fixedItem['reference'] = trim($item['Invoice']);

         array_push($fixedData, $fixedItem);
       }

       return $fixedData;

     }

    /**
     * Parses a single Northumbria CSV file, returns the array without modification
     */
    private function parseNorthumbriaCSV($csv)
    {
      // Connect to file and retrieve data
      $data = array_map('str_getcsv', file($csv));

      // Set the headers, remove guff data and clean up.
      $headers = $data[4];


      // Unset all the useless guff (indices 0-5) that comes with it, including the headers as we have them.
      for ($i=0; $i < 6; $i++)
      {
        unset($data[$i]);
      }

      // Build up our new data array, each item in data being remapped to keys.
      $mappedData = array();
      foreach($data as $item)
      {
        $record = array(); // New array to hold the values for this record
        for ($i=0; $i < count($item); $i++) {
          $record[$headers[$i]] = $item[$i]; // Allocated the contents of item keys in the new record
        }
        array_push($mappedData, $record); // Complete and push data to the new data array
      }


      return $mappedData;

    }


 }
