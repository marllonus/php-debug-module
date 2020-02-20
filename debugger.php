<?

require_once __DIR__ . '/strings.php';
require_once __DIR__ . '/jscribe.php';
require_once __DIR__ . '/objection.php';

/**
 * Objection children Interface
 */
interface IObjChild{

    /**
     * Resolve created exception. Note delete from a journal
     */
    public function resolved();
}

/**
 * Create this exception,
 *  if getting exception can break working capacity all program
 */
class FatalObjection extends Objection implements IObjChild{

    public function __construct(string $message, bool $is_tail = false){

        $last_note = $is_tail ? JScribe::getLastNote() : NULL;
        parent::__construct($message, ObjectionCode::FATAL, $last_note);
        JScribe::loadNote($this);
    }

    public function resolved(){

        JScribe::eraseLast();
    }
}

/**
 * Create this exception,
 *  if you exception no influence working capacity all program
 */
class LocalObjection extends Objection{

    public function __construct(string $message){

        parent::__construct($message, ObjectionCode::LOCAL_FAIL);
        JScribe::loadNote($this);
    }

    public function resolved(){

        JScribe::eraseLast();
    }
}

/**
 * Create this exception,
 *  if you have many similar exceptions in one block
 */
class BeadObjection extends Objection{

    public function __construct(int $code, string $message = ''){

        parent::__construct($message, $code);
        JScribe::loadNote($this);
    }

    public function resolved(){

        JScribe::eraseLast();
    }
}

?>