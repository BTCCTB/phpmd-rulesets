<?php

namespace BTC\PHPMD\Rule\CleanCode;

use PDepend\Source\AST\ASTMethod;
use PHPMD\AbstractNode;
use PHPMD\AbstractRule;
use PHPMD\Node\MethodNode;
use PHPMD\Node\TraitNode;
use PHPMD\Rule\MethodAware;

/**
 * Class TraitPublicMethod
 *
 * The purpose of a trait should be the reuse of methods which help the basic classes. Make your code clearly and define interfaces of your class as public methods.
 *
 * @package BTC\PHPMD\Rule\CleanCode
 */
class TraitPublicMethod extends AbstractRule implements MethodAware
{
    /**
     * This method should implement the violation analysis algorithm of concrete
     * rule implementations. All extending classes must implement this method.
     *
     * @param AbstractNode|MethodNode|ASTMethod $node
     */
    public function apply(AbstractNode $node)
    {
        if ($node->getParentType() instanceof TraitNode && true === $node->isPublic()) {
            $this->addViolation($node);
        }
    }
}
