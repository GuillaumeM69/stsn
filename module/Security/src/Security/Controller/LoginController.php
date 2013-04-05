<?php
namespace Security\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Security\Form\LoginForm;
use Security\Entity\User;

class LoginController extends AbstractActionController
{
    protected $userTable ;

    public function getUserTable(){
        if (!$this->userTable) {
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('Security\Entity\UserTable');
        }
        return $this->userTable;

    }
    protected $authService;

    public function getAuthService()
    {
        if (! $this->authService) {
            $this->authService = $this->getServiceLocator()
                ->get('AuthService');
        }

        return $this->authService;
    }

    public function indexAction(){
        return array(
            'flashMessages'=> $this->flashMessenger()->getMessages(),
            'users' => $this->getUserTable()->fetchAll()
        );
    }    


    // this handles the main login functionality
    public function loginAction(){

        $sm = $this->getServiceLocator();
        // there are tow forms in teh login page
        // 1. login form for the existing users
        // 2. accoutn form to create new accounts
        $loginForm = $sm->get('LoginForm');
        $accountForm = $sm->get('AccountForm');
        $user = new User();
        $invalidAuthentication = false;
        $loginFormValid = true;
        $accountFormValid = true;
        $request = $this->getRequest();

        if ($request->isPost()) {
            // decide which form was submitted
            // the create new account was submitted
            if ( count($this->params()->fromPost('account'))){
                $accountForm->setData($request->getPost());
                if ($accountFormValid = $accountForm->isValid()) {
                    $data = $accountForm->getData(); 
                    // create the new user from teh post data
                    $user = $this->getUserTable()->hydrate($data['account']);
                    $this->getUserTable()->save($user);
                    // now authenticate the user
                    // TODO : sent mail to inform the user

                    $this->getAuthService()->getAdapter()
                        ->setIdentity($data['account']['email'])
                        ->setCredential($data['account']['password']);

                    $result = $this->getAuthService()->authenticate();
                    $invalidAuthentication = !$result->isValid();

                    if( $result->isValid()){
                        foreach($result->getMessages() as $message)
                        {
                            //save message temporary into flashmessenger
                            $this->flashmessenger()->addMessage($message);
                        }
                        $this->flashMessenger()->addMessage('Welcome ' . $data['account']['firstname']);
                        return $this->redirect()->toRoute('demand\index');
                    }
                }
            }
            else{
                // if this is the login form check the db credentials from the 
                // db 
                $loginForm->setData($request->getPost());
                if ($loginFormValid = $loginForm->isValid()) {
                    $data = $this->params()->fromPost('login');
                    //check authentication...
                    $this->getAuthService()->getAdapter()
                        ->setIdentity($data["email"])
                        ->setCredential($data["password"]);

                    $result = $this->getAuthService()->authenticate();
                    $invalidAuthentication = !$result->isValid();

                    if( $result->isValid()){
                        foreach($result->getMessages() as $message)
                        {
                            //save message temporary into flashmessenger
                            $this->flashmessenger()->addMessage($message);
                        }
                        $this->flashMessenger()->addMessage('Welcome Back!');
                        return $this->redirect()->toRoute('demand\index');
                    }
                }
            }
        }
        return array(
            'loginForm' => $loginForm
            , 'loginFormValid' => $loginFormValid
            , 'accountForm' => $accountForm
            , 'accountFormValid' => $accountFormValid
            , 'invalidAuthentication' => $invalidAuthentication);
    }    
    // function for the logout machanism
    public function logoutAction(){
        $sm = $this->getServiceLocator();
        $this->getAuthService()->getStorage()->clear();
        $this->getAuthService()->clearIdentity();

        $this->flashMessenger()->addMessage("You've been logged out");
        return $this->redirect()->toRoute('security\login');
    }
}
