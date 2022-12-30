<?php
namespace blog\user;

use blog\database\EntityManager;
use blog\config\Container;

/**
 * Description of UserSession
 * @author constancelaloux
 */
class UserSession
{
    private $loginPath;
    
    private $session;
    
    /**
     *
     * @var type 
     */
    private $messages;
    
    /**
     *
     * @var type 
     */
    private $sessionKey = 'user';
    
    protected $author;
    
    protected $entityManager;
    
    protected $container;
    
    /**
     * I make a connection to the session
     */
    public function __construct()
    {
        $services   = include __DIR__.'/../config/Config.php';
        $this->container = new Container($services);
        $this->session = $this->container->get(\blog\session\PHPSession::class);
        $this->author = $this->container->get(\blog\entity\Author::class);
        $this->entityManager =  new EntityManager($this->author);
    }
    
    /**
     * Pick up the user into database
     * @return type
     */
    public function user(): ?object
    {
        if(session_status() === PHP_SESSION_NONE)
            {
                session_start();
            }
            
        $id = $_SESSION['authorId'] ?? NULL;
        if($id === null)
        {
            /**
             * It means that the user is not connected
             */
            return NULL;
        }
        
        $this->author->setId($id);
        $model = $this->entityManager;
        $auth = $model->findById($this->author->getId());
        return $auth ?: NULL;
    }
    
    /**
     * Check if the user role (s) in parameter exist
     * ...$roles means that we accept several parameters
     * @param type $roles
     * @return type
     */
    public function requireRole(string ...$roles): ?string
    {
        $user = $this->user();
        
        if($user === NULL || !in_array($user->getStatus(), $roles))
        {
            return NULL;
        }
        else
        {
            return $user->getStatus();
        }
    }
    
    /**
     * Function to log out the user
     */
    public function logOut(): void
    {
        session_start();
        session_unset();
        $_SESSION = array();
        session_destroy();   
    }
    
    /**
     * User session exired
     */
    public function expiredSession(): void
    {
        $expireAfter = 60;
        if(isset($_SESSION['last_action']))
        {
            /**
             * Figure out how many seconds have passed
             * since the user was last active.
             */
            $secondsInactive = time() - $_SESSION['last_action'];

            /**
             * Convert our minutes into seconds.
             */
            $expireAfterSeconds = $expireAfter * 60;

            /**
             * Check to see if they have been inactive for too long.
             */
            if($secondsInactive >= $expireAfterSeconds)
            {
                /**
                 * User has been inactive for too long.
                 * Kill their session.
                 */
                session_unset();
                session_destroy();
                require __DIR__.'/../views/AdminHeader.php';
            }
        }
    }
    
    /**
     * User session exired
     */
    public function timeoutSession(): void
    {
        $timeout = $_SERVER['REQUEST_TIME'];
        /**
         * for a 1 minute timeout, specified in seconds
        */
        $timeout_duration = 60;
        $_SESSION['LAST_ACTIVITY'] = $timeout;

        if (isset($_SESSION['LAST_ACTIVITY']) && ($timeout - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) 
        {
            session_unset();
            session_destroy();
            session_start();
        }
    }
}
