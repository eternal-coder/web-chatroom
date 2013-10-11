<?

require_once 'Message.php';
require_once 'config.php';

abstract class iActionHandler {

    protected $mysqli;
    protected $sessionId;

    public function __construct() {
        $this->mysqli = new mysqli(Config::dbhost, Config::dbuser, Config::dbpassword, Config::dbname);
    }

    public function setSessionId($sessionId){
        $this->sessionId = $sessionId;
    }
    
    public abstract function canHandle($command);

    public abstract function handle($command);
}
?>