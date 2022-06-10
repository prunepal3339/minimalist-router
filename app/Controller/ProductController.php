<?php
namespace App\Controller;
class ProductController extends AbstractController
{
    public function showProductAction()
    {
        $params = $this->router->currentRoute()->routeParams();
        /**
         * Future Plan for Amend:
         * Create a Repository for every model/entity I create
         * and abstract the persistence operations to be performed
         * from repository class only
         */
         /**
          * Inject model object to view
          */
        // var_dump($params);
        // exit;
        if (!array_key_exists('id', $params)){
            throw new \Exception("Key id does not exist");
        }
        return "I am a product with id: " . $params['id'];
    }
    public function listProductsAction()
    {
    }
}