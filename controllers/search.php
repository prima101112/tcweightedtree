<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class search extends CI_Controller {

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
        if ($this->session->userdata('jenis_user') == 1) {
            $d['content'] = 'admin/home.php';
            $this->load->view('admin/index', $d);
        } else {
            redirect('indeks');
        }
    }

    public function view_detail_jurnal($id_jurnal) {
        $this->benchmark->mark('code_start');
        $data['jurnal_detail'] = $this->jurnal_model->view_detail_jurnal($id_jurnal);
        $frase = "";
        $data['frase'] = $frase;
        $data['content'] = 'guest/view_detail_jurnal.php';
        $this->load->view('templatesearch', $data);
    }
     public function search_one_form_full() {
         $this->form_validation->set_rules('frase', 'frase', 'required');
        $frase = $this->input->post('frase', TRUE);
     }
    
    
    public function search_one_form() {
        $this->benchmark->mark('code_start');


        $this->form_validation->set_rules('frase', 'frase', 'required');
        $frase = $this->input->post('frase', TRUE);


        if ($this->form_validation->run() == TRUE || $frase != "") {

            $arraynya = $this->praprocessing($frase);
            $arraynyapenulis = $this->praprocessingts($frase);
            $arrayfrase = $arraynya[0];
            $tahun = $arraynya[1];
//        echo "<h1>" . $tahun . "</h1>";
            $arrayfrase2 = $arrayfrase;

//        $finishedarray = array();
//        $finishedarray[1] = "*";
//        $finishedarray[2] = "jurnal";
//        $finishedarray[3] = "-";
//        $finishedarray[4] = "judul";
//        $finishedarray[5] = 0.3;
//        $finishedarray[6] = "*j";
//        $finishedarray[7] = "juduls";
//        $k = 8;
//        while (list($index, $nilai) = each($arrayfrase2)) {
//            $finishedarray[$k] = "-j";
//            $finishedarray[$k + 1] = $arrayfrase2[$index]['bobot'];
//            $finishedarray[$k + 2] = $arrayfrase2[$index]['kata'];
//            $k = $k + 3;
//        }
//        $finishedarray[$k] = "#";
//        $finishedarray[$k + 1] = "-";
//        $finishedarray[$k + 2] = "keyword";
//        $finishedarray[$k + 3] = 0.4;
//        $finishedarray[$k + 4] = "*k";
//        $finishedarray[$k + 5] = "keywords";
//        $k = $k + 6;
//        while (list($index, $nilai) = each($arrayfrase2)) {
//            $finishedarray[$k] = "-k";
//            $finishedarray[$k + 1] = $arrayfrase2[$index]['bobot'];
//            $finishedarray[$k + 2] = $arrayfrase2[$index]['kata'];
//            $k = $k + 3;
//        }
//        $finishedarray[$k] = "#";
//        $finishedarray[$k + 1] = "-";
//        $finishedarray[$k + 2] = "penulis";
//        $finishedarray[$k + 3] = 0.2;
//        $finishedarray[$k + 4] = "*p";
//        $finishedarray[$k + 5] = "penuliss";
//        $k = $k + 6;
//        while (list($index, $nilai) = each($arraynyapenulis)) {
//            $finishedarray[$k] = "-p";
//            $finishedarray[$k + 1] = $arraynyapenulis[$index]['bobot'];
//            $finishedarray[$k + 2] = $arraynyapenulis[$index]['kata'];
//            $k = $k + 3;
//        }
//
//        $finishedarray[$k] = "#";
//        $finishedarray[$k + 1] = "-";
//        $finishedarray[$k + 2] = "tahun";
//        $finishedarray[$k + 3] = 0.1;
//        $finishedarray[$k + 4] = "$tahun";
//        $finishedarray[$k + 5] = "#";


            $arrayhasila = $this->weightedtree($arrayfrase2, $arraynyapenulis, $tahun);
            $data['frase'] = $frase;
            $data['data_jurnal'] = $arrayhasila;
            $data['content'] = 'admin/jurnal/result_search_jurnal_banding.php';
            $this->load->view('templatesearch', $data);
        } else {
            $frase = "";
            $data['frase'] = $frase;
            //$this->session->set_flashdata('pesan_flash', '<div class="alert alert-warning disabled">Search kosong</div>');
            $data['data_jurnal'] = null;
            $data['content'] = 'admin/jurnal/result_search_jurnal_banding.php';
            $this->load->view('templatesearch', $data);
        }
    }

    public function weightedtree($tree_keyju, $tree_keypen, $keytahun) {
        $alljurnal = $this->jurnal_model->view_all_jurnal();
        $arraycos = array();
        $arraytanim = array();
        $arraybtwc = array();
        $i = 0;
        $j = 0;
        $k = 0;
        foreach ($alljurnal->result() as $val):

            $tree_judul = unserialize($val->tree_judul);
            $tree_keyword = unserialize($val->tree_keyword);
            $tree_penulis = unserialize($val->tree_penulis);
            $tahun = $val->tahun_jurnal;
            if ($keytahun == $tahun) {
                (real) $btahun = 5/1000;
            } else {
                $btahun = 0;
            }

            $bjudul = $this->tanimotocosine($tree_judul, $tree_keyju);
            $bkey = $this->tanimotocosine($tree_keyword, $tree_keyju);
            $bpen = $this->tanimotocosine($tree_penulis, $tree_keypen);

            //penting ============================================
//            echo "Cosin ==> judul = $bjudul[0] . keyword = $bkey[0] . penulis = $bpen[0] <br>";
//            echo "tanim ==> judul = $bjudul[1] . keyword = $bkey[1] . penulis = $bpen[1] <br>";
//            echo "hasil ==> judul = $bjudul[2] . keyword = $bkey[2] . penulis = $bpen[2] <br>";

           (real) $simcos = $bjudul[0] * 0.3 + $bkey[0] * 0.4 + $bpen[0] * 0.2 + $btahun * 0.1;
           (real) $simtanim = $bjudul[1] * 0.3 + $bkey[1] * 0.4 + $bpen[1] * 0.2 + $btahun * 0.1;
           (real) $simbtwc = $bjudul[2] * 0.3 + $bkey[2] * 0.4 + $bpen[2] * 0.2 + $btahun * 0.1;
            
      
            
            if ($simcos != 0 && $simcos != ($btahun * 0.1) && $simcos>0.25) {
                $arraycos[$i]['sim'] = $simcos;
                $arraycos[$i]['id'] = $val->id_jurnal;
                $arraycos[$i]['judul'] = $val->judul_jurnal;
                $arraycos[$i]['abstrak'] = $val->abstrak_jurnal;
                $i++;
            }
            
            if ($simtanim != 0 && $simtanim != ($btahun * 0.1) && sqrt($simtanim*$simtanim)>0.03) {
                $arraytanim[$j]['sim'] = sqrt($simtanim*$simtanim);
                $arraytanim[$j]['id'] = $val->id_jurnal;
                $arraytanim[$j]['judul'] = $val->judul_jurnal;
                $arraytanim[$j]['abstrak'] = $val->abstrak_jurnal;
                $j++;
            }
            
            if ($simbtwc != 0 && $simbtwc != ($btahun * 0.1) && sqrt($simbtwc*$simbtwc)>0.01) {
                $arraybtwc[$k]['sim'] = sqrt($simbtwc*$simbtwc);
                $arraybtwc[$k]['id'] = $val->id_jurnal;
                $arraybtwc[$k]['judul'] = $val->judul_jurnal;
                $arraybtwc[$k]['abstrak'] = $val->abstrak_jurnal;
                $k++;
            }
            
        endforeach;
        
        $arrayhasil = array($arraycos, $arraytanim, $arraybtwc);
        
        return $arrayhasil;
    }

    public function tanimotocosine($tree_data, $tree_key) {
        $atascos = 0.0;
        $bawahcos1 = 0.0;
        $bawahcos2 = 0.0;

//        print_r($tree_data);
//        echo '<hr>';
//        print_r($tree_key);
        $tree_data2 = $tree_data;
        $tree_key2 = $tree_key;

        $jumdata = count($tree_data);
        $jumkey = count($tree_key);

        for ($k = 0; $k < $jumkey; $k++) {

            $bawahcos2 = $bawahcos2 + $tree_key[$k]['bobot'] * $tree_key[$k]['bobot'];
        }
        for ($m = 0; $m < $jumdata; $m++) {

            $bawahcos1 = $bawahcos1 + $tree_data[$m]['bobot'] * $tree_data[$m]['bobot'];
        }

        $con = 0;
        for ($i = 0; $i < $jumdata; $i++) {
//            echo "<br><font color='green'>".$tree_data2[$i]['kata']."</font><br>";
            for ($k = 0; $k < $jumkey; $k++) {
//                echo "<br><font color='blue'>".$tree_key2[$k]['kata']."</font><br>";
                if ($tree_key2[$k]['kata'] == $tree_data2[$i]['kata']) {
//                    echo "<br><font color='red'>".$tree_key2[$k]['kata']."</font><br>";
                    $atascos = $atascos + $tree_key2[$k]['bobot'] * $tree_data2[$i]['bobot'];
                    $con++;
                }
            }
        }
        
        $sqrtb1 = sqrt($bawahcos1);
        $sqrtb2 = sqrt($bawahcos2);
         $cossim = $atascos / ($sqrtb1 * $sqrtb2);
         $tanimo = $atascos / ($sqrtb1 * $sqrtb1 + $sqrtb2 * $sqrtb2) - $atascos;
        
        
        if($jumkey == $con || $jumkey == $con+1){
            $sqrtb1 = sqrt($bawahcos1);
            $sqrtb2 = sqrt($bawahcos2);

            $cossim = $atascos / ($sqrtb1 * $sqrtb2);
            $tanimo = $atascos / ($sqrtb1 * $sqrtb1 + $sqrtb2 * $sqrtb2) - $atascos;
        }else{
            $cossim = 0;
            $tanimo = 0;
        }
        

//        echo "<hr>".$atascos."=======<br>";
//        echo $bawahcos1."=======<br>";
//        echo $bawahcos2."=======<br><hr>";

        
        $hasil = $tanimo * $cossim;
        
        $a = array($cossim, $tanimo, $hasil);

        return $a;
    }

    public function test($var) {
        return ((string) (int) $var === $var);
    }

    public function praprocessing($kata) {
        $daftar_tandabaca = array('.', ',', '?', '!', "'", '"', "\n", "\t", "\r", "(", ")", "-");
        $kata = strtolower($kata);
        $taunya = "";
        //hilangka tanda baca
        $word1 = str_replace($daftar_tandabaca, " ", $kata);
        $jadi = $this->parse_cli($word1);




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
           if ($this->test($nilai) == TRUE) {

                $taunya = $nilai;
//                echo "<h1>" . $taunya . "</h1>";
            }
        }



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


        $arrayreturn = array();

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
            //$value['bobot'] / (85 * $jum / 100);
            $bobotnormal2 = round($bb, 1);
            $akumbobotnormal = $akumbobotnormal + $bobotnormal2;

            $arrayreturn[$key]['kata'] = $value['kata'];
            $arrayreturn[$key]['bobot'] = $bobotnormal2;
        }

        $arraynya = array($arrayreturn, $taunya);
        //print_r($arrayreturn);


        return $arraynya;
    }

    public function praprocessingts($kata) {
        $daftar_tandabaca = array('.', ',', '?', '!', "'", '"', "\n", "\t", "\r", "(", ")", "-");
        $kata = strtolower($kata);
        $taunya = "";
        //hilangka tanda baca
        $word1 = str_replace($daftar_tandabaca, " ", $kata);
        $jadi = $this->parse_cli($word1);



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
            //if ($this->test($nilai) != TRUE) {
                $dadi2[$index] = $nilai;
           // } else 
                if ($this->test($nilai) == TRUE) {

                $taunya = $nilai;
//                echo "<h1>" . $taunya . "</h1>";
            }
        }
      

        $unik = array_unique($dadi2);
  //print_r($unik);
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


        $arrayreturn = array();
        
        

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
            //$value['bobot'] / (85 * $jum / 100);
            $bobotnormal2 = round($bb, 1);
            $akumbobotnormal = $akumbobotnormal + $bobotnormal2;

            $arrayreturn[$key]['kata'] = $value['kata'];
            $arrayreturn[$key]['bobot'] = $bobotnormal2;
        }
        return $arrayreturn;
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
        while (list($tmpindex, $tmpnilai) = each($array)) {
            if ($kata == $tmpnilai) {
                $idf = $idf + 1;
            }
        }

        return $idf;
    }

}

?>
<!--koe mudeng ra neg ra mudeng yo wis-->