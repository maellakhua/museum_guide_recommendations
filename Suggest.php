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
    private $historyList; // Array with keys that are museum ID's and values
                          // which are the keys' corresponding search frequency
    
    // Arrays that contain the values of each museum object
    private $museumIdList;
    private $timeOpenList;
    private $timeCloseList;
    private $distanceList;
    private $ratingList;
    
    private $weightList;    // Contains the suggestion weights of each museum
    // private $historyWeightList; // Later Feature
    
    
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
    
    // Accessor and Mutator Methods
    
    // Class Specific Methods
    
    // Later feature may contain a second argument that is given by the client
    // user, showing the average time he spends on the museums. Then the
    // recommendation will be given based on time till close not close time.
    public function time() {
        asort($this->timeCloseList);  // Sort the array keeping the same keys-indices
    }
    
    // Returns an sorted index array that points to the museum list objects. 
    // Use thoses indexes to get the museum items sorted by distance.
    public function distance() {
        asort($this->distanceList);   // Sort the array
    }
    public function rating() {
        asort($this->ratingList);
    }
    
    // Later Feature //
    /*
    public function history() {
        
        return $historyWeightList;
    } */
    

    // Gets three boolean arguments as input to calculate the appropriate
    // combined list.
    public function combined($byTime, $byDistance, $byRating) {
        
        if ($byTime) {
            time();
            calcWeights($this->timeCloseList);
        }
        
        if ($byDistance) {
            distance();
            calcWeights($this->distanceList);
        }
        
        if ($byRating) {
            rating();
            calcWeights($this->ratingList);
        }
    }
    
    // Calculates the weightList according to the executed suggestion functions
    public function calcWeights(&$suggestList) {
        $i=0;
        foreach($suggestList as $index => $value) {
            $this->weightList[$index]+= ++$i;
        }
    }
    
    // Returns the indices list containing the weights or an empty list if no
    // recommendation function was called
    public function getIndeces() {
        foreach( $this->weightList as $weight) {
            if ($weight == 0) {
                echo 'Please call a recommendation function';
                return array();
            }
        }
        
        asort($this->weightList);
        
        return array_keys($this->weightList);
        
    }
}
