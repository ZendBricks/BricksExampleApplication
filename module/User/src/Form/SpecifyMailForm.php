<?php

namespace User\Form;

use Zend\Form\Form;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Email;
use Zend\Form\Element\Captcha;
use Zend\Captcha\Image;

class SpecifyMailForm extends Form
{
    public function __construct() {
        parent::__construct();
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'panel-body');
        
        $mail = new Email('email');
        $mail->setLabel('email');
        $mail->setAttribute('class', 'form-control');
        $this->add($mail);
        
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
        
        $submit = new Submit('send');
        $submit->setValue('send');
        $submit->setAttribute('class', 'btn btn-default');
        $this->add($submit);
    }
}
