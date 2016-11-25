ActiveMenuBundle
====================

## Installation
    composer require delormejonathan/active-menu-bundle

    public function registerBundles()
    {
        $bundles = array(
            new DelormeJonathan\ActiveMenuBundle\DelormeJonathanActiveMenuBundle(),
        );

### Usage in your twig template

For example, if you have this action `AppBundle\Controller\ElementsController::list`, you can

Get the current bundle name

    {{ get_bundle_name() }}

Get the current controller name

    {{ get_controller_name() }}

Get the current action name

    {{ get_action_name() }}

Test the current route

    <!-- classname is the string returned if controller matchs (you can replace by 'active' or 'current') -->
    <li class="{{ 'AppBundle\Controller\ElementsController' | isControllerActive('classname') }}"></li>
    <li class="{{ 'Elements' | isControllerActive('classname') }}"></li>
    <li class="{{ 'list' | isActionActive('classname') }}"></li>