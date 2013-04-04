<?php
namespace SecurityTest\Controller;

use SecurityTest\Bootstrap;
use Security\Controller\LoginController;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use PHPUnit_Framework_TestCase;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class LoginControllerTest extends AbstractHttpControllerTestCase
{
    protected $controller;
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;

    public function setUp()
    {
/*        $serviceManager = Bootstrap::getServiceManager();
        $this->controller = new LoginController();
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'index'));
        $this->event      = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);
        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
 */
        $this->setApplicationConfig(
            include '/Users/ekoray/Sites/istesene/config/application.config.php'
        );
    }

    public function testEntityTableReturnsInstaneOfUserTable(){
    }
    public function testFormSubmission(){
        $userTableMock = $this->getMockBuilder('Security\Entity\UserTable') 
            ->disableOriginalConstructor()
            ->getMock();
        $userTableMock->expects($this->once())
            ->method('save')
            ->will($this->returnValue(null));

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('Security\Entity\UserTable', $userTableMock);
        $data = array('login' => array (
            'username' =>'username',
            'email' => 'email@email.com',
            'password' => 'password'
        ));
        
        $this->dispatch('/security/login', 'POST', $data);

        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/security/index');

    }

    /*public function testEditActionCanBeAccessed()
    {
        $this->routeMatch->setParam('action', 'edit');
        $this->routeMatch->setParam('id', '1');

        $result   = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->routeMatch->setParam('action', 'index');

        $result   = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }*/
}

