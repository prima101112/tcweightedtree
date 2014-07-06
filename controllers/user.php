<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class user extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('html', 'url', 'form', 'captcha'));
        $this->load->library(array('form_validation', 'session'));
        $this->load->library('pagination');
        $this->form_validation->set_error_delimiters('<div id="form_error">', '</div>');
        $this->load->database();
        $this->load->model(array('user_model'));
    }

    public function index() {
        if ($this->session->userdata('jenis_user') == 1) {
            $d['content'] = 'admin/home.php';
            $this->load->view('admin/index',$d);
        } else {
            redirect('indeks');
        }
    }

    public function cek_login() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == TRUE) {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);

            if ($this->user_model->cek_login($username, $password) == TRUE) {
                $d['content'] = 'admin/home.php';
                $this->load->view('template',$d);
            } else {
                $this->session->set_flashdata('pesan_flash', '<div class="alert alert-warning disabled">Maaf,  username / password salah</div>');
                redirect('indeks');
            }
        } else {
            $this->session->set_flashdata('pesan_flash', '<div class="alert alert-warning disabled">Maaf,  username / password salah</div>');
            redirect('indeks');
        }
    }

    function logout() {
        if ($this->session->userdata('level_user') != 0) {
            $this->session->unset_userdata('level_user');
            $this->session->unset_userdata('id_user');
            $this->session->unset_userdata('status_user');
            $this->session->set_flashdata('pesan_flash', '<div class="alert alert-success disabled">Anda telah logout</div>');
            redirect('indeks');
        } else {
            redirect('indeks/admin');
        }
    }

    function register_up() {


        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        $this->form_validation->set_rules('password2', 'password2', 'required');
        $this->form_validation->set_rules('nama', 'nama', 'required');
        $this->form_validation->set_rules('angkatan', 'angkatan', 'required');
        $this->form_validation->set_rules('telp', 'telp', 'required');
        $this->form_validation->set_rules('email', 'email', 'required|email');

//        $this->form_validation->set_rules('captcha', 'captcha', 'required');

        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);
        $password2 = $this->input->post('password2', TRUE);
        $nama = $this->input->post('nama', TRUE);
        $angkatan = $this->input->post('angkatan', TRUE);
        $telp = $this->input->post('telp', TRUE);
        $email = $this->input->post('email', TRUE);

        $datauser = array(
            'username' => $username,
            'password' => md5($password),
            'jenis_user' => 4,
            'status' => 1
        );

        if ($password == $password2) {
            $b = TRUE;
        } else {
            $b = FALSE;
        }

        $a = $this->user_model->cek_data_name_user($datauser);

        if ($a == TRUE and $b == TRUE) {

            if ($this->form_validation->run() == TRUE) {
//                if ($this->user_model->cek_cap() == TRUE) {

                if ($this->user_model->add_user($datauser) == TRUE) {

                    $datus = $this->user_model->ambildata_from_username($datauser['username'], $datauser['password']);
                    foreach ($datus->result() as $roww) {
                        $id_user = $roww->id_user;
                    }
                    $datamahasiswa = array(
                        'nama' => $nama,
                        'angkatan' => $angkatan,
                        'telp' => $telp,
                        'email' => $email,
                        'id_user' => $id_user
                    );

                    if ($this->user_model->add_mahasiswa($datamahasiswa) == TRUE) {

                        $config = Array(
                            'protocol' => 'smtp',
                            'smtp_host' => 'ssl://smtp.googlemail.com',
                            'smtp_port' => 465,
                            'smtp_user' => 'prima101112@gmail.com', // change it to yours
                            'smtp_pass' => 'luphlaili', // change it to yours
                            'mailtype' => 'html',
                            'charset' => 'iso-8859-1',
                            'wordwrap' => TRUE
                        );

                        $pesan = "username anda : " . $this->input->post('username') . "<br>password anda :" . $this->input->post('password');

                        $email_arr = Array();
                        $email_arr[] = Array(
                            $this->load->library('email', $config),
                            $this->email->set_newline("\r\n"),
                            $this->email->from('sistemseminar.uns.ac.id', 'Pemberitahuan Sistem Seminar'),
                            $this->email->to($email),
                            $this->email->subject('Hasil Seleksi'),
                            $this->email->message($pesan)
                        );
                        $this->email->send();
//                        if ($this->email->send()) {
//                            echo "sukses" . $pesan;
//                        } else {
//                            echo "gagal" . $pesan;
//                        }

                        $this->session->set_flashdata('pesan_flash', '<div class="alert alert-success disabled">
                        Anda telah terdaftar sebagai di sistem seminar login dengan username dan password yang sudah di kirim ke email anda

                         </div>');

                        redirect('user');
                    } else {
                        $this->session->set_flashdata('pesan_flash', '<div class="alert alert-warning disabled">
                        gagal input mahasiswa
                        </div>');
                        redirect('user/register');
                    }
                } else {
                    $this->session->set_flashdata('pesan_flash', '<div class="alert alert-warning disabled">
                        gagal input user silahkan ulangi
                        </div>');
                    redirect('user/register');
                }
//                } else {
//                    $this->session->set_flashdata('pesan_flash', '<div class="alert alert-warning disabled">
//                        captcha salah, silahkan ulangi
//                        </div>');
//                    redirect('indeks/register');
//                }
            } else {
                $this->session->set_flashdata('pesan_flash', '<div class="alert alert-warning disabled">
                        gagal validasi cek kembali semua isi.
                        </div>');
                redirect('user/register');
            }
        } else {
            $this->session->set_flashdata('pesan_flash', '<div class="alert alert-warning disabled">
                        password beda, atau nim sudah ada
                        </div>');
            redirect('user/register');
        }
    }

    function register_admin() {
        $data['content'] = 'admin/add_user_admin.php';
        $this->load->view('template', $data);
    }

    function register_admin_up() {


        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        $this->form_validation->set_rules('password2', 'password2', 'required');

//        $this->form_validation->set_rules('captcha', 'captcha', 'required');

        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);
        $password2 = $this->input->post('password2', TRUE);

        $datauser = array(
            'username' => $username,
            'password' => md5($password),
            'jenis_user' => 2,
            'status' => 1
        );

        if ($password == $password2) {
            $b = TRUE;
        } else {
            $b = FALSE;
        }

        $a = $this->user_model->cek_data_name_user($datauser);

        if ($a == TRUE and $b == TRUE) {

            if ($this->form_validation->run() == TRUE) {
//                if ($this->user_model->cek_cap() == TRUE) {

                if ($this->user_model->add_user($datauser) == TRUE) {

                    $this->session->set_flashdata('pesan_flash', '<div class="alert alert-success disabled">
                        Anda telah berhasil add user admin

                         </div>');

                    redirect('user/all_user_per_page');
                } else {
                    $this->session->set_flashdata('pesan_flash', '<div class="alert alert-warning disabled">
                        gagal input user
                        </div>');
                    redirect('user/register_admin');
                }
//                } else {
//                    $this->session->set_flashdata('pesan_flash', '<div class="alert alert-warning disabled">
//                        captcha salah, silahkan ulangi
//                        </div>');
//                    redirect('indeks/register');
//                }
            } else {
                $this->session->set_flashdata('pesan_flash', '<div class="alert alert-warning disabled">
                        gagal validasi cek kembali semua isi.
                        </div>');
                redirect('user/register_admin');
            }
        } else {
            $this->session->set_flashdata('pesan_flash', '<div class="alert alert-warning disabled">
                        password beda, atau username sudah ada
                        </div>');
            redirect('user/register_admin');
        }
    }

    public function all_user_per_page($id = NULL) {
        $jml = $this->user_model->view_all_user_admin();

        //pengaturan pagination
        $config['base_url'] = base_url() . 'user/all_user_per_page/';
        $config['total_rows'] = $jml->num_rows();
        $config['per_page'] = '15';
        $config['first_page'] = 'Awal';
        $config['last_page'] = 'Akhir';
        $config['next_page'] = '&laquo;';
        $config['prev_page'] = '&raquo;';
        //inisialisasi config

        $this->pagination->initialize($config);
        //buat pagination

        $data['pagination'] = $this->pagination->create_links();
        $data['data_user'] = $this->user_model->all_user_per_page($config['per_page'], $id);
        $data['content'] = 'admin/all_user.php';
        $this->load->view('template', $data);
    }

    function reg_user_admin() {


        $this->form_validation->set_rules('name_team', 'name_team', 'required');
        $this->form_validation->set_rules('instansi_team', 'instansi_team', 'required');
        $this->form_validation->set_rules('kota_team', 'instansi_team', 'required');
        $this->form_validation->set_rules('email_ketua', 'Email', 'required');
        $this->form_validation->set_rules('password_team', 'password_team', 'required');
        $this->form_validation->set_rules('passwordf_team', 'passwordf_team', 'required');

        $name_team = $this->input->post('name_team', TRUE);
        $instansi_team = $this->input->post('instansi_team', TRUE);
        $kota_team = $this->input->post('instansi_team', TRUE);
        $username = $this->input->post('email_ketua', TRUE);
        $password_team = $this->input->post('password_team', TRUE);
        $passwordf_team = $this->input->post('passwordf_team', TRUE);
        $id_level = 1;

        $datateam = array(
            'name_user' => $name_team,
            'id_level' => $id_level,
            'instansi_user' => $instansi_team,
            'kota_user' => $kota_team,
            'password_user' => md5($password_team),
            'email_user' => $username
        );

        if ($password_team == $passwordf_team) {
            $b = TRUE;
        } else {
            $b = FALSE;
        }

        $a = $this->user_model->cek_data_name_user($datateam);

        if ($a == TRUE and $b == TRUE) {

            if ($this->form_validation->run() == TRUE) {

                if ($this->user_model->add_user($datateam) == TRUE) {
                    $this->session->set_flashdata('pesan_flash', '<div class="alert alert-success disabled">admin baru berhasil dimasukan</div>');
                    redirect('user/all_user_per_page');
                } else {
                    echo"gagal";
                    redirect('add_user_admin');
                }
            } else {
                echo 'gagal validasi';
                redirect('user/add_user_admin');
            }
        } else {
            redirect('user/add_user_admin');
        }
        $data['cont_view'] = 'user/add_user.php';
        $this->load->view('template_admin', $data);
    }

    function edit_user($id) {
        $d['data_user'] = $this->user_model->get_one_user($id);
        $d['id_user'] = $id;
        $d['content'] = 'admin/edit_user.php';
        $this->load->view('template', $d);
    }

    public function edit_user_up($id) {
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'password');
        $this->form_validation->set_rules('password2', 'password2');

//        $this->form_validation->set_rules('captcha', 'captcha', 'required');

        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);
        $password2 = $this->input->post('password2', TRUE);

        if ($password == '') {
            $datauser = array(
                'username' => $username,
            );
        }else{
             $datauser = array(
                'username' => $username,
                'password' => md5($password)
            );
        }


        if ($password == $password2) {
            $b = TRUE;
        } else {
            $b = FALSE;
        }

        $a = $this->user_model->cek_data_name_userup($datauser);

        if ($a == TRUE and $b == TRUE) {

            if ($this->form_validation->run() == TRUE) {
//                if ($this->user_model->cek_cap() == TRUE) {

                if ($this->user_model->update_user($datauser, $id) == TRUE) {

                    $this->session->set_flashdata('pesan_flash', '<div class="alert alert-success disabled">
                        Anda telah berhasil update user admin

                         </div>');

                    redirect('user/all_user_per_page');
                } else {
                    $this->session->set_flashdata('pesan_flash', '<div class="alert alert-warning disabled">
                        gagal update user
                        </div>');
                    redirect('user/edit_user/'.$id);
                }
//                } else {
//                    $this->session->set_flashdata('pesan_flash', '<div class="alert alert-warning disabled">
//                        captcha salah, silahkan ulangi
//                        </div>');
//                    redirect('indeks/register');
//                }
            } else {
                $this->session->set_flashdata('pesan_flash', '<div class="alert alert-warning disabled">
                        gagal validasi cek kembali semua isi.
                        </div>');
                redirect('user/edit_user/'.$id);
            }
        } else {
            $this->session->set_flashdata('pesan_flash', '<div class="alert alert-warning disabled">
                        password beda, atau username sudah ada
                        </div>');
            redirect('user/edit_user/'.$id);
        }
    }

    function delete_user($id_user) {
        $jml = $this->user_model->view_all_user();

        if ($jml->num_rows() > 1) {
            if ($this->user_model->delete_user($id_user) == TRUE) {
                $this->session->set_flashdata('pesan_flash', '<div class="alert alert-warning disabled">anda berhasil delete user admin</div>');
                redirect('user/all_user_per_page');
            } else {
                echo 'gagal';
            }
        } else {
            $this->session->set_flashdata('pesan_flash', '<div class="alert alert-warning disabled">user tinggal 1 tak boleh dihapus</div>');
            redirect('user/all_user_per_page');
        }
    }

    public function ganti_profil_anggota($idAng, $idUser) {
        $this->form_validation->set_rules('name_anggota', 'name_anggota', 'required');
        $this->form_validation->set_rules('hp_anggota', 'hp_anggota', 'required');
        $this->form_validation->set_rules('social_anggota', 'social_anggota', 'required');
        $this->form_validation->set_rules('email_anggota', 'email_anggota', 'required');



        if ($this->form_validation->run() == TRUE) {
            $name_anggota = $this->input->post('name_anggota', TRUE);
            $hp_anggota = $this->input->post('hp_anggota', TRUE);
            $social_anggota = $this->input->post('social_anggota', TRUE);
            $email_anggota = $this->input->post('email_anggota', TRUE);

            $data = array(
                'name_anggota' => $name_anggota,
                'hp_anggota' => $hp_anggota,
                'social_anggota' => $social_anggota,
                'email_anggota' => $email_anggota
            );
            $this->user_model->update_user_anggota($data, $idAng);
            $this->session->set_flashdata('pesan_flash_kanan', '<div class="alert alert-success">Anda berhasil update Anggota</div>');
            redirect("user/edit_user_admin/$idUser");
            echo 'kjhkj benar';
        } else {
            $this->session->set_flashdata('pesan_flash_kanan', '<div class="alert alert-danger">Maaf,  ada yang salah, update gagal</div>');
            redirect("user/edit_user_admin/$idUser");
        }
    }

    public function ganti_pass($id) {
        $this->form_validation->set_rules('pass', 'pass', 'required');
        $this->form_validation->set_rules('pass_baru', 'pass_baru', 'required');
        $this->form_validation->set_rules('pass_baru2', 'pass_baru2', 'required');



        if ($this->form_validation->run() == TRUE) {
            $pass = $this->input->post('pass', TRUE);
            $pass_baru = $this->input->post('pass_baru', TRUE);
            $pass_baru2 = $this->input->post('pass_baru2', TRUE);

            if ($this->user_model->cek_password($pass) == TRUE) {
                if ($pass_baru == $pass_baru2) {
                    $data = array(
                        'password_user' => md5($pass_baru)
                    );

                    $this->user_model->update_user($data, $id);
                    $this->session->set_flashdata('pesan_flash', '<div class="alert alert-success">Anda berhasil update Password</div>');
                    redirect("userlog/view/changeprofile/");
                } else {
                    $this->session->set_flashdata('pesan_flash', '<div class="alert alert-danger">Maaf,  password tidak sama, update gagal</div>');
                    redirect("userlog/view/changepass/");
                }
            } else {
                $this->session->set_flashdata('pesan_flash', '<div class="alert alert-danger">Maaf,  password lama anda salah , update gagal</div>');
                redirect("userlog/view/changepass/");
            }
        } else {
            $this->session->set_flashdata('pesan_flash', '<div class="alert alert-danger">Maaf,  ada yang salah, update gagal</div>');
            redirect("userlog/view/changepass/");
        }
    }

    function gantipass($id) {
        $d['data_user'] = $this->user_model->get_one_user($id);
        $d['cont_view'] = 'user/edit_pass_user.php';
        $this->load->view('template_admin', $d);
    }

    public function ganti_pass_dariadmin($id) {

        $this->form_validation->set_rules('pass_baru', 'pass_baru', 'required');
        $this->form_validation->set_rules('pass_baru2', 'pass_baru2', 'required');



        if ($this->form_validation->run() == TRUE) {

            $pass_baru = $this->input->post('pass_baru', TRUE);
            $pass_baru2 = $this->input->post('pass_baru2', TRUE);


            if ($pass_baru == $pass_baru2) {
                $data = array(
                    'password_user' => md5($pass_baru)
                );

                $this->user_model->update_user($data, $id);
                $this->session->set_flashdata('pesan_flash', '<div class="alert alert-success">Anda berhasil update Password</div>');
                redirect("user/all_user_per_page");
            } else {
                $this->session->set_flashdata('pesan_flash', '<div class="alert alert-danger">Maaf,  password tidak sama, update gagal</div>');
                redirect("user/all_user_per_page");
            }
        } else {
            $this->session->set_flashdata('pesan_flash', '<div class="alert alert-danger">Maaf,  ada yang salah, update gagal</div>');
            redirect("user/all_user_per_page");
        }
    }

    public function downloadPeserta() {
        $d['dataPeserta'] = $this->user_model->view_all_user_download();
        $this->load->view('asets_admin/user/downloadUser', $d);
    }

    function search($id = NULL) {


        $this->form_validation->set_rules('keyword', 'keyword', 'required');
        if ($this->form_validation->run() == TRUE) {

            $key = $this->input->post('keyword', TRUE);

            $jml = $this->user_model->view_all_user_search($key);
            //pengaturan pagination
            $config['base_url'] = base_url() . 'user/search/';
            $config['total_rows'] = $jml->num_rows();
            $config['per_page'] = '15';
            $config['first_page'] = 'Awal';
            $config['last_page'] = 'Akhir';
            $config['next_page'] = '&laquo;';
            $config['prev_page'] = '&raquo;';
            //inisialisasi config

            $this->pagination->initialize($config);
            //buat pagination
            if ($this->user_model->all_user_per_search($config['per_page'], $id, $key) == TRUE) {

                $data['pagination'] = $this->pagination->create_links();
                $data['data_user'] = $this->user_model->all_user_per_search($config['per_page'], $id, $key);
                $data['cont_view'] = 'user/all_user.php';
                $this->load->view('template_admin', $data);
            } else {
                redirect('user/all_user_per_page');
            }
        } else {
            redirect('user/all_user_per_page');
        }
    }

}

?>
