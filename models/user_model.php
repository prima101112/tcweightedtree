<?php

class user_model extends CI_model {

    public $user = "user";
    public $dosen = "dosen";
    public $mahasiswa = "mahasiswa";
    public $topik = "topik";

    function cek_login($username, $password) {
        $md5_password = md5($password);
        $query = $this->db->get_where($this->user, array('username' => $username, 'password' => $md5_password));
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $id_user = $row->id_user;
                $jenis = $row->level_user;
                $status = $row->status_user;
            }


            $newdata = array(
                'id_user' => $id_user,
                'level_user' => $jenis,
                'status_user' => $status
            );

            $this->session->set_userdata($newdata);
            //    $this->session->set_userdata('user','user');

            return TRUE;
        } else {
            return FALSE;
        }
    }

    function ambil_data_user($tabel, $id) {
        $query = $this->db->get_where($tabel, array('id_user' => $id));
        return $query;
    }

    function ambildata_from_username($username, $pass) {
        $query = $this->db->get_where($this->user, array('username' => $username, 'password' => $pass));
        return $query;
    }

    function cek_data_name_user($data) {

        $query = $this->db->get_where($this->user, array('username' => $data['username']));
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {

            return TRUE;
        }
    }

    function cek_data_name_userup($data) {

        $query = $this->db->get_where($this->user, array('username' => $data['username']));
        if ($query->num_rows() > 1) {
            return FALSE;
        } else {

            return TRUE;
        }
    }

    function add_user($data) {

        $query = $this->db->insert($this->user, $data);
        return $query;
    }

    function add_mahasiswa($data) {

        $query = $this->db->insert($this->mahasiswa, $data);
        return $query;
    }

    function add_dosen($data) {

        $query = $this->db->insert($this->dosen, $data);
        return $query;
    }

    function get_one_user($id) {
        $this->db->where(array('id_user' => $id));
        $query = $this->db->get($this->user);
        return $query;
    }

    function get_one_mahasiswa($id) {
        $this->db->join($this->mahasiswa, 'mahasiswa.id_user = user.id_user');
        $this->db->where(array('user.id_user' => $id));
        $query = $this->db->get($this->user);
        return $query;
    }

    function get_one_dosen($id) {
        $this->db->join($this->dosen, 'dosen.id_user = user.id_user');
        $this->db->where(array('user.id_user' => $id));
        $query = $this->db->get($this->user);
        return $query;
    }

    function view_all_user() {
        $this->db->order_by("id_user", "asc");
        $query = $this->db->get($this->user);

        return $query;
    }

    function view_all_user_admin() {
        $this->db->join('jenis_user', 'user.jenis_user = jenis_user.id_jenis');
        $this->db->where('user.jenis_user', 2);
        $this->db->order_by("user.id_user", "asc");
        $query = $this->db->get($this->user);

        return $query;
    }

    function view_all_user_search($keyword) {
        $this->db->like('name_user', $keyword);
        $this->db->or_like('email_user', $keyword);
        $this->db->order_by("id_user", "ASC");
        $query = $this->db->get($this->user);

        return $query;
    }

    function view_all_user_rev() {
        $this->db->where('id_level', 2);
        $this->db->order_by("points", "ASC");
        $query = $this->db->get($this->user);

        return $query;
    }

    function view_all_user_revtry() {
        $this->db->where('id_level', 2);
        $this->db->order_by("pointstry", "ASC");
        $query = $this->db->get($this->user);

        return $query;
    }

    function view_all_user_download() {
        $this->db->join('user', 'user.id_user = anggota.id_user');
        $query = $this->db->get($this->user_ang);

        return $query->result();
    }

    function view_user_one($id) {
        $query = $this->db->get_where($this->user, array('id_user' => $id));
        return $query;
    }

    function view_all_user_done() {
        $this->db->order_by("id_user", "asc");
        $query = $this->db->get_where($this->user, array('done_user' => 1));

        return $query;
    }

    function all_user_per_page($num, $offset) {

        $this->db->join('jenis_user', 'user.jenis_user = jenis_user.id_jenis');
        $this->db->where('user.jenis_user', 2);
//        $this->db->where('user.jenis_user',1);
        $this->db->order_by("user.id_user", "asc");

        $data = $this->db->get($this->user, $num, $offset);

        return $data;
    }

    function all_mahasiswa_per_page($num, $offset) {

        $this->db->join('mahasiswa', 'user.id_user = mahasiswa.id_user');
        $this->db->join('jenis_user', 'user.jenis_user = jenis_user.id_jenis');
        $this->db->where('user.jenis_user', 4);
        $this->db->order_by("user.id_user", "asc");

        $data = $this->db->get($this->user, $num, $offset);

        return $data;
    }

    function all_dosen_per_page($num, $offset) {

        $this->db->join('dosen', 'user.id_user = dosen.id_user');
        $this->db->join('jenis_user', 'user.jenis_user = jenis_user.id_jenis');
        $this->db->where('user.jenis_user', 3);
        $this->db->order_by("user.id_user", "asc");

        $data = $this->db->get($this->user, $num, $offset);

        return $data;
    }

    function get_all_dosen() {

        $this->db->join('dosen', 'user.id_user = dosen.id_user');
        $this->db->join('jenis_user', 'user.jenis_user = jenis_user.id_jenis');
        $this->db->where('user.jenis_user', 3);
        $this->db->order_by("user.id_user", "asc");

        $data = $this->db->get($this->user);

        return $data;
    }
    
    function get_all_topik() {

        $this->db->order_by("id", "asc");

        $data = $this->db->get($this->topik);

        return $data;
    }

    function all_user_per_search($num, $offset, $keyword) {
        $this->db->like('name_user', $keyword);
        $this->db->or_like('email_user', $keyword);
        $this->db->order_by('id_user', 'ASC');
        $data = $this->db->get($this->user, $num, $offset);

        return $data;
    }

    function delete_user($id_user) {


        $query = $this->db->delete($this->user, array('id_user' => $id_user));

        return $query;
    }

    function delete_mahasiswa($id_user) {
        $query = $this->db->delete($this->user, array('id_user' => $id_user));
        $query2 = $this->db->delete($this->mahasiswa, array('id_user' => $id_user));

        return $query;
    }

    function delete_dosen($id_user) {
        $query = $this->db->delete($this->user, array('id_user' => $id_user));
        $query2 = $this->db->delete($this->dosen, array('id_user' => $id_user));

        return $query;
    }

    function update_user($data, $id) {

        $this->db->where(array('id_user' => $id));
        $query = $this->db->update($this->user, $data);
        return $query;
    }

    function update_mahasiswa($data, $id) {

        $this->db->where(array('id_user' => $id));
        $query = $this->db->update($this->mahasiswa, $data);
        return $query;
    }

    function update_user_anggota($data, $id) {

        $this->db->where(array('id_anggota' => $id));
        $query = $this->db->update($this->user_ang, $data);
        return $query;
    }

    function update_done($iduser) {
        $data = array(
            'done_user' => 1
        );

        $this->db->where(array('id_user' => $iduser));
        $query = $this->db->update($this->user, $data);
        return $query;
    }

    function update_done_0($iduser, $data) {

        $this->db->where(array('id_user' => $iduser));
        $query = $this->db->update($this->user, $data);
        return $query;
    }

    function is_done($id_user) {
        $query = $this->db->get_where($this->user, array('id_user' => $id_user));
        foreach ($query->result() as $val):
            $id_user = $val->id_user;
            $done_user = $val->done_user;
        endforeach;

        return $done_user;
    }

    function update_sedang($iduser, $stat) {
        $data = array(
            'done_user' => $stat
        );

        $this->db->where(array('id_user' => $iduser));
        $query = $this->db->update($this->user, $data);
        return $query;
    }

    function cek_password($pass) {
        $iduser = $this->session->userdata('id_user');
        $this->db->where(array('id_user' => $iduser));
        $q = $this->db->get($this->user);
        foreach ($q->result() as $row) {
            $passd = $row->password_user;
        }
        if ($passd == md5($pass)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function insert_cap($data) {
        $query = $this->db->insert('captcha', $data);
        return $query;
    }

    function cek_cap() {
        $expiration = time() - 7200; // Two hour limit
        $this->db->query("DELETE FROM captcha WHERE captcha_time < " . $expiration);

        $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
        $binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);
        $query = $this->db->query($sql, $binds);
        $row = $query->row();

        if ($row->count == 0) {
            return FALSE;
        }
        return TRUE;
    }

}

?>
