<?php

    /**
     * Represents an entry in the audit log. Allows admins to track changes to account information.
     */
    class logEntry {

        private $id;
        private $timestamp; //The time in which the change happened.
        private $author_id; //Who made the change.
        private $event_Id; //Edited event
        private $altered_id; //The account that was changed.
        private $change_Type; //The action which was done.
        private $change_Description; //Textual description of the change

        
        /**
         * Default constructor for AuditEntry
         * @param mixed $id
         * @param mixed $author_id
         * @param mixed $altered_id
         * @param mixed $change_Type
         * @param mixed $change_Description
         */
        function __construct($id,  $author_id, $event_Id, $altered_id, $change_Type, $change_Description)
        {
            $this->id = $id;
            $this->author_id = $author_id;
            $this->event_Id = $event_Id; 
            $this->altered_id = $altered_id;
            $this->change_Type = $change_Type;
            $this->change_Description = $change_Description;
            $this->timestamp = time();

        }

        function getId() { return $this->id; }
        function getTimestamp() { return $this->timestamp; }
        function getAuthorId() { return $this->author_id; }
        function getAlterId() { return $this->altered_id; }
        function getChangeType() { return $this->change_Type; }
        function getChangeDescription() { return $this->change_Description; }
        
        function isEventChange():bool
        {
            if (this->event_Id == NULL)
            {
                return False;
            }
            return true;
        }

    }


?>