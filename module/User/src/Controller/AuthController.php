<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Api\UserApiInterface;
use Zend\Authentication\AuthenticationServiceInterface;
use User\Form\LoginForm;

/**
 * User Authentication
 */
class AuthController extends AbstractActionController
{
    protected $api;
    protected $authService;

    public function __construct(UserApiInterface $api, AuthenticationServiceInterface $authService) {
        $this->api = $api;
        $this->authService = $authService;
    }

    public function loginAction()
    {
        $form = new LoginForm();
        return [
            'form' => $form
        ];
    }
    
    public function logoutAction()
    {
        
    }
    
    public function registerAction()
    {
        
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
