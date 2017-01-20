<?php

namespace BTC\PHPMD\Rule\Symfony;

use PHPMD\AbstractNode;
use PHPMD\AbstractRule;
use PHPMD\Node\MethodNode;
use PHPMD\Rule\MethodAware;

/**
 * Class ConstructorNewOperator
 *
 * Resolve strong dependency by simply inject the new instance via DI. So your class is more flexible.
 *
 * @package BTC\PHPMD\Rule\Symfony
 */
class ConstructorNewOperator extends AbstractRule implements MethodAware
{
    /**
     * This method should implement the violation analysis algorithm of concrete
     * rule implementations. All extending classes must implement this method.
     *
     * @param AbstractNode|MethodNode $node
     */
    public function apply(AbstractNode $node)
    {
        $classReferences = $node->findChildrenOfType('ClassReference');

        if ('__construct' !== $node->getImage() || 0 === count($classReferences)) {
            return;
        }

        $allowedClassNames = explode($this->getStringProperty('delimiter'), $this->getStringProperty('allowedClassNames'));

        foreach ($classReferences as $classReference) {
            if (false === $this->containsClassName($classReference->getImage(), $allowedClassNames)) {
                $this->addViolation($classReference);
            }
        }
    }

    /**
     * Check class name
     *
     * @param string $className
     * @param array  $allowedClassNames
     *
     * @return bool
     */
    private function containsClassName($className, array $allowedClassNames)
    {
        foreach ($allowedClassNames as $allowedClassName) {
            if (false !== stripos($className, $allowedClassName)) {
                return true;
            }
        }

        return false;
    }
}
