<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Class museum has all the fields and all appropriate methods needed to
 * describe a museum.
 * 
 * @author student
 */
class Museum {
    
    // Fields //
    
    private $museumId;
    private $distance;
    private $rating;
    private $openTime;
    private $closeTime;
    private $timeTillClose;
    private $closed;    // Boolean value that indicates if the museum is closed
    
    // Constructor //
    public function __construct($museumId, $distance, $rating, $openTime,
            $closeTime) {
        $this->museumId=$museumId;
        $this->distance=$distance;
        $this->rating=$rating;
        $this->openTime=$openTime;
        $this->closeTime=$closeTime;
        
         $currentTime = date('G', time()); // Get current time, measured in hours
        
         // Configure values in case the museum closes after midnight
            if($closeTime < $openTime) {
                $closeTime+=24;
                if($currentTime < $openTime) {
                    $currentTime+=24;
                }
            }
            
            // Calculate time till museum closes
            $this->timeTillClose = $closeTime - $currentTime;
            
            // If the museum is closed, set $hasClosed to true
            if($currentTime < $openTime || $currentTime >= $closeTime){
                $this->closed = true;
            } else {
                $this->closed = false;
            }
    }
    
    // Accessor Methods //
    
    public function getMuseumId() {
        return $this->museumId;
    }
    
    public function getDistance() {
        return $this->distance;
    }
    
    public function getRating() {
        return $this->rating;
    }
    
    public function getOpenTime() {
        return $this->openTime;
    }
    
    public function getCloseTime() {
        return $this->closeTime;
    }
    
    public function getTimeTillClose() {
        return $this->timeTillClose;
    }
    
    public function hasClosed() {
        return $this->closed;
    }
    
}