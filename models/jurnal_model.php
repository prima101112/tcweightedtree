<?php

class jurnal_model extends CI_model {

    public $nama_table = "jurnal";

    function cekStopword($term) {
        if (preg_match("/^[a-zA-Z0-9]+$/", $term) == 1) {
            $query = $this->db->get_where('stopword', array('stopword' => $term));
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {

                return FALSE;
            }
        } else {
            return TRUE;
        }
    }

    function add_jurnal($data) {

        $query = $this->db->insert($this->nama_table, $data);
        return $query;
    }

    function view_all_jurnal() {
        $data = $this->db->get($this->nama_table);
        return $data;
    }

    function view_detail_jurnal($id_jurnal) {
        $this->db->where('id_jurnal', $id_jurnal);
        $data = $this->db->get($this->nama_table);
        return $data;
    }

    function delete_jurnal($id_jurnal) {
        $this->db->where('id_jurnal', $id_jurnal);
        $data = $this->db->delete($this->nama_table);
        return $data;
    }

    function all_jurnal_per_page($num, $offset) {

        $data = $this->db->get($this->nama_table, $num, $offset);
        return $data;
    }

}

?>
