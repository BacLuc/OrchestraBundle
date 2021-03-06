<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Annotation;

use RomaricDrigon\OrchestraBundle\Exception\AnnotationException;

/**
 * Class AbstractAnnotation
 * Allow to create annotation in the form @ Annotation("value", option1="value1"...)
 *
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
abstract class AbstractAnnotation
{
    /**
     * Will build annotation, using extending class setters to set options of the annotation
     *
     * @param array $options
     * @throws AnnotationException if our Annotation has options not allowed or if our Annotation has a value and it shouldn't
     */
    public function __construct($options)
    {
        // Parse if our Annotation has a value
        if (isset($options['value'])) {
            $property = $this->getValueProperty();

            if (false === $property) {
                $reflect = new \ReflectionClass($this);
                $annotationName = $reflect->getShortName();

                throw new AnnotationException('@'.$annotationName.'("value") is not a valid syntax');
            }

            $options[$property] = $options['value'];

            unset($options['value']);
        }

        foreach ($options as $key => $value) {
            $setterName = 'set'.ucfirst($key);

            if (! method_exists($this, $setterName)) {
                $reflect = new \ReflectionClass($this);
                $annotationName = $reflect->getShortName();

                throw new AnnotationException('Annotation '.$annotationName.' does not have a '.$key.' option');
            }

            $this->$setterName($value);
        }
    }

    /**
     * Returns the name of the class property where the annotation value should be copied into
     * Returns "false" if the annotation can not have a value (only options)
     *
     * @return string|false
     */
    abstract protected function getValueProperty();
}
