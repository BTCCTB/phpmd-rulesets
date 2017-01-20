<?php

namespace BTC\PHPMD\Rule\CleanCode;

use PHPMD\AbstractNode;
use PHPMD\AbstractRule;
use PHPMD\Node\MethodNode;
use PHPMD\Rule\MethodAware;

/**
 * Class InlineIf
 *
 * Try to avoid using inline ifs. They conceal the complexity of your code.
 * Furthermore they obstruct the expandability. Refactor your code and increase the readability.
 *
 * @package BTC\PHPMD\Rule\CleanCode
 */
class InlineIf extends AbstractRule implements MethodAware
{
    /**
     * This method should implement the violation analysis algorithm of concrete
     * rule implementations. All extending classes must implement this method.
     *
     * @param AbstractNode|MethodNode $node
     */
    public function apply(AbstractNode $node)
    {
        $conditionalExpressions = $node->findChildrenOfType('ConditionalExpression');
        foreach ($conditionalExpressions as $conditionalExpression) {
            $this->addViolation($conditionalExpression);
        }
    }
}
