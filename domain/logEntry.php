<?php

    /**
     * Represents an entry in the audit log. Allows admins to track changes to account information.
     */
    class logEntry {

        private $id;
        private $timestamp; //The time in which the change happened.
        private $author_id; //Who made the change.
        private $altered_id; //The account that was changed.
        private $audit_type; //The action which was done.
        private $audit_description; //Textual description of the change
        /**
         * Default constructor for AuditEntry
         * @param mixed $id
         * @param mixed $author_id
         * @param mixed $altered_id
         * @param mixed $audit_type
         * @param mixed $audit_description
         */
        function __construct($id,  $author_id, $altered_id, $audit_type, $audit_description)
        {
            $this->id = $id;
            $this->author_id = $author_id;
            $this->altered_id = $altered_id;
            $this->audit_type = $audit_type;
            $this->audit_description = $audit_description;
            $this->timestamp = time();

        }

        function getId() { return $this->id; }
        function getTimestamp() { return $this->timestamp; }
        function getAuthorId() { return $this->author_id; }
        function getAlterId() { return $this->altered_id; }
        function getAuditType() { return $this->audit_type; }
        function getAuditDescription() { return $this->audit_description; }
        

    }


?>