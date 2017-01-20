<?php

namespace BTC\PHPMD\Rule\Symfony;

use PDepend\Source\AST\ASTClass;
use PHPMD\AbstractNode;
use PHPMD\Node\ClassNode;

/**
 * Class EntityConstants
 *
 * Don't contain constants in your entity. Important information are distribute throughout the project. You reduce the reusability.
 *
 * @package BTC\PHPMD\Rule\Symfony
 */
class EntityConstants extends AbstractEntityRule
{
    /**
     * This method should implement the violation analysis algorithm of concrete
     * rule implementations. All extending classes must implement this method.
     *
     * @param AbstractNode|ClassNode|ASTClass $node
     */
    public function apply(AbstractNode $node)
    {
        if (false === $this->isEntity($node)) {
            return;
        }
        if (0 !== count($node->getConstants())) {
            $this->addViolation($node);
        }
    }

}
