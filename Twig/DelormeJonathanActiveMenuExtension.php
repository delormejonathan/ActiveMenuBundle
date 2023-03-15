<?php

namespace DelormeJonathan\ActiveMenuBundle\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * @author Jonathan DELORME <delorme.jonathan@gmail.com>
 */
class DelormeJonathanActiveMenuExtension extends AbstractExtension
{
    private $request;
    private $controllerName;

    /**
     * @param RequestStack $request
     */
    public function __construct(RequestStack $request)
    {
        $this->request = $request;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('bundle_name', [$this, 'getBundleName']),
            new TwigFunction('controller_name', [$this, 'getControllerName']),
            new TwigFunction('action_name', [$this, 'getActionName']),
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('is_bundle_active', [$this, 'isBundleActive']),
            new TwigFilter('is_controller_active', [$this, 'isControllerActive']),
            new TwigFilter('is_action_active', [$this, 'isActionActive']),
        ];
    }

    public function getBundleName(): ?string
    {
        if (!$this->controllerName) {
            $this->controllerName = $this->request->getCurrentRequest()->get('_controller');
        }

        preg_match("#^([\\a-zA-Z]*)Bundle\\\Controller#", $this->controllerName, $matches);

        if (isset ($matches[1])) {
            return $matches[1];
        }

        return null;
    }

    public function getBundleClass()
    {
        if (!$this->controllerName) {
            $this->controllerName = $this->request->getCurrentRequest()->get('_controller');
        }

        preg_match("#^([\\a-zA-Z]*)\\\Controller#", $this->controllerName, $matches);

        if (isset ($matches[1])) {
            return sprintf('%s\\%s', $matches[1], $matches[1]);
        }

        return null;
    }

    public function getControllerName(): string
    {
        if (!$this->controllerName) {
            $this->controllerName = $this->request->getCurrentRequest()->get('_controller');
        }

        preg_match("#Controller\\\([a-zA-Z\\\]+)Controller#", $this->controllerName, $matches);

        if (isset ($matches[1])) {
            return $matches[1];
        }

        return false;
    }

    public function getFullControllerName()
    {
        if (!$this->controllerName) {
            $this->controllerName = $this->request->getCurrentRequest()->get('_controller');
        }

        preg_match("#^([\\a-zA-Z]*)::#", $this->controllerName, $matches);

        if (isset ($matches[1])) {
            return str_replace('\\', '', $matches[1]);
        }

        return false;
    }

    public function getActionName(): string
    {
        if (!$this->controllerName) {
            $this->controllerName = $this->request->getCurrentRequest()->get('_controller');
        }

        preg_match("#::([a-zA-Z]*)Action#", $this->controllerName, $matches);

        if (isset ($matches[1])) {
            return $matches[1];
        }

        preg_match("#::([a-zA-Z]*)#", $this->controllerName, $matches);

        if (isset ($matches[1])) {
            return $matches[1];
        }

        return false;
    }

    public function isBundleActive($bundle, $class = 'active')
    {
        if ($this->getBundleName() == $bundle) {
            return $class ? $class : null;
        }

        return false;
    }

    public function isControllerActive($controller, $class = 'active')
    {
        if (is_array($controller)) {
            foreach ($controller as $item) {
                if ($this->getControllerName() == $item || $this->getFullControllerName() == $item) {
                    return $class;
                }
            }
        }

        if ($this->getControllerName() == $controller || $this->getFullControllerName() == $controller) {
            return $class;
        }

        return false;
    }

    public function isActionActive($action, $class = 'active')
    {
        if (is_array($action)) {
            foreach ($action as $item) {
                list($controller, $action) = explode('::', $item);
                if (($this->getFullControllerName() == $controller || $this->getControllerName() == $controller) && $this->getActionName() == $action) {
                    return $class;
                }
            }
        } else {
            if ($this->getActionName() == $action) {
                return $class ? $class : null;
            }
        }

        return false;
    }
}
