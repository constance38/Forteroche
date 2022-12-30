<?php

namespace blog\service;

use blog\Paginate;

use blog\database\EntityManager;

use blog\HTML\Render;

use blog\config\Container;

/**
 * Description of PostService
 *
 * @author constancelaloux
 */
class PostService 
{
    protected $container;
    
    protected $post;
    
    protected $postEntityManager;
    
    protected $perPage;
    
    protected $previouslink;
    
    protected $nextlink;
    
    protected $render;
    
    public function __construct()
    {
        $services   = include __DIR__.'/../config/Config.php';
        $this->container = new Container($services);
        $this->post = $this->container->get(\blog\entity\Post::class);
        $this->postEntityManager = new EntityManager($this->post);
        $this->render = new Render();
    }
        
    /**
     * Paginate and render posts
     */
    public function renderPaginatedPosts(): void
    {
        /**
         * Get the lasts posts
         */
        $lastsposts = $this->getLastsPosts();
        
        /**
         * Paginate
         */
        $model = $this->postEntityManager;
        $this->perPage = 9;
        $countItems = $model->exist();
        $paginatedQueryPost = new Paginate($this->post, $this->perPage, $countItems);
        $offset = $paginatedQueryPost->getItems();
        $posts = $model->findBy(['status' => 'Valider'], [$orderBy = 'create_date'], $limit = $this->perPage, $offset = $offset);
        $this->previouslink = $paginatedQueryPost->previouslink();
        $this->nextlink = $paginatedQueryPost->nextlink();
        $this->render->render('FrontendhomeView',['posts' => $posts, 'previouslink' => $this->previouslink, 'nextlink' => $this->nextlink, 'lastsposts' => $lastsposts]);
    }
        
    /**
     * I will get the lasts three posts
     */
    public function getLastsPosts(): array
    {
        $model = $this->postEntityManager;
        $lastsposts = $model->findBy(['status' => 'Valider'], [$orderBy = 'create_date'], $limit = 3, $offset = 0);
        return $lastsposts;
    }
    
    /**
     * I show the post from the id and its pagination
     * @param type $id
     * @return type
     */
    public function getPost(int $id): object
    {
        $model = $this->postEntityManager;
        return $postFromId = $model->findById($id);
    }
}
