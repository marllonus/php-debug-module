<?

/** Exception with datestamp
*/
class Objection extends Exception{

    protected $timestamp;

    public function __construct(string $description, 
                                int $code = 0, 
                                Throwable $bind_err = NULL){

        parent::__construct($description, $code, $bind_err);
        $this->timestamp = date("d M, Y, g:i:s a");
    }

    final public function getDatestamp(){

        return $this->timestamp;
    }

    public function __toString(){

        $str = '';
        $str .= "Objection\n";
        $str .= 'Date: ' . $this->getDatestamp() . "\n";
        $str .= 'Code: ' . $this->getCode() . "\n";
        $str .= 'File: ' . $this->getFile() . "\n";
        $str .= 'Line: ' . $this->getLine() . "\n";
        $str .= 'Message: ' . $this->getMessage() . "\n";
        $prev = $this->getPrevious();
        if($prev) $str .= 'Previous: ' . $prev->getMessage() . "\n";
        $str .= 'Trace: ' . "\n" . $this->getTraceAsString() . "\n\n\n";

        return $str;
    }
}

?>