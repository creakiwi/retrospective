<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Creakiwi\Retrospective;

/**
 * A simple class to improve class' introspection
 *
 * @author mondedemerde
 */
class Retrospective
{
    /**
     *
     * @var string
     */
    private $class_name;

    /**
     *
     * @var \ReflectionClass
     */
    private $reflection;

    private $parent;

    /**
     * 
     * @param string $class_name
     * @throws \InvalidArgumentException
     */
    private function __construct($class_name) {
        if (is_string($class_name) === false) {
            throw new \InvalidArgumentException(sprintf('[%s] constructor argument "class_name" must be a string', __CLASS__));
        }

        $this->class_name = $class_name;
        $this->reflection = new \ReflectionClass($class_name);
    }

    /**
     * 
     * @param string $class_name
     * @return \Creakiwi\Retrospective\Retrospective
     */
    public static function intro($class_name)
    {
        return new Retrospective($class_name);
    }

    public function getClassName()
    {
        return $this->class_name;
    }

    /**
     * 
     * @param string $class_name
     * @param array $arguments
     * @return mixed
     */
    public static function getInstanceOf($class_name, array $arguments = array())
    {
    }

    /**
     * 
     * @param array $arguments
     * @return mixed
     */
    public function getInstance(array $arguments = array())
    {
        return self::getInstanceOf($this->class_name, $arguments);
    }

    /**
     * @return boolean
     */
    public function hasParent()
    {
        // Since getParentClass is not documented, we'll assume it returns null when no parent class
        // And I don't want to clone php and rgrep "getParentClass"
        return $this->reflection->getParentClass() !== null;
    }

    /**
     * 
     * @param array $arguments
     * @return mixed
     */
    public function getParent(array $arguments = array())
    {
        if ($this->parent === null) {
            $this->parent = self::getInstanceOf($this->reflection->getParentClass(), $arguments);
        }

        return $this->parent;
    }

    /**
     * @return boolean
     */
    public function hasInterface($interface)
    {
        return in_array($interface, $this->reflection->getInterfaceNames()) === true;
    }

    public function getInterfaces()
    {
        return $this->reflection->getInterfaceNames();
    }

    /**
     * @return boolean
     */
    public function hasTrait($trait)
    {
        return in_array($trait, $this->reflection->getTraitNames()) === true;
    }

    public function getTraits()
    {
        return $this->reflection->getTraitNames();
    }
}
