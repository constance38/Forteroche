<?php

namespace blog\controllers;

use blog\config\Container;
use blog\form\Form;
use blog\database\EntityManager;
use blog\HTML\Render;
use blog\error\FlashService;
use blog\user\UserSession;

/**
 * Description of AbstractController  
 * General controller to avoid to repeat few things into all controllers
 * @author constancelaloux
 */
abstract class AbstractController 
{
    protected $renderer;
    protected $httpResponse;
    protected $container;
    protected $flashService;
    protected $request;
    protected $form;   
    protected $flash;
    protected $userSession;
    protected $entityManager;

    
    /**
     * The constructor instanciate the class we can use in every controllers
     */
    public function __construct()
    {
        $this->setContainer();
        $this->request = $this->container->get(\blog\HTTPRequest::class);
        $this->renderer = $this->container->get(\blog\HTML\Render::class);
        $this->httpResponse = $this->container->get(\blog\HTTPResponse::class);
        $this->flashService = $this->container->get(\blog\error\FlashService::class);
        $this->userSession = $this->container->get(\blog\user\UserSession::class);
    }

    /**
     * Returns a container for injection of dependencies
     * @return Container
     */
    public function setContainer(): Container
    {
        $services   = include __DIR__.'/../config/Config.php';
        $this->container = new Container($services);
        return $this->container;
    }

    /**
     * Returns a RedirectResponse to the given URL.
     * @param string $url
     * @return type
     */
    protected function redirect(string $url)
    {
        return $this->httpResponse->redirectResponse($url);
    }

    /**
     * Returns an object Renderer to get the view we had as arg.
     * @return Render
     */
    protected function getRender(): Render
    {
        return $this->renderer;
    }

    /**
     * Returns an object FlashService.
     * @return FlashService
     */
    protected function addFlash(): FlashService
    {
        return $this->flashService;
    }
    
    protected function getFlash(string $type): FlashService
    {
        return $this->flashService->get($type);
    }

    /**
     * Returns an object Form.
     * @return Form
     */
    protected function createForm(): Form
    {
        return new Form();
    }

    /**
     * Return a user session
     * @return UserSession
     */
    protected function userSession(): UserSession
    {
        return $this->userSession;
    }

    /**
     * Return entityManager
     * @param \blog\controllers\Model $model
     * @return EntityManager
     */
    protected function getEntityManager($model): EntityManager
    {
        return $this->entityManager = new EntityManager($model);
    }
    
    /**
     * Check if isset $_POST or isset $_GET
     */
    public function getMethod(): string
    {
        return !is_null($this->request->getData() && !is_null($this->request->postData()));
    }
}
