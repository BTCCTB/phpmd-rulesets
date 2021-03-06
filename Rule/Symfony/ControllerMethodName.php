<?php

namespace BTC\PHPMD\Rule\Symfony;

use PDepend\Source\AST\ASTClass;
use PHPMD\AbstractNode;
use PHPMD\AbstractRule;
use PHPMD\Node\ClassNode;
use PHPMD\Node\MethodNode;
use PHPMD\Rule\ClassAware;

/**
 * Class ControllerMethodName
 *
 * When the class is concrete and ends with Controller, the method names have to end with Action.
 *
 * @package BTC\PHPMD\Rule\Symfony
 */
class ControllerMethodName extends AbstractRule implements ClassAware
{
    /**
     * This method should implement the violation analysis algorithm of concrete
     * rule implementations. All extending classes must implement this method.
     *
     * @param AbstractNode|ClassNode $node
     */
    public function apply(AbstractNode $node)
    {
        if (false === $this->isController($node)) {
            return;
        }
        $allowedMethodNames = explode($this->getStringProperty('delimiter'), $this->getStringProperty('allowedMethodNames'));

        /** @var MethodNode $method */
        foreach ($node->getMethods() as $method) {
            if (true === in_array($method->getImage(), $allowedMethodNames)) {
                continue;
            }

            if ('Action' !== substr($method->getImage(), -6, 6)) {
                $this->addViolation($method);
            }
        }
    }

    /**
     * Check if this node is a controller
     *
     * @param ClassNode|ASTClass $node
     *
     * @return bool
     */
    private function isController(ClassNode $node)
    {
        if (true === $node->isAbstract()) {
            return false;
        }

        if ('Controller' === substr($node->getImage(), -10, 10)) {
            return true;
        }

        return false;
    }
}
