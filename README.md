# GenjFaqBundle

The GenjFaqBundle allows you to display a FAQ on your website, with the questions being grouped in categories. Features:

* Questions are grouped into Categories
* Categories can be deactivated
* Sonata admin module is provided
* Can show all information at once, or collapse questions/categories for big FAQs
* Collapsed mode generates SEO friendly URLs



## Requirements

* Symfony 2.4
* GedmoDoctrineExtensions - https://packagist.org/packages/gedmo/doctrine-extensions

Optional:

* DoctrineFixturesBundle - https://packagist.org/packages/doctrine/doctrine-fixtures-bundle
* SonataAdminBundle - https://packagist.org/packages/sonata-project/admin-bundle



## Installation

Add this to your composer.json:

```json
    ...
    "require": {
        ...
        "genj/faq-bundle": "dev-master"
        ...
```

Then run `composer update`. After that is done, enable the bundle in your AppKernel.php:

```php
# app/AppKernel.php
class AppKernel extends Kernel
{
    public function registerBundles() {
        $bundles = array(
            ...
            new Genj\FaqBundle\GenjFaqBundle()
            ...
```

Add the routing rules to your routing.yml:

```yml
# app/config/routing.yml
genj_faq:
    resource: "@GenjFaqBundle/Resources/config/routing.yml"
```

Finally, update your database schema:

```bash
php app/console doctrine:schema:update
```

And you're done. You should now be able to reach the bundle under the /faq URL.

*Optional: enabling the admin tool*

todo

*Optional: loading fixtures*

If you use the doctrine-fixtures bundle, you can load fixtures like this:

```bash
php app/console doctrine:fixtures:load --fixtures=vendor/genj/faq-bundle/Genj/FaqBundle/DataFixtures
```


## Configuration

You can optionally include the configuration below into your config.yml:

```yml
genj_faq:
    select_first_category_by_default: false
    select_first_question_by_default: false
```

Both configuration options only apply to the collapsed view. They will open the first category and/or question by
default if the user has not chosen a category and/or question yet. The default for both values is 'false', so set them
to 'true' if you want this behaviour.

Note that it is also required to have the Sluggable and Timestampable behaviours configured for gedmo/doctrine-extensions.


## FAQ

* I want to add fields to my Question or Category



## ToDo

* Add tests
* Sluggable Question unique within 1 category