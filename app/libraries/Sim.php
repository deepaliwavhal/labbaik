<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 *  ============================================================================== 
 *  Author	: Mian Saleem
 *  Email	: saleem@tecdiary.com 
 *  For		: Simple Invoice Manager 
 *  Web		: http://tecdiary.com
 *  ============================================================================== 
 */  

class Sim { 

    public function __construct() {

    }
    
    public function __get($var) {
        return get_instance()->$var;
    }

    private function _rglobRead($source, &$array = array()) {
        if(!$source || trim($source) == "") {
            $source = ".";
        }
        foreach ((array) glob($source . "/*/") as $key => $value) {
            $this->_rglobRead(str_replace("//", "/", $value), $array);
        }
        $hidden_files = glob($source.".*") AND $htaccess = preg_grep('/\.htaccess$/', $hidden_files);
        $files  = array_merge(glob($source . "*.*"), $htaccess);
        foreach ($files as $key => $value) {
            $array[] = str_replace("//", "/", $value);
        }
    }

    private function _zip($array, $part, $destination, $output_name = 'sma') {
        $zip = new ZipArchive;
        @mkdir($destination, 0777, true);
    
        if($zip->open(str_replace("//", "/", "{$destination}/{$output_name}".($part ? '_p'.$part : '').".zip"), ZipArchive::CREATE)) {
            foreach ((array) $array as $key => $value) {
                $zip->addFile($value, str_replace(array("../", "./"), NULL, $value));
            }
            $zip->close();
        }
    }

    public function formatMoney($number, $currency = '') {
        $decimal = $this->Settings->decimals;
        $ts = $this->Settings->thousands_sep == '0' ? ' ' : $this->Settings->thousands_sep;
        $ds = $this->Settings->decimals_sep;
        return $currency.number_format( $number, $decimal, $ds, $ts );
    }

    public function formatNumber($number, $decimals = NULL) {
        if(!$decimals) { $decimals = $this->Settings->decimals; }
        $ts = $this->Settings->thousands_sep == '0' ? ' ' : $this->Settings->thousands_sep;
        $ds = $this->Settings->decimals_sep;
        return number_format( $number, $decimals, $ds, $ts );
    }

    public function formatDecimal($number, $decimals = NULL) {
        if(!$decimals) { $decimals = $this->Settings->decimals; }
        return number_format($number, $decimals, '.', '');
    }

    public function clear_tags($str) {
        return htmlentities(
                strip_tags($str, 
                        '<span><div><a><br><p><b><i><u><img><blockquote><small><ul><ol><li><hr><big><pre><code><strong><em><table><tr><td><th><tbody><thead><tfoot><h3><h4><h5><h6>'
                        ), 
                ENT_QUOTES | ENT_XHTML | ENT_HTML5, 
                'UTF-8'
                );
    }
    
    public function decode_html($str) {
        return html_entity_decode($str, ENT_QUOTES | ENT_XHTML | ENT_HTML5, 'UTF-8');
    }
    
    public function roundMoney($num, $nearest = 0.05) {
        return round($num * ( 1 / $nearest)) * $nearest;
    }
    
    public function unset_data($ud) { 
        if($this->session->userdata($ud)) {
            $this->session->unset_userdata($ud);
            return true;
        }
        return FALSE;
    }
    
    public function hrsd($sdate) {
        if($sdate) {
            return date($this->dateFormats['php_sdate'], strtotime($sdate));
        } else {
            return '0000-00-00';
        }
    }
    
    public function hrld($ldate) {
        if($ldate) {
            return date($this->dateFormats['php_ldate'], strtotime($ldate));
        } else {
            return '0000-00-00 00:00:00';
        }
    }
    
    public function fsd($inv_date)
    {
        if ($inv_date) {
            $jsd = $this->dateFormats['js_sdate'];
            if ($jsd == 'dd-mm-yyyy' || $jsd == 'dd/mm/yyyy' || $jsd == 'dd.mm.yyyy') {
                $date = substr($inv_date, -4) . "-" . substr($inv_date, 3, 2) . "-" . substr($inv_date, 0, 2);
            } elseif ($jsd == 'mm-dd-yyyy' || $jsd == 'mm/dd/yyyy' || $jsd == 'mm.dd.yyyy') {
                $date = substr($inv_date, -4) . "-" . substr($inv_date, 0, 2) . "-" . substr($inv_date, 3, 2);
            } else {
                $date = $inv_date;
            }
            return $date;
        } else {
            return '0000-00-00';
        }
    }

    public function fld($ldate)
    {
        if ($ldate) {
            $date = explode(' ', $ldate);
            $jsd = $this->dateFormats['js_sdate'];
            $inv_date = $date[0];
            $time = $date[1];
            if ($jsd == 'dd-mm-yyyy' || $jsd == 'dd/mm/yyyy' || $jsd == 'dd.mm.yyyy') {
                $date = substr($inv_date, -4) . "-" . substr($inv_date, 3, 2) . "-" . substr($inv_date, 0, 2) . " " . $time;
            } elseif ($jsd == 'mm-dd-yyyy' || $jsd == 'mm/dd/yyyy' || $jsd == 'mm.dd.yyyy') {
                $date = substr($inv_date, -4) . "-" . substr($inv_date, 0, 2) . "-" . substr($inv_date, 3, 2) . " " . $time;
            } else {
                $date = $inv_date;
            }
            return $date;
        } else {
            return '0000-00-00 00:00:00';
        }
    }

