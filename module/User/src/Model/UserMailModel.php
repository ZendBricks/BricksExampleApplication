<?php

namespace User\Model;

use Application\Model\MailModel;
use Zend\Mail\Message as MailMessage;

class UserMailModel extends MailModel
{
    public function sendConfirmRegistrationMail($email, $username, $token, $projectName)
    {
        $translator = $this->getTranslator();
        $mail = new MailMessage();
        $mail->setSubject(sprintf($translator->translate('confirm.registration.at.%s'), $projectName));
        $this->addTarget($email, $username);
        
        $viewVariables = [
            'projectName' => $projectName,
            'username' => $username,
            'token' => $token
        ];
        
        $this->prepareMail($mail, $viewVariables, 'mail/confirm-registration.phtml');
        $this->sendMail($mail);
    }
    
    public function sendForgotPasswordMail($email, $username, $token, $projectName)
    {
        $translator = $this->getTranslator();
        $mail = new MailMessage();
        $mail->setSubject(sprintf($translator->translate('forgot.password.at.%s'), $projectName));
        $this->addTarget($email, $username);
        
        $viewVariables = [
            'projectName' => $projectName,
            'username' => $username,
            'token' => $token
        ];
        
        $this->prepareMail($mail, $viewVariables, 'mail/forgot-password.phtml');
        $this->sendMail($mail);
    }
}
