<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Controller;

use RomaricDrigon\OrchestraBundle\Core\Entity\EntityReflectionInterface;
use RomaricDrigon\OrchestraBundle\Domain\RepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class GenericController
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 *
 * "Base" controller our Request goes to
 */
class GenericController extends Controller
{
    /**
     * Action for the dashboard page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardAction()
    {
        return $this->render('RomaricDrigonOrchestraBundle:Generic:dashboard.html.twig', []);
    }

    /**
     * Action used when a repository "listing" is called
     *
     * @param RepositoryInterface $repository
     * @param string $repository_slug
     * @param string $repository_method
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(RepositoryInterface $repository, $repository_slug, $repository_method)
    {
        $name = $this->get('orchestra.resolver.repository_name')->getName($repository);

        // We will need corresponding entity, fetch it
        $entityReflection = $this->get('orchestra.resolver.repository_entity')->findBySlug($repository_slug);

        // TODO: checks security (from annotation on repo)

        // Finish to build repository in case it's a BaseRepository
        // doing it there provide some value of lazy-loading
        $this->get('orchestra.doctrine.repository_injecter')->injectDoctrine($repository, $entityReflection);

        // TODO: run repo

        return $this->render('RomaricDrigonOrchestraBundle:Generic:list.html.twig', [
            'content'   => 'repository '.$repository_slug.' method '.$repository_method,
            'title'     => $name
        ]);
    }

    /**
     * Action used when a method on en Entity is called
     *
     * @param EntityReflectionInterface $entity
     * @param string $entity_slug
     * @param string $entity_method name
     * @param string $method_slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function entityMethodAction(EntityReflectionInterface $entity, $entity_slug, $entity_method, $method_slug)
    {
        return $this->render('RomaricDrigonOrchestraBundle:Generic:dashboard.html.twig', []);
    }
}