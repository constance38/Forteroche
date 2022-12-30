<?php

namespace blog\controllers;

use blog\controllers\AbstractController;
use blog\database\Query;

/**
 * Description of SearchController
 *
 * @author constancelaloux
 */
class SearchController extends AbstractController
{
    protected $post;
    
    public function __construct() 
    {
        parent::__construct();
        $this->post = $this->container->get(\blog\entity\Post::class);
    }
    /**
     * I search a post into the blog       
     */
    function search(): void
    {
            if(!is_null($this->request->postData('userSearch')))
            {
                $mySearchResults = (new Query($this->post))
                        ->from('post')
                        ->select('*')
                        ->where('subject LIKE :subject OR content LIKE :content')
                        ->setParams(array('subject' => '%'.$this->request->postData('userSearch').'%', 'content' => '%'.$this->request->postData('userSearch').'%'))
                        ->fetchAll();
                $this->getrender()->render('SearchResultView',['mySearchResults' => $mySearchResults]);
            }
            else 
            {
                $this->addFlash()->error('Vous n\'avez pas fait de recherche!');
            }
    }
}
