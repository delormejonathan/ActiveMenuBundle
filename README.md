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

## Usage in your twig template

For example, if you have this action `AppBundle\Controller\ElementsController::list`, you can

Get the current bundle name

```html
{{ bundle_name() }} # returns App
```

Get the current controller name

```html
{{ controller_name() }} # returns Elements
```

Get the current action name

```html
{{ action_name() }} # returns list
```

**Controller filter**

It works with both full and short paths

```html
<!-- classname is the string returned if controller matchs (you can replace it by 'active' or 'current') -->
<li class="{{ 'AppBundle\Controller\ElementsController' | is_controller_active('classname') }}"></li>
<li class="{{ 'Elements' | is_controller_active('classname') }}"></li>
```

**Action filter**

```html
<!-- classname is the string returned if controller matchs (you can replace it by 'active' or 'current') -->
<li class="{{ 'list' | is_action_active('classname') }}"></li>
```


**Combined controller/action filter**

```html
<!-- classname is the string returned if controller matchs (you can replace it by 'active' or 'current') -->
<li class="{{ [ 'Elements::list' ] | is_action_active('classname') }}"></li>
```
