<?php

namespace Application\Model;

use Zend\View\Renderer\RendererInterface;
use Zend\Mail\Transport\Factory;
use Zend\Mime\Part;
use Zend\Mime\Message as MimeMessage;
use Zend\View\Model\ViewModel;
use Zend\Mail\Message as MailMessage;

class MailModel
{
    protected $transport;
    protected $senderMail;
    protected $senderName;
    protected $targets = [];
    protected $renderer;

    public function __construct(array $mailConfig, RendererInterface $renderer) {
        if (!array_key_exists('mail', $mailConfig)) {
            throw new \Exception('mail-config is incomplete!');
        }
        $this->mailAddress = $mailConfig['mail']['senderMail'];
        $this->senderName = $mailConfig['mail']['senderName'];
        if (array_key_exists('transport', $mailConfig['mail']) && is_array($mailConfig['mail']['transport'])) {
            $this->transport = Factory::create($mailConfig['mail']['transport']);
        } else {
            $this->transport = Factory::create([]);
        }
        $this->renderer = $renderer;
    }

    public function addTarget($mailAddress, $username) {
        $this->targets[$mailAddress] = $username;
    }
    
    /**
     * @return \Zend\I18n\Translator\TranslatorInterface
     */
    protected function getTranslator()
    {
        return $this->renderer->getHelperPluginManager()->get('translate')->getTranslator();
    }

    protected function prepareMail(MailMessage $mail, array $viewVariables, $mailTemplateName) {
        $mailBodyOutput = $this->getRenderContent($viewVariables, $mailTemplateName);
        $mailBodyOutput = htmlspecialchars_decode(htmlentities($mailBodyOutput, ENT_NOQUOTES, 'UTF-8', false), ENT_NOQUOTES);
        
        $content = new MimeMessage();
        $part = new Part($mailBodyOutput);
        $part->type = 'text/html';
        $content->addPart($part);
        
        $mail->addFrom($this->mailAddress, $this->senderName);
        $this->addMailTargets($mail);
        $mail->setEncoding('UTF-8');
        $mail->setBody($content);
    }
    
    protected function addMailTargets(MailMessage $mail) {
        foreach ($this->targets as $email => $username) {
            $mail->addTo($email, $username);
        }
    }
    
    protected function getRenderContent(array $variables, $mailTemplateName) {
        $viewModel = new ViewModel($variables);
        $viewModel->setTemplate($mailTemplateName);
        $viewModel->setTerminal(true);
        
        return $this->renderer->render($viewModel);
    }
    
    protected function sendMail($mail) {
        $this->transport->send($mail);
    }
}