<?php

namespace User\Form;

use Zend\Form\Form;
use Zend\Form\Element\Text;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Email;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Captcha;
use Zend\Captcha\Image;

class RegisterForm extends Form
{
    public function __construct($basePath) {
        parent::__construct();
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'panel-body');
        
        $username = new Text('username');
        $username->setLabel('username');
        $username->setAttribute('class', 'form-control');
        $username->setAttribute('data-urr', '/isusernameinuse');
        $this->add($username);
        
        $mail = new Email('email');
        $mail->setLabel('email');
        $mail->setAttribute('class', 'form-control');
        $this->add($mail);
        
        $password = new Password('password');
        $password->setLabel('password');
        $password->setAttribute('class', 'form-control');
        $this->add($password);
        
        $password2 = new Password('password2');
        $password2->setLabel('repeat.password');
        $password2->setAttribute('class', 'form-control');
        $this->add($password2);
        
        $captcha = new Captcha('register_captcha');
        $imageAdapter = new Image([
            'font' => __DIR__ . '/../../../fonts/arial.ttf'
        ]);
        $imageAdapter->setImgDir(__DIR__ . '/../../../../public/img/captcha/');
        $imageAdapter->setImgUrl($basePath . '/img/captcha/');
        $captcha->setCaptcha($imageAdapter);
        $captcha->setLabel('enter.text.from.the.picture');
        $captcha->setAttribute('class', 'form-control');
        $this->add($captcha);
        
        $agb = new Checkbox('agbaccept');
        $agb->setLabel('accept.terms.of.gtc');
        $agb->setAttribute('class', 'form-control');
        $agb->setLabelAttributes(['class' => 'checkboxLabel']);
        $this->add($agb);
        
        $submit = new Submit('register');
        $submit->setValue('register');
        $submit->setAttribute('class', 'btn btn-default');
        $this->add($submit);
    }
}
