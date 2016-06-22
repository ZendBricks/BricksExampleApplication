<?php

namespace User\Model;

use Application\Model\MailModel;
use Zend\Mail\Message as MailMessage;

class UserMailModel extends MailModel
{
    public function sendConfirmRegistrationMail($projectName, $username, $token) {
        $translator = $this->getTranslator();
        $mail = new MailMessage();
        $mail->setSubject(sprintf($translator->translate('confirm.registration.at.%s'), $projectName));
        
        $viewVariables = [
            'projectName' => $projectName,
            'username' => $username,
            'token' => $token
        ];
        
        $mail = $this->prepareMail($mail, $viewVariables, 'mail/confirm-registration.phtml');
        $this->sendMail($mail);
    }
}
