<?php
namespace Demand\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class HomeController extends AbstractActionController
{
    public function indexAction(){
        return array(
            'flashMessages'=> $this->flashMessenger()->getMessages(),
        );
    }    
}
