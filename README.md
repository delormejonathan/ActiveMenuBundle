ActiveMenuBundle
====================

## Installation
    composer require delormejonathan/active-menu-bundle

```php
public function registerBundles()
{
    $bundles = array(
        new DelormeJonathan\ActiveMenuBundle\DelormeJonathanActiveMenuBundle(),
    );
```

### Usage in your twig template

For example, if you have this action `AppBundle\Controller\ElementsController::list`, you can

Get the current bundle name

```html
{{ bundle_name() }}
```

Get the current controller name

```html
{{ controller_name() }}
```

Get the current action name

```html
{{ action_name() }}
```

Test the current route

```html
<!-- classname is the string returned if controller matchs (you can replace it by 'active' or 'current') -->
<li class="{{ 'AppBundle\Controller\ElementsController' | isControllerActive('classname') }}"></li>
<li class="{{ 'Elements' | isControllerActive('classname') }}"></li>
<li class="{{ 'list' | isActionActive('classname') }}"></li>
```