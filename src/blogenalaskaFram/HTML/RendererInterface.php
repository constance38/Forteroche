<?php

namespace blog\HTML;

/**
 * Description of RenderInterface
 *
 * @author constancelaloux
 */
interface RendererInterface 
{
    
    /**
     * Allows you to add a path to load the views
     * @param string $namespace
     * @param string $path
     */
    public function addPath(string $namespace, string $path = null): void;
    
    /**
     * Can render a view
     * The path can be specified by namespaces added via addPath()
     * @param string $view
     */
    public function render(string $view): void;

    /**
     * Allows you to add global variables to all views
     * @param string $key
     * @param type $value
     */
    public function addGlobal(string $key, string $value): void;
}
