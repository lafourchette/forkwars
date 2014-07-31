<?php

namespace Forkwars\Tests;

use Prophecy\Prophet;

/**
 * Class ProphecyTestCase
 * Ease Test writing with prophecy by providing some usefull mocking methods.
 *
 * @package LaFourchette\CoreBundle\Tests
 */
abstract class ProphecyTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Prophet
     */
    protected $__prophet;

    /**
     * @var array Mocks array. Populated by __get and __set.
     */
    protected $__mocks = array();

    /**
     * @{inheritdocs}
     */
    public function setUp()
    {
        $this->__prophet = new Prophet();
    }

    /**
     * @{inheritdocs}
     */
    public function tearDown()
    {
        $this->__prophet->checkPredictions();
        unset($this->__prophet);
    }

    /**
     * Check if mock variable name accessible by magics __get and __set is right.
     *
     * @param $name Variable name
     * @return bool
     */
    private function isValidMockVarName($name)
    {
        return (stripos($name, 'mock') === 0);
    }

    /**
     * Access only mocks.
     * @{inheritdocs}
     */
    public function __set($name, $value)
    {
        if (! $this->isValidMockVarName($name)) {
            throw new \Exception('Unknown variable ' . $name);
        }

        $this->__mocks[$name] = $value;
    }

    /**
     * Access only mocks.
     * @{inheritdocs}
     */
    public function __get($name)
    {
        if (! $this->isValidMockVarName($name)) {
            throw new \Exception('Unknown variable ' . $name);
        }

        if (! array_key_exists($name, $this->__mocks)) {
            throw new \Exception('Mock variable not set ' . $name . '. Availables are ' . join(', ', array_keys($this->__mocks)));
        }

        return $this->__mocks[$name];
    }

    public function createInstanceWithoutConstructor($className)
    {
        if (method_exists('ReflectionClass', 'newInstanceWithoutConstructor')) {
            $reflClass = new \ReflectionClass($className);

            return $reflClass->newInstanceWithoutConstructor();
        }

        $serialized = sprintf('O:%d:"%s":0:{}', strlen($className), $className);

        return unserialize($serialized);
    }

    public function prophesize($className)
    {
        if (! class_exists($className) && ! interface_exists($className)) {
            throw new \Exception("$className class/interface does not exists");
        }

        return $this->__prophet->prophesize($className);
    }

    /**
     * Spawn className instance and builds mock by inspecting constructor.
     * Very usefull for manager instanciating.
     *
     * @param $className
     */
    public function spawn($className, array $hints = array())
    {
        $class = new \ReflectionClass($className);
        $constructor = $class->getConstructor();
        $constructorParameters = $constructor->getParameters();

        // Loop through all class' constructors parameters in order to mock them
        $instanceParameters = array();
        foreach ($constructorParameters as $cp) {
            // Optionnal parameters are nulled
            if ($cp->isOptional()) {
                array_push($instanceParameters, 'null');
                continue;
            }

            $name = $cp->getName();
            $mockName = 'mock' . ucfirst($name);
            $pClass = $cp->getClass();
            if ($pClass == null) {
                if (! isset($hints[$name])) {
                    throw new \Exception('I dont know how to build this instance, cause typehinting for parameter '.$name.' is missing. Use $hints parameter.');
                }
                $pClass = $hints[$name];
                if (! class_exists($pClass) && ! interface_exists($pClass)) {
                    throw new \Exception($pClass . ' cannot be found. Please review the $hints.');
                }
            } else {
                $pClass = $pClass->getName();
                // add a slash for resolution
                if ($pClass[0] !== '\\') {
                    $pClass = '\\' . $pClass;
                }
            }

            // Create the mock and add it to mock array
            $this->$mockName = $this->prophesize($pClass);
            array_push($instanceParameters, $this->$mockName->reveal());
        }

        // We can create an instance safely now... magic !
        return $class->newInstanceArgs($instanceParameters);
    }
}
