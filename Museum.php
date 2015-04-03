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
    private $openHour;
    private $closeHour;
    
    // Constructor //
    public function __construct($museumId, $distance, $rating, $openHour,
            $closeHour) {
        $this->museumId=$museumId;
        $this->distance=$distance;
        $this->rating=$rating;
        $this->openHour=$openHour;
        $this->closeHour=$closeHour;
    }
    
    // Accessor Methods //
    
    public function getMuseumId() {
        return $this->museumId;
    }
    
    public function setMuseumId($museumId) {
        $this->museumId=$museumId;
    }
    
    public function getDistance() {
        return $this->distance;
    }
    
    public function setDistance($distance) {
        $this->distance=$distance;
    }
    
    public function getRating() {
        return $this->rating;
    }
    
    public function setRating($rating) {
        $this->rating=$rating;
    }
    
    public function getOpenHour() {
        return $this->openHour;
    }
    
    public function setOpenHour($openHour) {
        $this->openHour=$openHour;
    }
    
    public function getCloseHour() {
        return $this->closeHour;
    }
    
    public function setCloseHour($closeHour) {
        $this->closeHour=$closeHour;
    }
    
    
    
}
