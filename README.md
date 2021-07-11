# Rabble Field Type Bundle
This bundle provides a way to create field types to be used dynamically in Symfony forms.
Also included are value resolvers which are objects that transform a value from a field type to a human-friendly format. 

# Installation
Install the bundle by running
```sh
composer require rabble/field-type-bundle
```

Add the following class to your `config/bundles.php` file:
```php
return [
    ...
    Rabble\FieldTypeBundle\RabbleFieldTypeBundle::class => ['all' => true],
]
```
