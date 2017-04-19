# GenjFaqBundle

The GenjFaqBundle allows you to display a FAQ on your website, with the questions being grouped in categories. Features:

* Questions are grouped into Categories
* Categories can be deactivated
* Can show all information at once, or collapse questions/categories for big FAQs
 that is basically up to you - how you are handling this in the template
* Collapsed mode generates SEO friendly URLs



## Requirements

see composer.json


## Installation

Add this to your composer.json:

```
    ...
    "require": {
        ...
        "gedmo/doctrine-extensions": ">=2.4.10",
        "genj/faq-bundle": "dev-master"
        ...
```

Then run `composer update`. After that is done, enable the bundle in your AppKernel.php:

```
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

```
# app/config/routing.yml
genj_faq:
    resource: "@GenjFaqBundle/Resources/config/routing.yml"
```

Finally, update your database schema:

```
php bin/console doctrine:schema:update --dump-sql
```

use the ```--force``` option to actually execute the DB update.

And you're done.
You should now be able to reach the bundle under the http://yourproject.com/faq URL
if you did add at least one category in your DB.


*Optional: loading fixtures*

If you use the doctrine-fixtures bundle, you can load fixtures like this:

```
php bin/console doctrine:fixtures:load --fixtures=vendor/genj/faq-bundle/src/Genj/FaqBundle/DataFixtures/
```


## Configuration

You can optionally include the configuration below into your config.yml:

```
genj_faq:
    select_first_category_by_default: false
    select_first_question_by_default: false
```

Both configuration will open the first category and/or question by default if the user has not
chosen a category and/or question yet. The default for both values is 'false', so set them
to 'true' if you want this behaviour.

Note that it is also required to have the Sluggable and Timestampable behaviours configured for
gedmo/doctrine-extensions (see https://github.com/Atlantic18/DoctrineExtensions).


## FAQ

* How do I add this to SonataAdmin?

You can use the GenjFaqAdminBundle:
https://github.com/genj/GenjFaqAdminBundle
or just create your own admin class.
