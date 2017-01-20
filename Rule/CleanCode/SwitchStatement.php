<?php

namespace BTC\PHPMD\Rule\CleanCode;

use PHPMD\AbstractNode;
use PHPMD\AbstractRule;
use PHPMD\Node\MethodNode;
use PHPMD\Rule\MethodAware;

/**
 * Class SwitchStatement
 *
 * Try to avoid using switch-case statements. Use polymorphism instead.
 *
 * @package BTC\PHPMD\Rule\CleanCode
 */
class SwitchStatement extends AbstractRule implements MethodAware
{
    /**
     * This method should implement the violation analysis algorithm of concrete
     * rule implementations. All extending classes must implement this method.
     *
     * @param AbstractNode|MethodNode $node
     */
    public function apply(AbstractNode $node)
    {
        $switchStatements = $node->findChildrenOfType('SwitchStatement');

        foreach ($switchStatements as $switchStatement) {
            $this->addViolation($switchStatement);
        }
    }
}
