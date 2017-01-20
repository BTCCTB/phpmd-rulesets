<?php

namespace BTC\PHPMD\Rule\CleanCode;

use PHPMD\AbstractNode;
use PHPMD\AbstractRule;
use PHPMD\Node\ClassNode;
use PHPMD\Node\MethodNode;
use PHPMD\Rule\MethodAware;

/**
 * Class MethodOneTryCatch
 *
 * Methods should only have one try statement. If not, swap out the try statement in an extra method. It increase the readability.
 *
 * @package BTC\PHPMD\Rule\CleanCode
 */
class MethodOneTryCatch extends AbstractRule implements MethodAware
{
    /**
     * This method should implement the violation analysis algorithm of concrete
     * rule implementations. All extending classes must implement this method.
     *
     * @param AbstractNode|ClassNode $node
     */
    public function apply(AbstractNode $node)
    {
        $countTry = count($node->findChildrenOfType('TryStatement'));

        if (1 < $countTry) {
            $this->addViolation($node);
        }

        if (1 === $countTry &&  true === $this->hasNotAllowedChildren($node)) {
            $this->addViolation($node);
        }
    }

    /**
     * Check if this method has not allowed children
     *
     * @param MethodNode $node
     *
     * @return bool
     */
    private function hasNotAllowedChildren(MethodNode $node)
    {
        $children = $node->findChildrenOfType('ScopeStatement');
        $allowedChildren = explode(
            $this->getStringProperty('delimiter'),
            $this->getStringProperty('allowedChildren')
        );

        /** @var AbstractNode $child */
        foreach ($children as $child) {
            if (true === in_array($child->getImage(), $allowedChildren) || true === $this->isChildOfTry($child)) {
                continue;
            }

            return true;
        }

        return false;
    }

    /**
     * Check if is child of try
     *
     * @param AbstractNode $node
     *
     * @return bool
     */
    private function isChildOfTry(AbstractNode $node)
    {
        $parent = $node->getParent();
        while (is_object($parent)) {
            if ($parent->isInstanceOf('TryStatement')) {
                return true;
            }

            $parent = $parent->getParent();
        }

        return false;
    }
}
