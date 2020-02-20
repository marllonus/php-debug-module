<?

//connect common code
const __ROOT_DIR__ = __DIR__;
    require_once __ROOT_DIR__ . '/site/system/debug_module/dbginit.php';

    //init debug module
    JScribe::setJournal(new Journal());

    //init system
    require_once __DIR__ . '/site/system/startup.php';

    //print bebug
    JScribe::printJournal();
?>