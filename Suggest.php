<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Suggest
 *
 * @author student
 */
class Suggest {
    
    // Fields
    
   
    private $museumList;  // List of museum objects
    private $historyList; // Array with keys that are museum ID's and values
                          // which are the keys' corresponding search frequency
    
    // Museum indice's lists that are sorted to point the original museum,
    // based on time, distance, rank history and a combination of the 2.
    private $timeWeightList;
    private $distanceWeightList;
    private $rankWeighList;
    private $historyWeightList;
    private $combinedWeightList;
    
    
    // Constructor
    public function __construct($museumList) {
        $this->museumList=$museumList;
        
    }
    
    // Accessor and Mutator Methods
    
    // Class Specific Methods
    
    // Return the 
    public function time() {
        
        
        asort($timeCloseList);  // Sort the array keeping the same keys-indices
        return $timeWeighList;
    }
    public function distance() {
        
        return $distanceWeightList;
    }
    public function rating() {
        
        return $rankWeighList;
    }
    public function history() {
        
        return $historyWeightList;
    }
    
    // Checks according to the values which museums are closed and returns 
    // a list of indices containing the museums that are open
    // Later it may provide the a feature where the user can see the list of 
    // open and closed museums
    
    // This function assumes that the open hour is smaller than the close hour,
    // museums that close for example after 00:00 am will cause the function to
    // export wrong results
    public function checkClosed($timeArray) {
        $i; // Counter
        $timeOpenList;  
        $timeCloseList;
        $timeTillClose;
        
        $currentTime = date('G', time());
        
        // Storing the open and close hours of the mouseums to separate arrays
        // in order to user their indexes after sorting to produce the
        // timeWeighList
        
        foreach($museumList as $museum) {
            $timeOpenList[] = $museum->getOpenHour();
            $timeCloseList[] = $museum->getCloseHour();
            $timeTillClose[] = $museum->getCloseHour(); 
        }
        
        for ($i=0; $i<count($timeArray); ++$i) {
            
            // Unset the array elements that correspond to the museums, which
            // are currently closed
            if($currentTime < $timeOpenList[$i] || $currentTime < $timeOpenList){
                unset($timeArray[$i]);
            }
        }
        
        return;
        
    }

    // Gets three boolean arguments as input to calculate the appropriate
    // combined list.
    public function combined($byTime, $byDistance, $byRating) {
        if ($byTime) {
            
        }
        
        if ($byDistance) {
            
        }
        
        if ($byRating) {
            
        }
        
        return $combinedWeightList;
    }
    
    // Sorts the list of museums according to a given list of indices
    public function sortMuseums() {
        
    }
    // Hello

}
