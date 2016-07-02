<?php

namespace User\Form;

use Zend\Form\Form;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Captcha;
use Zend\Captcha\Image;

class ChangePasswordForm extends Form
{
    public function __construct($useOldPassword = true) {
        parent::__construct();
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'panel-body');
        
        if ($useOldPassword) {
            $oldPassword = new Password('oldPassword');
            $oldPassword->setLabel('old.password');
            $oldPassword->setAttribute('class', 'form-control');
            $this->add($oldPassword);
        }
        
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
            'font' => __DIR__ . '/../../fonts/arial.ttf'
        ]);
        $imageAdapter->setHeight(100);
        $imageAdapter->setWidth(400);
        $imageAdapter->setFontSize(48);
        $imageAdapter->setDotNoiseLevel(400);
        $imageAdapter->setLineNoiseLevel(40);
        $captcha->setCaptcha($imageAdapter);
        $captcha->setLabel('enter.text.from.the.picture');
        $captcha->setAttribute('class', 'form-control');
        $this->add($captcha);
        
        $submit = new Submit('save');
        $submit->setValue('save');
        $submit->setAttribute('class', 'btn btn-default');
        $this->add($submit);
    }
}
