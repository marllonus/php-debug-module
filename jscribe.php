<?

require_once __DIR__ . '/ijournal.php';
require_once __DIR__ . '/objection.php';

/**
 * Static wrapper for Journal class
 * Class intended for debugger classes for working with a journal.
 */
class JScribe{

    private static $contextJournal;

    public static function setJournal(IJournal $journal){

        if(!self::isJExist())
            self::$contextJournal = $journal;
    }

    public static function isJExist(){

        return self::$contextJournal instanceof IJournal;
    }

    public static function loadNote(Objection $note){

        if(self::isJExist())
            self::$contextJournal->jadd($note);
    }

    public static function getLastNote(){

        return self::isJExist() ?
            self::$contextJournal->jgetLastNote() : NULL;
    }

    public static function eraseLast(){

        if(self::isJExist())
            self::$contextJournal->jeraseLast();
    }

    public static function printJournal(){

        if(self::isJExist())
            self::$contextJournal->jprint();
    }
}

?>