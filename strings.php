<?

/** Global Objection codes - invalid program codes
 * FATAL - break working capacity all program
 * LOCAL_FAIL - no influence working capacity all program
 * RESOLVED - the exception was resolved
*/
final class ObjectionCode{

    const FATAL = 0;
    const LOCAL_FAIL = 1;
    const RESOLVED = 2;
}

/** JPress base settings
 */
final class PressSettings{

    const JLOCATION  = __DIR__ . '/jlogs';   //logs directory
    const IS_REC_LOCATION = false;          //recursive location
    const MODE = 0777;                      //don't change
    const PRINT_TRY_COUNT = 5;              //if data output was fail, try yet it

    const JNAME      = 'j';                 //journal name
    const JPREFIX    = '.log';              //journal prefix
    const JSIZE      = 0.3; //[mb]             //max journal size
    const JSSIZE     = 30; //[mb]          //max journal library size
    const MEMPREFIX = 1000000; //10^6 = [mega] don't change
}

?>