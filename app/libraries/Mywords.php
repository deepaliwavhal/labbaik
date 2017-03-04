<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'libraries/Numbers/Words.php');

class Mywords
{

    function __construct($class = NULL) {
        // include path for libraries
        ini_set('include_path',
        ini_get('include_path') . PATH_SEPARATOR . APPPATH . '/libraries');

        if ($class) {
            require_once (string) $class . '.php';
            log_message('debug', "Words Class $class Loaded");
        } else {
            log_message('debug', "Words Class Initialized");
        }
    }

    public function __get($var) {
        return get_instance()->$var;
    }

    function load($class) {
        require_once (string) $class . '.php';
        log_message('debug', "Words Class $class Loaded");
    }

    public function to_words($amt = FALSE) {
        if (!$amt) { return ''; }
        $nw = new Numbers_Words();
        $val = $nw->toWords($amt, WORDS_LANG);
        return $val;
    }

    public function n2w($amount) {
        $words = '';
        if ($this->Settings->display_words && $amount != 0) {
            $exp = explode($this->Settings->decimals_sep, $this->sim->formatDecimal($amount)); 
            $words = ucfirst($this->to_words($exp[0]))." ".$this->Settings->major; 
            if(isset($exp[1]) && $exp[1]!=0) { 
                $words .= " & ". $this->to_words($exp[1]) ." ".$this->Settings->minor; 
            }
        }
        return $words;
    }

}
