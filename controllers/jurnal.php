<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class jurnal extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('html', 'url', 'form', 'captcha'));
        $this->load->library(array('form_validation', 'session', 'pagination'));
        $this->load->library('pagination', 'stemer', 'praproses');
        $this->form_validation->set_error_delimiters('<div id="form_error">', '</div>');
        $this->load->database();
        $this->load->model(array('user_model', 'jurnal_model'));
    }

    public function index() {
        $d['content'] = 'guest/home.php';
        $this->load->view('templateuser', $d);
    }

    public function admin() {
        if ($this->session->userdata('level_user') == 1) {
            $d['content'] = 'admin/home.php';
            $this->load->view('template', $d);
        } else {
            $this->index();
        }
    }

    public function add_jurnal() {

        $d['content'] = 'admin/jurnal/add_jurnal.php';
        $this->load->view('template', $d);
    }
    
    public function delete_jurnal($id_jurnal) {
        $this->jurnal_model->delete_jurnal($id_jurnal);
        redirect('jurnal/all_jurnal_per_page');
    }

    public function all_jurnal_per_page($id = NULL) {
        $jml = $this->jurnal_model->view_all_jurnal();
        //pengaturan pagination
        $config['base_url'] = base_url() . 'jurnal/all_jurnal_per_page/';
        $config['total_rows'] = $jml->num_rows();
        $config['per_page'] = '20';
        $config['first_page'] = 'Awal';
        $config['last_page'] = 'Akhir';
        $config['next_page'] = '&laquo;';
        $config['prev_page'] = '&raquo;';
        //inisialisasi config

        $this->pagination->initialize($config);
        //buat pagination

        $data['pagination'] = $this->pagination->create_links();
        $data['data_jurnal'] = $this->jurnal_model->all_jurnal_per_page($config['per_page'], $id);
        $data['content'] = 'admin/jurnal/all_jurnal.php';
        $this->load->view('template', $data);
    }

    public function all_jurnal() {
        if ($this->session->userdata('level_user') == 1) {
            $d['content'] = 'admin/home.php';
            $this->load->view('template', $d);
        } else {
            $this->index();
        }
    }

    public function coba_stem($kata) {

        $hasil = $this->stemer->stem($kata);
        echo $hasil;
    }

    public function add_jurnal_up() {
        $this->form_validation->set_rules('judul', 'judul', 'required');
        $this->form_validation->set_rules('penulis', 'penulis', 'required');
        $this->form_validation->set_rules('abstrak', 'abstrak', 'required');
        $this->form_validation->set_rules('isi', 'isi', 'required');
        $this->form_validation->set_rules('katakunci', 'katakunci', 'required');
        $this->form_validation->set_rules('tahun', 'tahun', 'required');


        $judul = $this->input->post('judul', TRUE);
        $abstrak = $this->input->post('abstrak', TRUE);
        $isi = $this->input->post('isi', TRUE);
        $katakunci = $this->input->post('katakunci', TRUE);

        $myInputs = $this->input->post('penulis', TRUE);
        $ii = 0;
        $penulissemua = "";
        foreach ($myInputs as $eachInput) {
            $penulis[$ii] = $eachInput;
            if ($ii == 0) {
                $penulissemua = $eachInput;
            } else {
                $penulissemua = $penulissemua . "," . $eachInput;
            }
            $ii++;
        }

        $tahuna = $this->input->post('tahun', TRUE);
        $tahun = strtolower($tahuna);
        $isiarray = $this->praprocessingisi($isi);
        $abstrakarray = $this->praprocessing($katakunci, $isiarray);
        $judularray = $this->praprocessingjudul($judul);
        $penulisarray = $this->praprocessingpenulis($penulissemua);



        $arrayabstrak = array();
        $bobotall = 0;
        while (list($index, $nilai) = each($abstrakarray)) {
            $bobotall = $bobotall + $abstrakarray[$index]['bobot'];
            if ($bobotall > 1) {
                break;
            }
            if ($bobotall == 1 || $abstrakarray[$index]['bobot'] == 0) {
                break;
            } else {
                $arrayabstrak[$index]['kata'] = $abstrakarray[$index]['kata'];
                $arrayabstrak[$index]['bobot'] = $abstrakarray[$index]['bobot'];
            }
        }



        $bobotall = 0;
        $arrayjudul = array();
        while (list($index, $nilai) = each($judularray)) {
            $bobotall = $bobotall + $judularray[$index]['bobot'];
            if ($bobotall > 1) {
                break;
            }
            if ($bobotall == 1 || $judularray[$index]['bobot'] == 0) {
                break;
            } else {
                $arrayjudul[$index]['kata'] = $judularray[$index]['kata'];
                $arrayjudul[$index]['bobot'] = $judularray[$index]['bobot'];
            }
        }

        $jumpen = 0;
        foreach ($penulis as $penulis1) {
            $jumpen = $jumpen + 1;
        }

        $asd = 1 / $jumpen;
        $bobotpen = round($asd, 1);

        $finishedarray = array();
        $finishedarray[1] = "*";
        $finishedarray[4] = "jurnal";
        $finishedarray[8] = "-";
        $finishedarray[9] = "judul";
        $finishedarray[10] = 0.3;
        $finishedarray[11] = "*j";
        $finishedarray[12] = "juduls";
        $k = 13;
        while (list($index, $nilai) = each($arrayjudul)) {
            $finishedarray[$k] = "-j";
            $finishedarray[$k + 1] = $arrayjudul[$index]['bobot'];
            $finishedarray[$k + 2] = $arrayjudul[$index]['kata'];
            $k = $k + 3;
        }
        $finishedarray[$k] = "#";
        $finishedarray[$k + 1] = "-";
        $finishedarray[$k + 2] = "keyword";
        $finishedarray[$k + 3] = 0.4;
        $finishedarray[$k + 4] = "*k";
        $finishedarray[$k + 5] = "keywords";
        $k = $k + 6;
        while (list($index, $nilai) = each($arrayabstrak)) {
            $finishedarray[$k] = "-k";
            $finishedarray[$k + 1] = $arrayabstrak[$index]['bobot'];
            $finishedarray[$k + 2] = $arrayabstrak[$index]['kata'];
            $k = $k + 3;
        }
        $finishedarray[$k] = "#";
        $finishedarray[$k + 1] = "-";
        $finishedarray[$k + 2] = "penulis";
        $finishedarray[$k + 3] = 0.2;
        $finishedarray[$k + 4] = "*p";
        $finishedarray[$k + 5] = "penuliss";
        $k = $k + 6;
       while (list($index, $nilai) = each($penulisarray)) {
            $finishedarray[$k] = "-p";
            $finishedarray[$k + 1] = $penulisarray[$index]['bobot'];
            $finishedarray[$k + 2] = $penulisarray[$index]['kata'];
            $k = $k + 3;
        }

        $finishedarray[$k] = "#";
        $finishedarray[$k + 1] = "-";
        $finishedarray[$k + 2] = "tahun";
        $finishedarray[$k + 3] = 0.1;
        $finishedarray[$k + 4] = $tahun;
        $finishedarray[$k + 5] = "#";

        $tree = serialize($finishedarray);
        $treejudul = serialize($arrayjudul);
        $treekeyword = serialize($arrayabstrak);
        $treepenulis = serialize($penulisarray);

        $data = array(
            'judul_jurnal' => $judul,
            'penulis_jurnal' => $penulissemua,
            'abstrak_jurnal' => $abstrak,
            'tree_jurnal' => $tree,
            'tree_judul' => $treejudul,
            'tree_keyword' => $treekeyword,
            'tree_penulis' => $treepenulis,
            'file_jurnal' => "coba",
            'tahun_jurnal' => $tahun
        );

        if ($this->jurnal_model->add_jurnal($data) == TRUE) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-success">Anda berhasil add jurnal</div>');
            redirect('jurnal/add_jurnal');
        }

        print_r($finishedarray);
    }

    public function praprocessing($kata, $isi) {
        $daftar_tandabaca = array('.', ',', '?', '!', "'", '"', "\n", "\t", "\r", "(", ")", "-", "]", "[");
        $kata = strtolower($kata);

        //hilangka tanda baca
        $word1 = str_replace($daftar_tandabaca, " ", $kata);
        $jadi = $this->parse_cli($word1);
        //print_r($jadi);
        //menghilangkan stopword
        $dadi = array();
        $ab = 0;
        while (list($index, $nilai) = each($jadi)) {
            if ($this->cek_kata($nilai) == TRUE) {
                //do nothing
            } else {
                $dadi[$ab] = $jadi[$index];
                $ab++;
            }
        }

        $dadi2 = array();
        while (list($index, $nilai) = each($dadi)) {
            $dadi2[$index] = $this->stemer->stem($nilai);
        }

        //echo '<hr>';
        $unik = array_unique($dadi2);
       
        $k = 0;
        $jum = 0;
        $jumnor = 0;
        while (list($index, $nilai) = each($unik)) {


            $arraybar[$k]['kata'] = $nilai;
            $aa = $arraybar[$k]['bobot'] = $this->idf($nilai, $isi);
            echo "<h2>".$aa."</h2>";
            if ($aa > 1) {
                $jumnor = $jumnor + $aa;
            }
            $jum = $jum + $aa;

            $k++;
        }

        function cmpaa($a, $b) {

            if ($a['bobot'] == $b['bobot'])
                return 0;
            return $a['bobot'] < $b['bobot'] ? 1 : -1;
        }

        $arrayreturn = array();
        usort($arraybar, "cmpaa");

        print_r($arraybar);
        
        $bobot = 0;
        $akumulasi = 0;
        $akumbobotnormal = 0;
        while (list($key, $value) = each($arraybar)) {
            $bobot = $value['bobot'] / $jum;
            $akumulasi = $akumulasi + $bobot;

            if ($jum > 10) {
                //$bb = $value['bobot'] / (90 * $jum / 100);
                $bb = $bobot;
            } else {
                $bb = $bobot;
            }
            //$value['bobot'] / (85 * $jum / 100);
            $bobotnormal2 = round($bb, 1);
            $akumbobotnormal = $akumbobotnormal + $bobotnormal2;

            $arrayreturn[$key]['kata'] = $value['kata'];
            $arrayreturn[$key]['bobot'] = $bobotnormal2;
        }

        return $arrayreturn;
    }

    public function praprocessingjudul($kata) {
        $daftar_tandabaca = array('.', ',', '?', '!', "'", '"', "\n", "\t", "\r", "(", ")", "-", "]", "[");
        $kata = strtolower($kata);

        //hilangka tanda baca
        $word1 = str_replace($daftar_tandabaca, " ", $kata);
        $jadi = $this->parse_cli($word1);
        //print_r($jadi);
        //menghilangkan stopword
        $dadi = array();
        $ab = 0;
        while (list($index, $nilai) = each($jadi)) {
            if ($this->cek_kata($nilai) == TRUE) {
                //do nothing
            } else {
                $dadi[$ab] = $jadi[$index];
                $ab++;
            }
        }

        $dadi2 = array();
        while (list($index, $nilai) = each($dadi)) {
            $dadi2[$index] = $this->stemer->stem($nilai);
        }

        //echo '<hr>';
        $unik = array_unique($dadi2);
        
        $k = 0;
        $jum = 0;
        $jumnor = 0;
        while (list($index, $nilai) = each($unik)) {


            $arraybar[$k]['kata'] = $nilai;
            $aa = $arraybar[$k]['bobot'] = $this->idf($nilai, $dadi2);

            if ($aa > 1) {
                $jumnor = $jumnor + $aa;
            }
            $jum = $jum + $aa;

            $k++;
        }

        print_r($arraybar);
        echo '<hr>';
        echo '<h1>' . $jum . '</h1>';
        echo '<hr>';

        function cmp($a, $b) {
            if ($a['bobot'] == $b['bobot'])
                return 0;
            return $a['bobot'] < $b['bobot'] ? 1 : -1;
        }

        $arrayreturn = array();
        usort($arraybar, "cmp");

        $bobot = 0;
        $akumulasi = 0;
        $akumbobotnormal = 0;
        while (list($key, $value) = each($arraybar)) {
            $bobot = $value['bobot'] / $jum;
            $akumulasi = $akumulasi + $bobot;

            if ($jum > 10) {
                $bb = $value['bobot'] / (90 * $jum / 100);
            } else {
                $bb = $bobot;
            }
            $bobotnormal2 = round($bb, 1);
            $akumbobotnormal = $akumbobotnormal + $bobotnormal2;

            $arrayreturn[$key]['kata'] = $value['kata'];
            $arrayreturn[$key]['bobot'] = $bobotnormal2;

            //echo "kata : " . $value['kata'] . " memiliki frekuensi:  " . $arrayreturn[$key]['kata'] . " bobot: " . round($bobot, 7) . " dan akumulasi :" . round($akumulasi, 7) . "pemb " . $bobotnormal2 . " andd " . $akumbobotnormal . "<br>";
        }

        return $arrayreturn;
    }

    public function praprocessingpenulis($kata) {
        $daftar_tandabaca = array('.', ',', '?', '!', "'", '"', "\n", "\t", "\r", "(", ")", "-", "]", "[");
        $kata = strtolower($kata);

        //hilangka tanda baca
        $word1 = str_replace($daftar_tandabaca, " ", $kata);
        $jadi = $this->parse_cli($word1);
        //print_r($jadi);
        //menghilangkan stopword
        $dadi = array();
        $ab = 0;
        while (list($index, $nilai) = each($jadi)) {
            if ($this->cek_kata($nilai) == TRUE) {
                //do nothing
            } else {
                $dadi[$ab] = $jadi[$index];
                $ab++;
            }
        }

        $dadi2 = $dadi;

        //echo '<hr>';
        $unik = array_unique($dadi2);

        $k = 0;
        $jum = 0;
        $jumnor = 0;
        while (list($index, $nilai) = each($unik)) {


            $arraybar[$k]['kata'] = $nilai;
            $aa = $arraybar[$k]['bobot'] = $this->idf($nilai, $dadi2);

            if ($aa > 1) {
                $jumnor = $jumnor + $aa;
            }
            $jum = $jum + $aa;

            $k++;
        }

        print_r($arraybar);
        echo '<hr>';
        echo '<h1>' . $jum . '</h1>';
        echo '<hr>';

        function cmppen($a, $b) {
            if ($a['bobot'] == $b['bobot'])
                return 0;
            return $a['bobot'] < $b['bobot'] ? 1 : -1;
        }

        $arrayreturn = array();
        usort($arraybar, "cmppen");

        $bobot = 0;
        $akumulasi = 0;
        $akumbobotnormal = 0;
        while (list($key, $value) = each($arraybar)) {
            $bobot = $value['bobot'] / $jum;
            $akumulasi = $akumulasi + $bobot;


            $bb = $bobot;

            $bobotnormal2 = round($bb, 1);
            $akumbobotnormal = $akumbobotnormal + $bobotnormal2;

            $arrayreturn[$key]['kata'] = $value['kata'];
            $arrayreturn[$key]['bobot'] = $bobotnormal2;

            //echo "kata : " . $value['kata'] . " memiliki frekuensi:  " . $arrayreturn[$key]['kata'] . " bobot: " . round($bobot, 7) . " dan akumulasi :" . round($akumulasi, 7) . "pemb " . $bobotnormal2 . " andd " . $akumbobotnormal . "<br>";
        }

        return $arrayreturn;
    }

    public function praprocessingisi($kata) {
        $daftar_tandabaca = array('.', ',', '?', '!', "'", '"', "\n", "\t", "\r", "(", ")", "-", "]", "[");
        $kata = strtolower($kata);

        //hilangka tanda baca
        $word1 = str_replace($daftar_tandabaca, " ", $kata);
        $jadi = $this->parse_cli($word1);
        //print_r($jadi);
        //menghilangkan stopword
        $dadi = array();
        $ab = 0;
        while (list($index, $nilai) = each($jadi)) {
            if ($this->cek_kata($nilai) == TRUE) {
                //do nothing
            } else {
                $dadi[$ab] = $jadi[$index];
                $ab++;
            }
        }

        $dadi2 = array();
        while (list($index, $nilai) = each($dadi)) {
            $dadi2[$index] = $this->stemer->stem($nilai);
        }

        //echo '<hr>';
       

        return $dadi2;
    }

    public function cek_kata($nilai) {
        $has = $this->jurnal_model->cekStopword($nilai);

        return $has;
    }

    public function parse_cli($string) {
        $state = 'space';
        $previous = '';     // stores current state when encountering a backslash (which changes $state to 'escaped', but has to fall back into the previous $state afterwards)
        $out = array();     // the return value
        $word = '';
        $type = '';         // type of character
        // array[states][chartypes] => actions
        $chart = array(
            'space' => array('space' => '', 'quote' => 'q', 'doublequote' => 'd', 'backtick' => 'b', 'backslash' => 'ue', 'other' => 'ua'),
            'unquoted' => array('space' => 'w ', 'quote' => 'a', 'doublequote' => 'a', 'backtick' => 'a', 'backslash' => 'e', 'other' => 'a'),
            'quoted' => array('space' => 'a', 'quote' => 'w ', 'doublequote' => 'a', 'backtick' => 'a', 'backslash' => 'e', 'other' => 'a'),
            'doublequoted' => array('space' => 'a', 'quote' => 'a', 'doublequote' => 'w ', 'backtick' => 'a', 'backslash' => 'e', 'other' => 'a'),
            'backticked' => array('space' => 'a', 'quote' => 'a', 'doublequote' => 'a', 'backtick' => 'w ', 'backslash' => 'e', 'other' => 'a'),
            'escaped' => array('space' => 'ap', 'quote' => 'ap', 'doublequote' => 'ap', 'backtick' => 'ap', 'backslash' => 'ap', 'other' => 'ap'));
        for ($i = 0; $i <= strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $type = array_search($char, array('space' => ' ', 'quote' => '\'', 'doublequote' => '"', 'backtick' => '`', 'backslash' => '\\'));
            if (!$type)
                $type = 'other';
            if ($type == 'other') {
                // grabs all characters that are also 'other' following the current one in one go
                preg_match("/[ \'\"\`\\\]/", $string, $matches, PREG_OFFSET_CAPTURE, $i);
                if ($matches) {
                    $matches = $matches[0];
                    $char = substr($string, $i, $matches[1] - $i); // yep, $char length can be > 1
                    $i = $matches[1] - 1;
                } else {
                    // no more match on special characters, that must mean this is the last word!
                    // the .= hereunder is because we *might* be in the middle of a word that just contained special chars
                    $word .= substr($string, $i);
                    break; // jumps out of the for() loop
                }
            }
            $actions = $chart[$state][$type];
            for ($j = 0; $j < strlen($actions); $j++) {
                $act = substr($actions, $j, 1);
                if ($act == ' ')
                    $state = 'space';
                if ($act == 'u')
                    $state = 'unquoted';
                if ($act == 'q')
                    $state = 'quoted';
                if ($act == 'd')
                    $state = 'doublequoted';
                if ($act == 'b')
                    $state = 'backticked';
                if ($act == 'e') {
                    $previous = $state;
                    $state = 'escaped';
                }
                if ($act == 'a')
                    $word .= $char;
                if ($act == 'w') {
                    $out[] = $word;
                    $word = '';
                }
                if ($act == 'p')
                    $state = $previous;
            }
        }
        if (strlen($word))
            $out[] = $word;
        return $out;
    }

    public function idf($kata, $array) {
        $idf = 0;
        for($i = 0; $i < count($array); $i++){
             if ($kata == $array[$i]) {
                $idf++;
            }
        }
        
        return $idf;
    }