    public function send_email($to, $subject, $message, $from = NULL, $from_name = NULL, $attachment = NULL, $cc = NULL, $bcc = NULL) {
        $this->load->library('email');
        $config['useragent'] = "Stock Manager Advance";
        $config['protocol'] = $this->Settings->protocol;
        $config['mailtype'] = "html";
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        if($this->Settings->protocol == 'sendmail') {
            $config['mailpath'] = $this->Settings->mailpath;
        } elseif($this->Settings->protocol == 'smtp') {
            $this->load->library('encrypt');
            $config['smtp_host'] = $this->Settings->smtp_host;
            $config['smtp_user'] = $this->Settings->smtp_user;
            $config['smtp_pass'] = $this->encrypt->decode($this->Settings->smtp_pass);
            $config['smtp_port'] = $this->Settings->smtp_port;
            if(!empty($this->Settings->smtp_crypto)) { $config['smtp_crypto'] = $this->Settings->smtp_crypto; }
        }
        $this->email->initialize($config);

        if($from && $from_name) {
            $this->email->from($from, $from_name);
        } elseif($from) {
            $this->email->from($from, $this->Settings->site_name);
        }else {
            $this->email->from($this->Settings->default_email, $this->Settings->site_name);
        }

        $this->email->to($to);
        if($cc) {
            $this->email->cc($cc);
        }
        if($bcc) {
            $this->email->bcc($bcc);
        }
        $this->email->subject($subject);
        $this->email->message($message);
        if($attachment) {
            if(is_array($attachment)) {
                $this->email->attach($attachment['file'], '', $attachment['name'], $attachment['mime']);
            } else {
                $this->email->attach($attachment);
            }
        }

        if($this->email->send()) {
            // echo $this->email->print_debugger(); die();
            return TRUE;
        } else {
            // echo $this->email->print_debugger(); die();
            return FALSE;
        }
    }

    
    public function generate_pdf($content, $name = 'download.pdf', $output_type = NULL, $footer = NULL, $margin_bottom = 0,  $header = NULL, $margin_top = 0, $orientation = 'P') { 
        if(!$output_type) { $output_type = 'D'; }
        $this->load->library('pdf');
        $pdf = new mPDF('utf-8', 'A4-'.$orientation, '12', '', 0, 0, $margin_top, $margin_bottom, 0, 0);
        $pdf->debug = false;
        $pdf->autoScriptToLang = true;
        $pdf->autoLangToFont = true;
        // if you need to add protection to pdf files, please uncomment the line below or modify as you need.
        // $pdf->SetProtection(array('print'), NULL, 'SIM'); // You pass 2nd arg for user password (open) and 3rd for owner password (edit)
        // $pdf->SetProtection(array('print', 'copy')); // Comment above line and uncomment this to allow copying of content
        $pdf->SetTitle($this->Settings->site_name);
        $pdf->SetAuthor($this->Settings->site_name);
        $pdf->SetCreator($this->Settings->site_name);
        $pdf->SetDisplayMode('fullpage');
        // $stylesheet = file_get_contents($this->data['assets'].'style/bootstrap.min.css');
        // $pdf->WriteHTML($stylesheet, 1);
        $pdf->WriteHTML($content);
        if($header != '') { $pdf->SetHTMLHeader('<p class="text-center">'.$header.'</p>', '', TRUE); }
        if($footer != '') { $pdf->SetHTMLFooter('<p class="text-center">'.$footer.'</p>', '', TRUE); }
        if($output_type == 'S') {
            $file_content = $pdf->Output('', 'S');
            $this->load->helper('file');
            write_file('uploads/'.$name, $file_content);
            return 'uploads/'.$name;
        } else {
            $pdf->Output($name, $output_type);
        } 
    }
    
    public function print_arrays() {
        $args = func_get_args();
        echo "<pre>";
        foreach($args as $arg){
            print_r($arg);
        }
        echo "</pre>";
        die();
    }

    public function logged_in() {
        return (bool) $this->session->userdata('identity');
    }

    public function in_group($check_group, $id = false) {
       if (!$id) { $id = $this->session->userdata('user_id'); }
        $group = $this->site->getUserGroup($id);
        if($group && $group->name === $check_group) {
            return TRUE;
        }
        return FALSE;
    }

    public function zip($source = NULL, $destination = "./", $output_name = 'sma', $limit = 5000) {
        if(!$destination || trim($destination) == "") {
            $destination = "./";
        }
    
        $this->_rglobRead($source, $input);
        $maxinput = count($input);
        $splitinto = (($maxinput / $limit) > round($maxinput / $limit, 0)) ? round($maxinput / $limit, 0) + 1 : round($maxinput / $limit, 0);
    
        for($i = 0; $i < $splitinto; $i ++) {
            $this->_zip(array_slice($input, ($i * $limit), $limit, true), $i, $destination, $output_name);
        }
       
        unset($input);
        return;
    }
    
    public function unzip($source, $destination = './') {

        // @chmod($destination, 0777);
        $zip = new ZipArchive;
        if($zip->open(str_replace("//", "/", $source)) === true) {
            $zip->extractTo($destination);
            $zip->close();
        }
        // @chmod($destination,0755);

        return TRUE;
    }

    public function view_rights($user_id) {
        if (!$this->Admin) {
            if($user_id != $this->session->userdata('user_id')) {
                $this->session->set_flashdata('warning', $this->data['access_denied']);
                redirect($_SERVER["HTTP_REFERER"]);
            }
        }
        return TRUE;
    }

    function escape_str($q) {
        if(is_array($q)) {
            foreach($q as $k => $v) {
                $q[$k] = $this->escape_str($v);
            }
        } elseif(is_string($q)) {
            $q = $this->db->escape_str($q);
        }
        return $q;
    }

    public function send_json($data) {
        header('Content-Type: application/json');
        die(json_encode($data));
        exit;
    }
    
}
