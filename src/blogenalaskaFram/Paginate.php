<?php

namespace blog;

use blog\database\EntityManager;
use Exception;
use blog\database\Model;
/**
 * Description of Paginate
 *
 * @author constancelaloux
 */
class Paginate 
{
    private $perPage;
    
    private $count;
    
    public function __construct(Model $entity, int $perPage, int $countItems)
    {
        $this->perPage = $perPage;
        $this->model = new EntityManager($entity);
        $this->count = $countItems;
    }
    
    /**
     * 
     * @return int
     */
    public function getItems(): int
    {
        $currentPage = $this->getCurrentPage();
        
        $offset = $this->perPage * ($currentPage - 1);
        
        return $offset;
    }

    /**
     * Next link
     * @return int
     */
    public function nextlink(): int
    {
        $nextPage = $this->getCurrentPage() + 1;
        
        /**
         * If the next page is greater than the number of possible pages
         */
        if($nextPage > $this->getPages())
        {
            /**
             * We return to page number 1
             */
            return $nextPage = 1;
        }
        return $nextPage;
    }

    /**
     * Previous link
     * @return type
     */
    public function previouslink(): int
    {
        $prevPage = $this->getCurrentPage() - 1;
        if($prevPage < 1)
        {
            return $prevPage = $this->getPages();
        }
        return $prevPage;
    }

    /**
     * Return to the current page
     * @return int
     * @throws Exception
     */
    private function getCurrentPage(): int
    {
        $page = $_GET['page'] ?? 1;
        if(!filter_var($page, FILTER_VALIDATE_INT))
        {
            throw new Exception("Numéro de page invalide");
        }
            
        /**
         * The page numbers as parameters in the url
         */
        return $currentPage = (int)$page; 
    }

    /**
     * We wish to obtain a number of pages to have
     * @return int
     */
    private function getPages(): int
    {
        /**
         * We get the number of pages that we are going to have
         */
        return $pages = ceil($this->count / $this->perPage);
        
    }
}
