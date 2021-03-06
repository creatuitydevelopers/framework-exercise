<?php
namespace Controller;


use Core\Config\ConfigInterface;
use Core\FrontController;
use Core\Request\HttpRequest;
use Core\Response\HttpResponse;
use Core\Response\ResponseInterface;
use Core\Router;
use Core\Session\MessageBoxInterface;
use Core\Session\SessionInterface;
use Core\User\UserInterface;
use Core\View\ViewInterface;
use Doctrine\ORM\EntityManager;



abstract class AbstractController
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var HttpRequest
     */
    protected $request;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @var FrontController
     */
    protected $frontController;

    /**
     * @var ViewInterface
     */
    protected $view;

    /**
     * @var MessageBoxInterface
     */
    protected $flash;


    /**
     * @return HttpRequest
     */
    public function getRequest(): HttpRequest
    {
        return $this->request;
    }

    /**
     * @param $template
     * @param array $vars
     * @return ResponseInterface
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function renderView($template, $vars = []): ResponseInterface
    {
        $globalVars = [
            'user' => $this->user,
            'session' => $this->session,
            'flash' => $this->flash,
        ];
        $response = new HttpResponse();
        return $response->setBody($this->view->renderView($template, array_merge($vars, $globalVars)));
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    /**
     * @param $uri
     */
    public function redirect(string $uri)
    {
        return $this->frontController->redirect($uri);
    }

    protected function getParameter($name, $default = null)
    {
        return $this->router->getParameter($name, $default);
    }

    /**
     * @param EntityManager $entityManager
     * @return AbstractController
     */
    public function setEntityManager(EntityManager $entityManager): AbstractController
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     * @param HttpRequest $request
     * @return AbstractController
     */
    public function setRequest(HttpRequest $request): AbstractController
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @param SessionInterface $session
     * @return AbstractController
     */
    public function setSession(SessionInterface $session): AbstractController
    {
        $this->session = $session;
        return $this;
    }

    /**
     * @param Router $router
     * @return AbstractController
     */
    public function setRouter(Router $router): AbstractController
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @param ConfigInterface $config
     * @return AbstractController
     */
    public function setConfig(ConfigInterface $config): AbstractController
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @param UserInterface $user
     * @return AbstractController
     */
    public function setUser(UserInterface $user): AbstractController
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param FrontController $frontController
     * @return AbstractController
     */
    public function setFrontController(FrontController $frontController): AbstractController
    {
        $this->frontController = $frontController;
        return $this;
    }

    /**
     * @param ViewInterface $view
     * @return AbstractController
     */
    public function setView(ViewInterface $view): AbstractController
    {
        $this->view = $view;
        return $this;
    }

    /**
     * @param MessageBoxInterface $flash
     * @return AbstractController
     */
    public function setFlash(MessageBoxInterface $flash): AbstractController
    {
        $this->flash = $flash;
        return $this;
    }


    public function isUserSigned():bool {
        if ((!$this->user) || (!$this->user->hasCredentials('user'))) {
            return false;
        } else {
            return true;
        }
    }




}