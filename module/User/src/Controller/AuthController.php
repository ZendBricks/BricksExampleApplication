<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Api\ApiInterface;
use User\Form\LoginForm;

/**
 * User Authentication
 */
class AuthController extends AbstractActionController
{
    protected $api;
    
    public function __construct(ApiInterface $api) {
        $this->api = $api;
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
