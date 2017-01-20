<?php

namespace BTC\PHPMD\Rule\CleanCode;

use PHPMD\AbstractNode;
use PHPMD\AbstractRule;
use PHPMD\Node\ClassNode;
use PHPMD\Rule\MethodAware;

/**
 * Class MeaninglessMethodName
 *
 * Try to avoid meaningless method names. You or other developers don't understand what the method does in a few month.
 *
 * @package BTC\PHPMD\Rule\CleanCode
 */
class MeaninglessMethodName extends AbstractRule implements MethodAware
{
    /**
     * This method should implement the violation analysis algorithm of concrete
     * rule implementations. All extending classes must implement this method.
     *
     * @param AbstractNode|ClassNode $node
     */
    public function apply(AbstractNode $node)
    {
        $meaninglessNames = $this->getStringProperty('meaninglessNames');
        $delimiter = $this->getStringProperty('delimiter');
        $methodName = $node->getImage();

        if (in_array(strtolower($methodName), explode($delimiter, strtolower($meaninglessNames)))) {
            $this->addViolation($node, [$methodName, $meaninglessNames]);
        }
    }
}
