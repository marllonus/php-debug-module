<?

require_once __DIR__ . '/strings.php';
require_once __DIR__ . '/ijournal.php';
require_once __DIR__ . '/jpress.php';

/**
 * Collect Throwable elements
 *      working with tnem: printing, resolve and get last
 * Class composite JPress class for output into a file
 */
class Journal implements IJournal{

    private $objs;
    private $note;

    public function __construct(){

        $this->objs = array();
    }

    public function jadd(Throwable $note){

        $this->jwrite();
        $this->note = $note;
    }

    public function jeraseLast(){

        $this->note = NULL;
    }

    public function jwrite(){

        if(!is_null($this->note))
            array_push($this->objs, $this->note);
    }

    public function jprint(){

        $this->jwrite();
        $io = new JPress($this->objs);

        $report = false;
        for($i=0; $i < PressSettings::PRINT_TRY_COUNT && !$report;++$i)
            $report = $io->press();

        return $report;
    }

    public function jgetLastNote(){

        return $this->note;
    }
}

?>