//        public function praprocessing($kata) {
//        $daftar_tandabaca = array('.', ',', '?', '!', "'", '"', "\n", "\t", "\r", "(", ")", "-");
//        $kata = strtolower($kata);
//
//        //hilangka tanda baca
//        $word1 = str_replace($daftar_tandabaca, " ", $kata);
//        $jadi = $this->parse_cli($word1);
//        //print_r($jadi);
//        //menghilangkan stopword
//        $dadi = array();
//        $ab = 0;
//        while (list($index, $nilai) = each($jadi)) {
//            if ($this->cek_kata($nilai) == TRUE) {
//                //do nothing
//            } else {
//                $dadi[$ab] = $jadi[$index];
//                $ab++;
//            }
//        }
//
//        $dadi2 = array();
//        while (list($index, $nilai) = each($dadi)) {
//            $dadi2[$index] = $this->stemer->stem($nilai);
//        }
//
//        //echo '<hr>';
//        $unik = array_unique($dadi2);
//
//        $k = 0;
//        $jum = 0;
//        $jumnor = 0;
//        while (list($index, $nilai) = each($unik)) {
//
//
//            $arraybar[$k]['kata'] = $nilai;
//            $aa = $arraybar[$k]['bobot'] = $this->idf($nilai, $jadi);
//
//            if ($aa > 1) {
//                $jumnor = $jumnor + $aa;
//            }
//            $jum = $jum + $aa;
//
//            $k++;
//        }
//
//        function cmp($a, $b) {
//
//            if ($a['bobot'] == $b['bobot'])
//                return 0;
//            return $a['bobot'] < $b['bobot'] ? 1 : -1;
//        }
//
//        $arrayreturn = array();
//        usort($arraybar, "cmp");
//
//        $bobot = 0;
//        $akumulasi = 0;
//        $akumbobotnormal = 0;
//        while (list($key, $value) = each($arraybar)) {
//            $bobot = $value['bobot'] / $jum;
//            $akumulasi = $akumulasi + $bobot;
//
//            $bb = $value['bobot'] / (85 * $jum / 100);
//            $bobotnormal2 = round($bb, 1);
//            $akumbobotnormal = $akumbobotnormal + $bobotnormal2;
//
//            $arrayreturn[$key]['kata'] = $value['kata'];
//            $arrayreturn[$key]['bobot'] = $bobotnormal2;
//        }
//
//        return $arrayreturn;
//    }
}

?>
