<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Model {

	public function __construct(){
        parent::__construct();
        $this->load->database();
	}

    public function get_all(){
        $result = $this->db->query("SELECT * FROM `students`");
        return $result->result_array();
    }

    public function insert_record($table, $values){
        $this->db->insert($table, $values);
        return $this->db->insert_id();
    }

    // method to delete record 
    public function delete_record($table, $id){
        // $this->db->query("DELETE FROM {$table} WHERE id = {$id}");
        $this->db->where('id', $id);
        $this->db->delete($table);
        // Produces:
        // DELETE FROM mytable
        // WHERE id = $id
        return $this->db->affected_rows();
    }

    public function update_record($table, $id, $values){
        $this->db->where('id', $id);
        $this->db->update($table, $values);
        // UPDATE $table SET {field = values} wehre id = {$id}
        return $this->db->affected_rows();
    }

    public function check_for_field($table, $condition){
        // array('id'=> $id)
        $this->db->where($condition);
        $result = $this->db->get($table);
        // generated query -> select * from $table where id = $id
        // array('email' => $email, 'password' => $password)
        // generated query -> select * from $table where email = $email and password = $password
        return $result->result_array();
    }


}
