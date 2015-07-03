<?php

/**
 * Class to assist the parsing of CSV files into Record Objects
 */

 namespace Mrshll\SiteBundle\Helper;

 use Mrshll\SiteBundle\Entity\CouncilRecord;
 class CSVParser
 {
   private $em;

   private $northumbriaCode = 'northumberland';
   private $newcastleCode = 'newcastle';



   public function __construct(\Doctrine\ORM\EntityManager $em)
   {
     $this->em = $em;
   }

   /**
    * Retrieves all the Northumbria CSVs and stores them in the database.
    *
    */
    public function getNorthumberlandData()
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

      // Return something in case we're being called via AJAX and we need a notification
      return count($data).' records have been stored successfully';
    }

    /**
     * Retrieves all of the NCL CSV files and stores them in the database
     *
     */
     public function getNewcastleData()
     {
       // Get the folder where the CSV files are stored
       $dir = __DIR__.'/../../../../web/csv/newcastle/';
       $files = scandir($dir);

       // Iterate over each directory and parse the content, ignoring system files
       foreach($files as $file)
       {
         if($file !== '.' && $file !== '..' && $file !== '.DS_Store')
         {
           // Parse the csv using a newcastle csv parse
           $data = $this->parseNewcastleCSV($dir.$file);

          //  var_dump(array_keys($data[0]));
          // var_dump($data[0]);

          // Fix the data so we can actually use it
          $data = $this->fixNewcastleData($data);
          // var_dump($data[9]);

          // Store the data in the database
          $this->storeFixedData($data, $this->newcastleCode);
         }
       }
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
      * Fixes Parsed Newcastle Data
      */
      private function fixNewcastleData($data)
      {
        $fixedData = array();

        // Iterate over the data array, convert all the keys to our common format, encode to UTF8 where necessary and trim
        foreach($data as $item)
        {
          $fixedItem = array();
          $fixedItem['vendor'] = utf8_encode(trim($item['Supplier Name']));
          $fixedItem['value'] = floatval(str_replace(',','',$item['Total']));
          $fixedItem['service'] = utf8_encode(trim($item['Directorate']));
          $fixedItem['description'] = utf8_encode(trim($item['Group Description']));
          $fixedItem['reference'] = trim($item['Internal Ref']);

          // Push it to the fixed data array
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

    /**
     * Parses a single Newcastle CSV file, returns the array without modification
     */
     private function parseNewcastleCSV($csv)
     {
       // Connect to file and retrieve data
       $data = array_map('str_getcsv', file($csv));

       // Get the headers and remove the guff; including headers as we have them stored now
       $headers = $data[2];
       unset($data[0]);
       unset($data[1]);
       unset($data[2]);

       // Build a mapped data array with the headers as a key
       $mappedData = array();
       foreach($data as $item)
       {
         $record = array(); // New array to hold value for this record
         for($i = 0; $i<count($item); $i++)
         {
           $record[$headers[$i]] = $item[$i]; // Allocate the contents of item keys in the new record
         }
         array_push($mappedData, $record); // Complete and push the new lovely data to the new array
       }

       return $mappedData;
     }


 }
