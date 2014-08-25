Orchestra Bundle
================

Orchestra is a Naked Object implementation on top of Symfony2
Available as a Symfony2 Bundle

## Installation

Install bundle using composer: `composer require romaricdrigon/orchestra-bundle`

Register the bundle and the vendor we use in `app/AppKernel.php`:
```php
    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                // ...

                new RomaricDrigon\OrchestraBundle\RomaricDrigonOrchestraBundle(),
                new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            );
```

Import our routes (both the XML and our custom type):
```yaml
    # app/config/routing.yml
    orchestra_routing:
        resource: '@RomaricDrigonOrchestraBundle/Resources/config/routing.xml'
        prefix: /admin

    orchestra_generated:
        prefix: /admin
        resource: .
        type: orchestra
```

## Getting started

With Orchestra admin generator you will have to focus only on 2 objects: `Repositories` and `Aggregates`.
All those objects must be placed within a valid Symfony2 bundle.

### Repositories

We advise you to place those, by convention, in your bundle within a `Repository` folder.
By convention, their name will be the name of the `Entity` suffixed by `Repository` but you're free to do otherwise.

Those are NOT Doctrine repositories!
We stick to the original Repository pattern (Fowler, 2002), "a collection-like interface for accessing domain objects".

### Basic repository

They must implement `RomaricDrigon\OrchestraBundle\Domain\RepositoryInterface`.

```php
    use RomaricDrigon\OrchestraBundle\Domain\RepositoryInterface;
    use RomaricDrigon\OrchestraBundle\Annotation\Name;

    class MyRepository implements RepositoryInterface
    {
```

They must be declared as services, tagged with `orchestra.repository`.

```xml
    <!-- your bundle services.xml -->
    <?xml version="1.0" ?>
    <container xmlns="http://symfony.com/schema/dic/services"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd">

        <services>
            <service id="romaric_drigon_example.my_repository" class="My\Repository\Class\Path">
                <tag name="orchestra.repository" />
            </service>
            ...
```

#### Customize displayed name

The name displayed for the Repository can be automatically generated, from the class name, or optionally personalized using the `@Name` annotation.

Example:
```php
    use RomaricDrigon\OrchestraBundle\Domain\RepositoryInterface;
    use RomaricDrigon\OrchestraBundle\Annotation\Name;

    /**
     * @Name("CustomName")
     */
    class MyRepository implements RepositoryInterface
    {
```

## Configuration

You can configure the Bundle by putting those settings in your `config.yml`:
```yaml
    # app/config/config.yml
    romaric_drigon_orchestra:
        app_title: Orchestra # default. Will be used as title (prefix) for pages
```

## Misc

IE8 is not supported by provided templates. Twitter Bootstrap is missing its JS polyfills, and we are using jQuery 2.0

## Thanks

Twitter Bootstrap integration have been realized using templates from [Braincrafted Bootstrap bundle](https://github.com/braincrafted/bootstrap-bundle)