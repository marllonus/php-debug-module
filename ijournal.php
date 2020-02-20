<?

/** Journal Interface
 */
interface IJournal{

    /** add a note to journal as pre writable
     * @param note - exception value - note
     */
    public function jadd(Throwable $note);

    /** write note to journal
     */
    public function jwrite();

    /** print all journal data into a file
     * @return logic value about the successful operation
     */
    public function jprint();

    /** erase a pre writable note
     */
    public function jeraseLast();

    /** return a pre writable note
     * @return note in pre writable state
     */
    public function jgetLastNote();
}

?>