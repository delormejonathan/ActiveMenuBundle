<?php

namespace DelormeJonathan\ActiveMenuBundle\Twig;

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Jonathan DELORME <delorme.jonathan@gmail.com>
 */
class DelormeJonathanActiveMenuExtension extends \Twig_Extension
{
    protected $controllerName;

    /**
     * @param RequestStack $request
     */
    public function __construct(RequestStack $request)
    {
        $this->controllerName = $request->getCurrentRequest()->get('_controller');
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('bundle_name', array($this, 'getBundleName')),
            new \Twig_SimpleFunction('controller_name', array($this, 'getControllerName')),
            new \Twig_SimpleFunction('action_name', array($this, 'getActionName')),
        );
    }
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('is_bundle_active', array($this, 'isBundleActive')),
            new \Twig_SimpleFilter('is_controller_active', array($this, 'isControllerActive')),
            new \Twig_SimpleFilter('is_action_active', array($this, 'isActionName')),
        );
    }

    public function getBundleName()
    {
        preg_match("#^([a-zA-Z]*)Bundle\\\Controller#", $this->controllerName, $matches);

        if (isset ($matches[1]))
            return $matches[1];
        else
            return null;
    }

    public function getControllerName()
    {
        preg_match("#Controller\\\([a-zA-Z]*)Controller#", $this->controllerName, $matches);

        if (isset ($matches[1]))
            return $matches[1];
        else
            return false;
    }

    public function getFullControllerName()
    {
        preg_match("#^([\\a-zA-Z]*)::#", $this->controllerName, $matches);

        if (isset ($matches[1]))
            return str_replace('\\', '', $matches[1]);
        else
            return false;
    }

    public function getActionName()
    {
        preg_match("#::([a-zA-Z]*)Action#", $this->controllerName, $matches);

        if (isset ($matches[1]))
            return $matches[1];
        else
            return false;
    }

    public function isBundleActive($bundle, $class = null)
    {
        if ($this->getBundleName() == $bundle)
            return $class ? $class : null;
        else
            return false;
    }

    public function isControllerActive($controller, $class = null)
    {
        if ($this->getControllerName() == $controller || $this->getFullControllerName() == $controller)
            return $class ? $class : null;
        else
            return false;
    }

    public function isActionActive($action, $class = null)
    {
        if ($this->getActionName() == $action)
            return $class ? $class : null;
        else
            return false;
    }
}
