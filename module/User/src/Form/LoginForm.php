<?php

namespace User\Form;

use Zend\Form\Form;
use Zend\Form\Element\Text;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;

class LoginForm extends Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'panel-body');
        
        $username = new Text('username');
        $username->setLabel('username');
        $username->setAttribute('class', 'form-control');
        $this->add($username);
        
        $password = new Password('password');
        $password->setLabel('password');
        $password->setAttribute('class', 'form-control');
        $this->add($password);
        
        $submit = new Submit('login');
        $submit->setValue('login');
        $submit->setAttribute('class', 'btn btn-default');
        $this->add($submit);
    }
}
