<?php

namespace blog\HTML;

use blog\HTML\RendererInterface;
use blog\error\FlashService;
use blog\user\UserSession;
use blog\HTTPResponse;

/**
 * Description of Render
 *
 * @author constancelaloux
 */
class Render  implements RendererInterface 
{
    private $stack = array();
    
    const DEFAULT_NAMESPACE = 'blog';
    
    private $tpl;
    
    private $paths = array();
    
    private $viewpath;
    
    /**
     * Can access variables in all views
     */
    private $globals = [];
    
    /**
     * I give the view path into the construct
     */
    public function __construct()
    {
        $this->addPath('blog',__DIR__.'/../views');
    }
    
    /**
     * Add a path to load views
     * @param string $namespace
     * @param string $path
     */
    public function addPath(string $namespace, string $path = null): void
    {
        if(is_null($path))
        /**
         * If the name of the path is not defined so we use a namespace as a track and a constant as a namespace 
         * by default
         */
        {
            $this->paths[self::DEFAULT_NAMESPACE] = $namespace;
        }
        else
        /**
         * If i define a name of a path and a path
         */
        {
            $this->paths[$namespace] = $path;      
        }
    }

    /**
     * It returns a string of characters
     * Can render a view with all her variables
     * The path can be specified with the namespaces added via addPath
     * $this->render('@blog/view')
     * $this->render('view')
     * @param string $view
     * @param array $params
     */
    public function render(string $view, array $params = []): void
    {
        $this->view = $view;
        
        if($this->hasNamespace($view))
        {
            $this->viewpath = $this->replaceNamespace($view).'.php';
        }
        else
        {
            $this->viewpath = $this->paths[self::DEFAULT_NAMESPACE].DIRECTORY_SEPARATOR.$view.'.php';
        }
        
        if(!empty($this->viewpath))
        {
            if(file_exists($this->viewpath))
            {
                $session = new FlashService();

                if (session_status() === PHP_SESSION_NONE)
                {
                    session_start();
                }   
                else if (isset($_SESSION['status']) && $_SESSION['status'] === 'admin')
                {
                    $usersession = new UserSession();
                    $usersession->timeoutSession();
                }
                /**
                 * Ob_start = whatever will be displayed now, you store it in a variable
                 */
                ob_start();
                extract($this->globals);
                extract($params);
                require($this->viewpath);
            }
            else
            {
                $page404 = new HTTPResponse();
                $page404->redirect404('/page404');
            }
        }
        $content = ob_get_clean();
        ob_start();
        require __DIR__.'/../views/Layout.php';
    }

    /**
     * Allows you to add global variables to all views
     * @param string $key
     * @param type $value
     */
    public function addGlobal(string $key, string $value): void
    {
        $this->globals[$key] = $value;
    }

    /**
     * Do i have a namespace?
     * @param string $view
     * @return bool
     */
    private function hasNamespace(string $view): bool
    {
        return $view[0] === '@';
    }

    /**
     * 
     * @param string $view
     * @return string
     */
    private function getNamespace(string $view):string
    {
        return substr($view, 1, strpos($view, '/')-1);
    }
    
    /**
     * 
     * @param string $view
     * @return string
     */
    private function replaceNamespace(string $view): string
    {
        $namespace = $this->getNamespace($view);
        return str_replace('@' . $namespace, $this->paths[$namespace], $view);
    }
}
