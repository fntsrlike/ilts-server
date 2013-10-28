<?php
/**
* 
*/
class OQuery
{
    private $query  = null;
    private $row_counter = 0;
    private $conn_id                = NULL;
    private $result_id              = NULL;
    private $result_array           = array();
    private $result_object          = array();
    private $custom_result_object   = array();
    private $current_row            = 0;
    private $num_rows               = 0;
    private $row_data               = NULL;
    
    public function __construct($query)
    {
        $this->query = $query;
    }

    public function row() {

    }

    public function row_arr() {

    }

    public function result($type = 'object') {
        if ($type == 'array') 
            return $this->result_array();
        else if ($type == 'object') 
            return $this->result_object();
        else 
            return $this->custom_result_object($type);
    }

    public function result_object()
    {
        if (count($this->result_object) > 0)
        {
            return $this->result_object;
        }

        // In the event that query caching is on the result_id variable
        // will return FALSE since there isn't a valid SQL resource so
        // we'll simply return an empty array.
        if ($this->result_id === FALSE OR $this->num_rows() == 0)
        {
            return array();
        }

        $this->_data_seek(0);
        while ($row = $this->_fetch_object())
        {
            $this->result_object[] = $row;
        }

        return $this->result_object;
    }

    public function result_arr() {

    }

    public function num_rows() {

    }

    public function num_fields() {

    }

}