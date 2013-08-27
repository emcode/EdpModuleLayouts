<?php
namespace EdpModuleLayouts;

class Module
{
    public function onBootstrap($e)
    {
        $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractController', 'dispatch', function($e) {

            $controller = $e->getTarget();
            $controllerClass = get_class($controller);
            $config = $e->getApplication()->getServiceManager()->get('config');

            if (!isset($config['module_layouts']))
            {
                return;
            }

            $moduleLayouts = $config['module_layouts'];

            foreach($moduleLayouts as $moduleNamespace => $layoutName)
            {
               if (strpos($controllerClass, $moduleNamespace) === 0)
               {
                   $controller->layout($layoutName);
                   break;
               }
            }

        }, 100);
    }
}
