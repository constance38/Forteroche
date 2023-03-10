<?php
/**
 * Namespace means i work on this folder
 */
namespace blog;

/**
 * Description of Autoloader
 *
 * @autoloader
 */
class Autoloader 
{
    /**
     * An associative array where the key is a namespace prefix and the value
     * is an array of base directories for classes in that namespace.
     * @var array
     */
    protected $prefixes = array();

    /**
     * Register loader with SPL autoloader stack.
     * @return void
     */
    public function register():void
    {
        spl_autoload_register(array($this, 'loadClass'));
    }

    /**
     * Adds a base directory for a namespace prefix.
     * @param string $prefix The namespace prefix.
     * @param string $base_dir A base directory for class files in the
     * namespace.
     * @param type $prepend If true, prepend the base directory to the stack
     * instead of appending it; this causes it to be searched first rather
     * than last.
     * @return void
     */
    public function addNamespace($prefix, $base_dir, $prepend = false):void
    {

        /**
         * Normalize namespace prefix
         * A / is add at the end of the path(ex: blog/)
         */
        $prefix = trim($prefix, '\\') . '\\';

        /**
         * Normalize the base directory with a trailing separator
         * A / is add at the end of the path
         */
        $base_dir = rtrim($base_dir, DIRECTORY_SEPARATOR) . '/';

        /**
         * Initialize the namespace prefix array
         */
        if (isset($this->prefixes[$prefix]) === false) 
        {
            $this->prefixes[$prefix] = array();
        }

        /**
         * Retain the base directory for the namespace prefix
         */
        if ($prepend) 
        {
            array_unshift($this->prefixes[$prefix], $base_dir);
        } 
        else 
        {
            array_push($this->prefixes[$prefix], $base_dir);
        }
    }

    /**
     * Loads the class file for a given class name.
     * @param type $class The fully-qualified class name.
     * @return boolean The mapped file name on success, or boolean false on
     * failure.
     */
    public function loadClass($class)
    {
        /**
         * The current namespace prefix
         */
        $prefix = $class;

        /**
         * Work backwards through the namespace names of the fully-qualified
         * class name to find a mapped file name
         */
        while (false !== $pos = strrpos($prefix, '\\')) 
        {

            /**
             * Retain the trailing namespace separator in the prefix
             */
            $prefix = substr($class, 0, $pos + 1);

            /**
             * The rest is the relative class name
             */
            $relative_class = substr($class, $pos + 1);

            /**
             * Try to load a mapped file for the prefix and relative class
             */
            $mapped_file = $this->loadMappedFile($prefix, $relative_class);

            if ($mapped_file) 
            {
                return $mapped_file;
            }

            /**
             * Remove the trailing namespace separator for the next iteration
             */
            $prefix = rtrim($prefix, '\\');
        }

        /**
         * Never found a mapped file
         */
        return false;
    }

    /**
     * Load the mapped file for a namespace prefix and relative class.
     * @param type $prefix The namespace prefix.
     * @param type $relative_class The relative class name.
     * @return boolean|string false if no mapped file can be loaded, or the
     * name of the mapped file that was loaded.
     */
    protected function loadMappedFile($prefix, $relative_class)
    {
        /**
         * Are there any base directories for this namespace prefix?
         */
        if (isset($this->prefixes[$prefix]) === false) 
        {
            return false;
        }

        /**
         * Look through base directories for this namespace prefix
         */
        foreach ($this->prefixes[$prefix] as $base_dir) 
        {

            /**
             * Replace the namespace prefix with the base directory,
             * Replace namespace separators with directory separators
             * in the relative class name, append with .php
             */
            $file = $base_dir
                  . str_replace('\\', '/', $relative_class)
                  . '.php';

            /**
             * If the mapped file exists, require it
             */
            if ($this->requireFile($file)) 
            {
                /**
                 * yes, we're done
                 */
                return $file;
            }
        }
        /**
         * Never found it
         */
        return false;
    }

    /**
     * If a file exists, require it from the file system.
     * @param string $file The file to require.
     * @return boolean True if the file exists, false if not.
     */
    protected function requireFile(string $file): bool
    {
        if (file_exists($file)) 
        {
            require $file;
            return true;
        }
        return false;
    }
}