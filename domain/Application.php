<?php
/**
 * Encapsulated version of a dbs entry.
 */
class Application {
    private $id;
    private $user_id;
    private $event_id;
    private $status;
    private $flagged;
    private $note;
    
    # TODO: need to edit this

    function __construct($id, $user_id, $event_id, $status, $flagged, $note) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->event_id = $event_id;
        $this->status = $status;
        $this->flagged = $flagged;
        $this->note = $note;
    }

    function getID() {
        return $this->id;
    }

    function getUserID() {
        return $this->user_id;
    }
    function getEventID() {
        return $this->event_id;
    }

    function getStatus() {
        return $this->status;
    }

    function getFlagged() {
        return $this->flagged;
    }

    function getNote() {
        return $this->note;
    }

}