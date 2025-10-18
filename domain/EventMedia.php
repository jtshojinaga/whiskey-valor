<?php

 class EventMedia {
    private $eventID;
    private $file_name;
    private $type;
    private $file_format;
    private $description;
    private $time_created;
    private $id;

     function __construct($eventID, $file_name, $type, $file_format,$description, $id, $time_created) {
         $this->eventID = $eventID;
         $this->file_name = $file_name;
         $this->type = $type;
         $this->file_format = $file_format;
         $this->description = $description;
         $this->time_created = $time_created;
         $this->id = $id;
     }

    public function getEventID() { return $this->eventID; }

    public function getFileName() { return $this->file_name; }

    public function getType() { return $this->type; }

    public function getFileFormat() { return $this->file_format; }

    public function getDescription() { return $this->description; }

    public function getTimeCreated() { return $this->time_created; }

    public function getID() { return $this->id; }
}