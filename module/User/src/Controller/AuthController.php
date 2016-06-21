<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Api\UserApiInterface;
use Zend\Authentication\AuthenticationService;
use Zend\View\Renderer\RendererInterface;
use User\Form\LoginForm;
use User\Form\RegisterForm;

/**
 * User Authentication
 */
class AuthController extends AbstractActionController
{
    protected $api;
    protected $authService;
    protected $renderer;

    public function __construct(UserApiInterface $api, AuthenticationService $authService, RendererInterface $renderer) {
        $this->api = $api;
        $this->authService = $authService;
        $this->renderer = $renderer;
    }

    public function loginAction()
    {
        $form = new LoginForm();
        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $formData = $form->getData();
                /* @var $adapter \Zend\Authentication\Adapter\AbstractAdapter */
                $adapter = $this->authService->getAdapter();
                $userId = $this->api->getIdByUsername($formData['username']);
                $adapter->setIdentity($userId);
                $adapter->setCredential($formData['password']);
                if ($this->authService->authenticate()) {
                    return $this->redirect()->toRoute('home');
                }
            }
        
        }
        return [
            'form' => $form
        ];
    }
    
    public function logoutAction()
    {
        $this->authService->clearIdentity();
        return $this->redirect()->toRoute('home');
    }
    
    public function registerAction()
    {
        $basePath = $this->renderer->basePath();
        $form = new RegisterForm($basePath);
        return [
            'form' => $form
        ];
    }
    
    public function confirmRegistrationAction()
    {
        
    }
    
    public function forgotPasswordAction()
    {
        
    }
    
    public function resendRegisterMailAction()
    {
        
    }
    
    public function selfDeleteAction()
    {
        
    }
    
    public function confirmSelfDeleteAction()
    {
        
    }
}
