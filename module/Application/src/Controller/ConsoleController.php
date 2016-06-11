<?php

namespace Application\Controller;

use Zend\Mvc\Console\Controller\AbstractConsoleController;
use Interop\Container\ContainerInterface;

class ConsoleController extends AbstractConsoleController
{
    protected $container;
    
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function clearCacheAction()
    {
        $config = $this->container->get('Config');
        if (array_key_exists('caches', $config)) {
            $caches = array_keys($config['caches']);
            foreach ($caches as $cache) {
                $this->container->get($cache)->flush();
                echo "flushed cache: $cache\n";
            }
        }
    }
}
