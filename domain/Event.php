<?php
/**
 * Encapsulated version of a dbs entry.
 */
class Event {
    private $id;
    private $name;
    private $type;
    private $startDate;
    private $startTime;
    private $endTime;
    private $endDate;
    private $description;
    private $capacity;
    private $location;
    private $affiliation;
    private $branch;
    private $access;
    private $completed;
    #private $trainingMedia;
    #private $postMedia;
    #private $animalId;

    # TODO: need to edit this

    function __construct($id, $name, $type, $startDate, $startTime, $endTime, $endDate, $description, $capacity, $location, $affiliation, $branch, $access, $completed) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->startDate = $startDate;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->endDate = $endDate;
        $this->description = $description;
        $this->capacity = $capacity;
        $this->location = $location;
        $this->affiliation = $affiliation;
        $this->branch = $branch;
        $this->access = $access;
        $this->completed = $completed;
    }

    function getID() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    #function getAbbreviatedName() {
    #    return $this->abbrevName;
    #}
    // new Event
    function getStartDate() {
        return $this->startDate;
    }

    function getStartTime() {
        return $this->startTime;
    }

    function getEndTime() {
        return $this->endTime;
    }

    function getEndDate() {
        return $this->endDate;
    }
    function getDescription() {
        return $this->description;
    }

    function getLocation() {
        return $this->location;
    }

    function getCapacity() {
        return $this->capacity;
    }

    function getCompleted() {
        return $this->completed;
    }

    function getAffiliation() {
        return $this->affiliation;
    }

    function getBranch() {
        return $this->branch;
    }
    function getEventType() {
        return $this->type;
    }

    function getAccess() {
        return $this->access;
    }

    //TODO DELETE
    #function getTrainingMedia() {
    #    return $trainingMedia;
    #}

    #function getPostMedia() {
    #    return $postMedia;
    #}

    #function getAnimalId() {
    #    return $animalId;
    #}
}