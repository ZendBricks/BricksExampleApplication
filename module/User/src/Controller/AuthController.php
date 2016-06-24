<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Api\UserApiInterface;
use Zend\Authentication\AuthenticationService;
use User\Form\LoginForm;
use User\Form\RegisterForm;
use Zend\Crypt\Password\Bcrypt;
use User\Model\UserMailModel;

/**
 * User Authentication
 */
class AuthController extends AbstractActionController
{
    protected $api;
    protected $authService;
    protected $mailModel;
    protected $projectName;

    public function __construct(UserApiInterface $api, AuthenticationService $authService, UserMailModel $mailModel, $projectName) {
        $this->api = $api;
        $this->authService = $authService;
        $this->mailModel = $mailModel;
        $this->projectName = $projectName;
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
        $form = new RegisterForm();        
        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $formData = $form->getData();
                if ($this->api->getIdByUsername($formData['username'])) {
-                   $this->flashMessenger()->addErrorMessage('username.in.use');
                } elseif ($this->api->getIdByEmail($formData['email'])) {
                    $this->flashMessenger()->addErrorMessage('email.in.use');
                } else {
                    $bcrypt = new Bcrypt();
                    $passwordHash = $bcrypt->create($formData['password']);
                    $userId = $this->api->registerUser($formData['username'], $formData['email'], $passwordHash);
                    $token = openssl_random_pseudo_bytes(26);
                    $this->api->createRegisterToken($userId, $token);
                    $this->mailModel->sendConfirmRegistrationMail($formData['email'], $formData['username'], $token, $this->projectName);
                    return $this->redirect()->toRoute('home');
                }
            }        
        }        
        return [
            'form' => $form
        ];
    }
    
    public function confirmRegistrationAction()
    {
        $token = $this->params()->fromRoute('token');
        $userId = $this->api->getUserIdByRegisterToken($token);
        if ($userId) {
            
            $this->api->deleteRegisterToken($userId);
        } else {
            return $this->redirect()->toRoute('home');
        }
    }
    
    public function resendRegisterMailAction()
    {
        
    }
    
    public function forgotPasswordAction()
    {
        
    }
    
    public function selfDeleteAction()
    {
        
    }
    
    public function confirmSelfDeleteAction()
    {
        
    }
}
