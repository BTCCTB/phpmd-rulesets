<?php

namespace BTC\PHPMD\Rule\Symfony;

use PDepend\Source\AST\ASTClass;
use PHPMD\AbstractRule;
use PHPMD\Node\ClassNode;
use PHPMD\Rule\ClassAware;

/**
 * Class AbstractEntityRule
 *
 * @package BTC\PHPMD\Rule\Symfony
 */
abstract class AbstractEntityRule extends AbstractRule implements ClassAware
{
    /**
     * Check if this node is a entity
     *
     * @param ClassNode|ASTClass $node
     *
     * @return bool
     */
    protected function isEntity(ClassNode $node)
    {
        $comment = $node->getComment();

        if (0 < preg_match($this->getStringProperty('classIsEntityRegex'), $comment)) {
            return true;
        }

        if (true === $node->isAbstract()) {
            return false;
        }

        if (0 < preg_match($this->getStringProperty('entityRegex'), $comment)) {
            return true;
        }

        return false;
    }
}
