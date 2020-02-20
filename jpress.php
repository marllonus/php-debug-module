<?

require_once __DIR__ . '/strings.php';

/**
 * Print Journal data array with Trowable elements
 * Class intended for Journal class and composite him
 */
class JPress {

    private $jlink;

    private $jcount;
    private $jfname;
    private $readyMode;

    /** Constructor
     * @param journal - link on an array with Throwable values
     */
    public function __construct(&$journal){

        if(!is_array($journal))
            throw new Exception('Journal data is not array');

        $this->jlink = $journal;

        $this->readyMode = empty($journal) ? false : $this->initLogSpace();
    }

    /** Try to print journal at a file
     * @return logic value about the successful operation
     */
    public function press(){

        try{
            if(!$this->readyMode)
                throw new Exception('cant press data, init was fail');
            
            $handle = new SplFileObject($this->jfname, 'ab');
            
            foreach($this->jlink as $note)
                if($note instanceof Throwable)
                    $handle->fwrite($note->__toString());
                
            return true;
        }
        catch(RuntimeException $re){
            
            return false;
        }
        catch(LogicException $le){

            return false;
        }
        catch(Exception $e){

            return false;
        }
    }

    /** Try to erase all files except the last in folder
     * @return logic value about the successful operation
     */
    public function clearJournals(){

        try{
            $it = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator(

                        PressSettings::JLOCATION, 
                        FilesystemIterator::SKIP_DOTS
                    )
            );

            $last_element;
            while($it->valid()){

                if(isset($last_element) 
                                && $last_element->isFile() 
                                && $this->isjMemoryOverflow($last_element->__toString()))
                    unlink($last_element->getPathname());

                $last_element = $it->current();
                $it->next();
            }
            rename($last_element->__toString(), 
                            PressSettings::JLOCATION . '/' . 
                            PressSettings::JNAME . '0'. 
                            PressSettings::JPREFIX);

            return true;
        }
        catch(UnexpectedValueException $une){

            return false;
        }
    }

    /** Try initial working space
     * set a non-overflow file for writing
     * @return logic value about the successful operation
     */
    private function initLogSpace(){

        if(!$this->initWorkDir()) return false;
        if(!$this->getJCount()) return false;
        $this->clearMemIfOverflow();
        $this->setJName();

        return true;
    }

    /** Try create new work irectory if not exist
     * @return logic value about existing a work folder
     */
    private function initWorkDir(){

        $is_dir_exist = is_dir(PressSettings::JLOCATION);
        if(!$is_dir_exist)
            $is_dir_exist = mkdir(
                PressSettings::JLOCATION,
                PressSettings::MODE,
                PressSettings::IS_REC_LOCATION
            );

        return $is_dir_exist;
    }

    /** Try to erase all files except the last in folder
     * if work directory overflow setting the memory size
     * @return logic value about the successful operation
     */
    private function clearMemIfOverflow(){

        $report = false;
        if($this->isWorkspaceMemOverflow()){
            $report = $this->clearJournals();
            $this->jcount = 0;
        }
        return $report;
    }

    /** Check memory size in work directory
     * by quantity files in it
     * @return logic value about memory state in work directory
     */
    private function isWorkspaceMemOverflow(){

        return $this->jcount*PressSettings::JSIZE >= PressSettings::JSSIZE;
    }

    /** Check file journal memory
     * @return logic value about overflowing memory
     */
    private function isjMemoryOverflow($j_name){

        if(!file_exists($j_name))
            return false;
        
        $size = filesize($j_name);
        
        if(is_bool($size)) return false;

        return $size/PressSettings::MEMPREFIX >= PressSettings::JSIZE;
    }

    /** Calculate journal files in work directory
     * @return logic value about the successful operation
     */
    private function getJCount(){

        try{
            $file_it = new FilesystemIterator(
                PressSettings::JLOCATION, 
                FilesystemIterator::SKIP_DOTS
            );

            $this->jcount = iterator_count($file_it);
            return true;
        }
        catch(UnexpectedValueException $une){

            $this->jcount = 0;
            return false;
        }
    }

    /** Get file for writing data
     */
    private function setJName(){

        $num = $this->jcount ? $this->jcount - 1 : $this->jcount;

        $f_dir = PressSettings::JLOCATION . '/' . 
                PressSettings::JNAME;
        
        do $f_name =  $f_dir . strval($num++) . PressSettings::JPREFIX;
            while($this->isjMemoryOverflow($f_name));

        if($num > $this->jcount) ++$this->jcount;

        $this->jfname = $f_name;
    }
}

?>