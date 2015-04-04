<?php

/**
 * Description of Suggest
 * Provides methods for extracting recommendations based on museum distance from
 * the user, ratings and work times relative to the current time.
 * @author pgmank
 */
class Suggest {
    
    // Fields
    
   
    private $museumList;  // List of museum objects
    // private $historyList; // Array with keys that are museum ID's and values
                          // which are the keys' corresponding search frequency
    
    // Arrays that contain the values of each museum object
    // private $museumIdList; // Not needed yet
    private $timeOpenList;
    private $timeCloseList;
    private $distanceList;
    private $ratingList;
    
    private $weightList;    // Contains the suggestion weights of each museum
    // private $historyList; // Later Feature
    
    
    // Constructor //
    
    // The constructor
    public function __construct($museumList) {
        $this->museumList=&$museumList; // Copy museum array by reference
        
        $currentTime = date('G', time()); // Get current time, measured in hours
        $arraySize = count($museumList);
        
        
        // Initialize each list with its corresponding field from the museumList
        for($i=0 ; $i < $arraySize ; ++$i) {
            
            $this->timeOpenList[$i] = $this->museumList[$i]->getOpenHour();
            $this->timeCloseList[$i] = $this->museumList[$i]->getCloseHour();
            
            // If the museum is closed, remove it from the list
            if($currentTime < $this->timeOpenList[$i] 
                    || $currentTime > $this->timeCloseList){
                unset($museumList[$i]);
                unset($this->timeOpenList[$i]);
                unset($this->timeCloseList[$i]);
                continue;
            }
            
            $this->museumIdList[$i] = $museumList[$i]->getMuseumId();
            $this->distanceList[$i] = $museumList[$i]->getDistance();
            $this->ratingList[$i] = $museumList[$i]->getRating();
            
            $this->weightList[$i] = 0; // Initialize weights to zero
        }
    }
    
    // Accessor and Mutator Methods // None Till Now
    
    // Class Specific Methods //
    
    // Later feature may contain a second argument that is given by the client
    // user, showing the average time he spends on the museums. Then the
    // recommendation will be given based on time till close not close time.
    // 
    // Adds appropriate weights to the weightList according to time
    public function time() {
        asort($this->timeCloseList);  // Sort the array keeping the same keys-indices
        calcWeights($this->timeCloseList);
    }
    
    // Adds appropriate weights to the weightList according to distance
    public function distance() {
        asort($this->distanceList);   // Sort the array
        calcWeights($this->distanceList);
    }
    
    // Adds appropriate weights to the weightList according to rating
    public function rating() {
        asort($this->ratingList);
        calcWeights($this->ratingList);
    }
    
    // Later Feature //
    /*
    public function history() {
        
        return $historyWeightList;
    } */
    

    // Gets three boolean arguments as input to calculate the appropriate
    // combined weightList.
    // Returns the current Suggest object
    public function combined($byTime, $byDistance, $byRating) {
        
        if ($byTime) {
            time();
        }
        
        if ($byDistance) {
            distance();
        }
        
        if ($byRating) {
            rating();
        }
        return $this;
    }
    
    // Configures the weightList according to the executed suggestion function
    public function calcWeights(&$suggestList) {
        $i=0;
        $indices=array_keys($suggestList);
        foreach($indices as $index) {
            $this->weightList[$index]+= ++$i;
        }
    }
    
    // Returns the indices list containing the weights or an empty list if no
    // recommendation function was called
    public function getIndices() {
        
        // Test if there are now weights inside the weightList
        foreach( $this->weightList as $weight) {
            if ($weight == 0) {
                echo 'Please call a recommendation function';
                return array();
            }
        }
        
        // Sort the weight list, the smaller the weight the MORE important
        // the museum suggestion
        asort($this->weightList);
        
        $returnList=$this->weightList;  // Copy whole array to new one
        unset($this->weightList);   // Clean up weightList
        
        return array_keys($returnList);
        
    }
}
