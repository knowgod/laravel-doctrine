<?php
/**
 * Created by PhpStorm.
 * User: arkadij
 * Date: 20.01.16
 * Time: 13:54
 */

namespace App\Doctrination\Testing;


trait EntityTrait
{
    /**
     * @param string $entityClass
     * @param array $data
     */
    protected function _getEntityWithData($entityClass, array $data)
    {
        $entity          = new $entityClass();
        $reflectionClass = new \ReflectionClass($entity);

        foreach ($data as $field => $value) {
            $method = 'set' . ucfirst($field);
            if (method_exists($entity, $method)) {
                $entity->$method($value);
            } else {
                $reflectionProperty = $reflectionClass->getProperty($field);
                $reflectionProperty->setAccessible(true);
                $reflectionProperty->setValue($entity, $value);
            }
        }

        return $entity;
    }
}