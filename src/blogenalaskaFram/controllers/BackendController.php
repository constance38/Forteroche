<?php

namespace blog\controllers;

use blog\controllers\AbstractController;
use blog\form\ArticlesForm;
use blog\exceptions\NotFoundHttpException;

/**
 * Description of BacOfficeController
 * @author constancelaloux
 */
class BackendController extends AbstractController
{
    protected $image = [];
    
    protected $post;
    
    protected $upload;
    
    protected $comment;
    
    protected $articleForm;
    
    public function __construct() 
    {
        parent::__construct();
        $this->post = $this->container->get(\blog\entity\Post::class);
        $this->upload = $this->container->get(\blog\file\PostUpload::class);
        $this->comment = $this->container->get(\blog\entity\Comment::class);
    }
    /**
     * Show posts board
     */
    public function renderHomepage()
    {
        if($this->userSession()->requireRole('admin'))
        {
            $this->getrender()->render('BackendhomeView');
        }
        else 
        {
            $this->addFlash()->error('Vous n\avez pas acces à cette page!');
            return $this->redirect('/connectform');
        }
    }
    
    /**
     * get Post to show in datatables
     */
    public function getListOfArticles(): void
    {
        $model = $this->getEntityManager($this->post);
        /**
         * Retrieve all posts
         */
        $posts = $model->findAll();

        if (!empty ($posts))
        {
            foreach ($posts as $articles) 
            {
                $row = array();
                $row[] = $articles->getId();
                $row[] = htmlspecialchars($articles->getSubject());
                $row[] = $articles->getCreateDate()->format('d-m-Y');
                $updateArticleDate = $articles->getUpdateDate();

                if (is_null($updateArticleDate))
                {
                    $row[] = "Vous n'avez pas fait de modifications sur cet article pour l'instant";
                }
                else 
                {
                    $row[] = $updateArticleDate->format('d-m-Y');
                }

                $row[] = $articles->getStatus();
                $data[] = $row;
            }
                            
            /**
             * Structure of the data to be returned
             */
            $json_data = array
            (
                "data" => $data
            );
            echo json_encode($json_data);
        }
        else
        {
            $this->getrender()->render('BackendhomeView');
        }
    }
    
    /**
     * Delete post
     */
    public function deletePost(): void
    {
        if ($this->request->method() == 'POST')
        {  
            $this->post->setId($this->request->postData('id'));
            $model = $this->getEntityManager($this->post);
            $model->remove($this->post);
        }
    }
    
    /**
     * Redirect if post as been well deleted
     * @return type
     */
    public function confirmDeletedPost()
    {
        if($this->userSession()->requireRole('admin'))
        {
            $this->addFlash()->success('La news a bien été supprimée !');
            return $this->redirect('/backoffice'); 
        }
        else 
        {
            $this->addFlash()->error('Vous n\avez pas acces à cette page!');
            return $this->redirect('/connectform');
        }
    }
    
    /**
     * I get an image for the upload and then i return the image path to the view. The goal is to see the image down to the form
     */
    public function uploadImage(): void
    {
        $this->image = $this->upload->upload($_FILES);
        echo "/../../../public/images/upload/posts/$this->image";
    }
    
    /**
     * Create post
     */
    public function createPost(): void
    {
        $title = "Ecrire un article";
        $this->processForm($title);
    }
    
    /**
     * Save post
     */
    public function savePost(): void
    {
        $title = "Ecrire un article";
        $this->processForm($title);
    }
    
    /**
     * Update post
     */
    public function updatePost(): void
    {
        $title = "Ecrire un article";
        
        $this->processForm($title);
    }

