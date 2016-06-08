<?php

namespace Application\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class PdoFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName)
    {
        $config = $container->get('Config');
        $dbConfig = $config['pdo_mysql'];
        return new PDO('mysql:host=' . $dbConfig['host'] . ';dbname=' . $dbConfig['dbname'] . ';charset=utf8',
            $dbConfig['user'],
            $dbConfig['password'],
            [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES "utf8"']
        );
    }   
}
