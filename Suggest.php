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
    private $timeTillCloseList;
    private $distanceList;
    private $ratingList;
    
    private $weightList;    // Contains the suggestion weights of each museum
    // private $historyList; // Later Feature
    
    
    // Constructor //
    
    // The constructor
    public function __construct($museumList) {
        $this->museumList=&$museumList; // Copy museum array by reference
        $arraySize = count($museumList);
       
        
        // Initialize each list with its corresponding field from the museumList
        for($i=0 ; $i < $arraySize ; ++$i) {
            
            
            // If the museum is closed, remove it from the list
            if($museumList[$i]->hasClosed()==true) {
                unset($museumList[$i]);
                continue;
            }
            
            // $this->museumIdList[$i] = $museumList[$i]->getMuseumId();
            $this->distanceList[$i] = $museumList[$i]->getDistance();
            $this->ratingList[$i] = $museumList[$i]->getRating();
            $this->timeTillCloseList[$i] = $museumList[$i]->getTimeTillClose();
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
        arsort($this->timeTillCloseList);  // Sort the array keeping the same keys-indices
        $this->calcWeights($this->timeTillCloseList);
        return $this;
    }
    
    // Adds appropriate weights to the weightList according to distance
    public function distance() {
        asort($this->distanceList);   // Sort the array
        $this->calcWeights($this->distanceList);
        return $this;
    }
    
    // Adds appropriate weights to the weightList according to rating
    public function rating() {
        arsort($this->ratingList);
        $this->calcWeights($this->ratingList);
        return $this;
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
            $this->time();
        }
        
        if ($byDistance) {
            $this->distance();
        }
        
        if ($byRating) {
            $this->rating();
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
    
    // Produces a recommendation indeces' list inserting a custom weight to each 
    // parameter
    // There might be arguments in the future for custom weights and max values
    // in the denominator.
    // Also there might be an extra paramater in the equation like the time or
    // the history of the user
    public function recommend() {
        unset($this->weightList);   // Unset way list, case it contains data
        foreach($this->museumList as $index => $museum) {
            $this->weightList[$index] =  0.6*($museum->getRating() / 10) +
                    0.4*( 1 - $museum->getDistance() / 10000);
        }
        arsort($this->weightList);
        
        return array_keys($this->weightList);
    }
    
}