    public function processForm(string $title)
    {
        /**
         * If there is no post or get id, I create a new post
         */
        if(is_null($this->request->getData('id')) && is_null($this->request->postData('id')))
        {
            $model = $this->getEntityManager($this->post);
        }
        else
        {
            /**
             * If there is an id in post or in get
             */
            $id = $this->request->postData('id') ? $this->request->postData('id') : $this->request->getData('id');
            $this->post->setId($id);
            $model = $this->getEntityManager($this->post);
            
            /**
             * In case there is no id in database
             * Get the object based on the Id (usually called $id)
             */
            if(!($this->post = $model->findById($this->post->getId())))
            {
                throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
            }
        }
 
        if($this->request->method() == 'POST')
        {
            $this->post->setSubject($this->request->postData('getSubject'));
            $this->post->setContent($this->request->postData('getContent'));
            $this->post->setImage($this->request->postData('getImage'));
            if($this->request->postData('validate'))
            {
                $this->post->setStatus($this->request->postData('validate'));
            }
            else if($this->request->postData('save'))
            {
                $this->post->setStatus($this->request->postData('save'));
            }
            
            if(isset($id))
            {
                $this->post->setUpdateDate(date("Y-m-d H:i:s"));
            }
            else
            {
                $this->post->setCreateDate(date("Y-m-d H:i:s"));
            }

            if(!is_null($this->userSession()->user()->getId()))
            {
                $this->post->setIdAuthor($this->userSession()->user()->getId());
            }
        }
        
        $formBuilder = new ArticlesForm($this->post);
        $form = $formBuilder->buildform($formBuilder->form());
        
        if($this->request->method() == 'POST' && $form->isValid())
        {
            /**
             * We indicate the author. Adapt this to your project, for example if you store the id in the session.
             */
            $model->persist($this->post);
            if($this->userSession()->requireRole('admin'))
            {
                $this->addFlash()->success('L\'article a bien été envoyé !');
                return $this->redirect('/backoffice');
            }
            else 
            {
                $this->addFlash()->error('Vous n\avez pas acces à cette page!');
                return $this->redirect('/connectform');
            }
        }
        
        if($this->userSession()->requireRole('admin'))
        {
            $this->getrender()->render('CreateArticleFormView', ['title' => $title, 'form' => $form->createView(), 'image' => $this->post->getImage()]);
        }
        else 
        {
            $this->addFlash()->error('Vous n\avez pas acces à cette page!');
            return $this->redirect('/connectform');
        }
    }
    
    /**
     * We go to the comments page
     */
    public function renderCommentsPage()
    {
        if($this->userSession()->requireRole('admin'))
        {
            $this->getrender()->render('CommentsView');
        }
        else 
        {
            $this->addFlash()->error('Vous n\avez pas acces à cette page!');
            return $this->redirect('/connectform');
        }  
    }
    
    /**
     * We display the comments datatables
     */
    public function getListOfComments(): void
    {
        $model = $this->getEntityManager($this->comment);
        /**
         * Retrieve all posts
         */
        $comments = $model->findAll();

        if (!empty ($comments))
        {
            foreach ($comments as $comment) 
            {
                $row = array();
                $row[] = $comment->getId();
                $row[] = $comment->getIdPost();
                $row[] = htmlspecialchars($comment->getSubject());
                $row[] = $comment->getCreateDate()->format('d-m-Y');

                if (is_null($comment->getUpdateDate()))
                {
                    $row[] = "Pas de modifications sur ce commentaire pour l'instant";
                }
                else 
                {
                    $row[] = $comment->getUpdateDate()->format('d-m-Y');
                }

                $row[] = $comment->getCountClicks();
                $data[] = $row;
            }
                            
            /**
             * Structure of the data to be returned
             */
            $json_data = array
            (
                "data" => $data
            );
            echo json_encode($json_data);
        }
        else
        {
            $this->getrender()->render('CommentView');
        }  
    }
    
    /**
     * Delete comments into datatables
     */
    public function deleteComments(): void
    {
        if ($this->request->method() == 'POST')
        {  
            $this->comment->setId($this->request->postData('id'));
            $model = $this->getEntityManager($this->comment);
            $model->remove($this->comment);
        }
    }
    
    /**
     * I confirm and redirect after the comment has been deleted
     */
    public function confirmDeletedComments(): string
    {
        if($this->userSession()->requireRole('admin'))
        {
            $this->addFlash()->success('La news a bien été supprimée !');
            return $this->redirect('/rendercommentspage'); 
        }
        else 
        {
            $this->addFlash()->error('Vous n\avez pas acces à cette page!');
            return $this->redirect('/connectform');
        }
    }
}
