<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Routing;

use RomaricDrigon\OrchestraBundle\Exception\LoaderAddedTwiceException;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class OrchestraRouteLoader
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class OrchestraRouteLoader implements LoaderInterface
{
    /**
     * @var RepositoryRouteBuilder
     */
    private $repositoryRouteBuilder;

    private $loaded = false;

    public function __construct(RepositoryRouteBuilder $repositoryRouteBuilder)
    {
        $this->repositoryRouteBuilder = $repositoryRouteBuilder;
    }

    /**
     * @inheritdoc
     */
    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new LoaderAddedTwiceException();
        }

        $routes = new RouteCollection();

        // First routes are used first!
        // We start by routes from Repositories
        $repositoriesRoutes = $this->repositoryRouteBuilder->getCollection();
        $routes->addCollection($repositoriesRoutes);

        $this->loaded = true;

        return $routes;
    }

    /**
     * @inheritdoc
     */
    public function supports($resource, $type = null)
    {
        return 'orchestra' === $type;
    }

    /**
     * Not used
     * @return void
     */
    public function getResolver()
    {
    }

    /**
     * Not used
     * @param LoaderResolverInterface $resolver
     */
    public function setResolver(LoaderResolverInterface $resolver)
    {
    }
} 