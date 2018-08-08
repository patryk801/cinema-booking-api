<?php

namespace AppBundle\Entity;


use Doctrine\Common\Annotations\AnnotationReader;

class EntityMerger
{
    private $annotationReader;

    public function __construct(AnnotationReader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * @param $entity
     * @param $changes
     */
    public function merge($entity, $changes): void
    {
        $entityClassName = get_class($entity);
        if(!$entityClassName) throw new \InvalidArgumentException('$entity is not a class');

        $changesClassName = get_class($changes);
        if(!$changesClassName) throw new \InvalidArgumentException('$changes is not a class');

        if(!is_a($changes, $entityClassName)) throw new \InvalidArgumentException('Cannot merge object of class $changesClassName with object of class $entityClassName.');

        $entityReflection = new \ReflectionObject($entity);
        $changesReflection = new \ReflectionObject($changes);

        foreach ($changesReflection->getProperties() as $changedProperty)
        {
            $changedProperty->setAccessible(true);
            $changedPropertyValue = $changedProperty->getValue($changes);

            if(is_null($changedPropertyValue)) continue;
            if(!$entityReflection->hasProperty($changedProperty->getName())) continue;

            $entityProperty = $entityReflection->getProperty($changedProperty->getName());
            $annotation = $this->annotationReader->getPropertyAnnotation($entityProperty, Id::class);

            if(!is_null($annotation)) continue;

            $entityProperty->setAccessible(true);
            $entityProperty->setValue($entity, $changedPropertyValue);
        }
    }
}