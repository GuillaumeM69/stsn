<?php
namespace Security;

use Security\Entity\User;
use Security\Entity\UserTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
class Module
{
    protected $whiteList = array('security\login', 'home');

    public function onBootstrap($e)
    {
        $app = $e->getApplication();
        $em  = $app->getEventManager();
        $sm  = $app->getServiceManager();

        $list = $this->whiteList;
        $auth = $sm->get('AuthService');

        $em->attach(MvcEvent::EVENT_ROUTE, function($e) use ($list, $auth) {
            $match = $e->getRouteMatch();

            // No route match, this is a 404
            if (!$match instanceof RouteMatch) {
                return;
            }

            // Route is whitelisted
            $name = $match->getMatchedRouteName();
            if (in_array($name, $list)) {
                return;
            }

            // User is authenticated
            if ($auth->hasIdentity()) {
                return;
            }

            // Redirect to the user login page, as an example
            $router   = $e->getRouter('');
            $url      = $router->assemble(array(), array(
                'name' => 'security\login'
            ));

            $response = $e->getResponse();
            $response->getHeaders()->addHeaderLine('Location', $url);
            $response->setStatusCode(302);

            return $response;
        }, -100);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    // Add this method:
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Security\Entity\UserTable' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new UserTable($dbAdapter);
                    return $table;
                },
                    'UserTableGateway' => function ($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(new User());
                        return new TableGateway('stsn_users', $dbAdapter, null, $resultSetPrototype);
                    },
                        'AuthService' => function($sm) {
                            //My assumption, you've alredy set dbAdapter
                            //and has users table with columns : user_name and pass_word
                            //that password hashed with md5
                            $dbAdapter           = $sm->get('Zend\Db\Adapter\Adapter');
                            $dbTableAuthAdapter  = new DbTableAuthAdapter($dbAdapter, 
                                'stsn_users','email','password', 'MD5(?)');

                            $authService = new AuthenticationService();
                            $authService->setAdapter($dbTableAuthAdapter);
                            $authService->setStorage(new SessionStorage('stsn_auth_storage'));
                            return $authService;
                        },

                        ),

                    );
    }
}
