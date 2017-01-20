<?php


namespace BTC\PHPMD\Rule\Symfony;


use PDepend\Source\AST\ASTMethod;
use PHPMD\AbstractNode;
use PHPMD\Node\ClassNode;
use PHPMD\Node\MethodNode;

/**
 * Class EntitySimpleGetterSetter
 *
 * The entities have to contain only simple getter and setter.
 *
 * @package BTC\PHPMD\Rule\Symfony
 */
class EntitySimpleGetterSetter extends AbstractEntityRule
{
    /**
     * AllowPrefixes
     *
     * @var array
     */
    private $allowedPrefixes;

    /**
     * WhiteList
     *
     * @var array
     */
    private $whitelist;

    /**
     * This method should implement the violation analysis algorithm of concrete
     * rule implementations. All extending classes must implement this method.
     *
     * @param AbstractNode|ClassNode $node
     */
    public function apply(AbstractNode $node)
    {
        if (false === $this->isEntity($node)) {
            return;
        }

        $prefixes = $this->getStringProperty('prefixes');
        $this->allowedPrefixes = explode($this->getStringProperty('delimiter'), $prefixes);
        $this->whitelist = explode($this->getStringProperty('delimiter'), $this->getStringProperty('whitelist'));

        /** @var MethodNode $method */
        foreach ($node->getMethods() as $method) {
            if (true === $this->isMethodNameOnWhitelist($method)) {
                continue;
            }

            if (true === $this->hasCorrectPrefix($method) && true === $this->isSimpleMethod($method)) {
                continue;
            }

            $this->addViolation($method, [$prefixes]);
        }
    }

    /**
     * Check method name on white list
     *
     * @param MethodNode $method
     *
     * @return bool
     */
    private function isMethodNameOnWhitelist(MethodNode $method)
    {
        return in_array($method->getImage(), $this->whitelist);
    }

    /**
     * Check method prefix
     *
     * @param MethodNode|ASTMethod $node
     *
     * @return bool
     */
    private function hasCorrectPrefix(MethodNode $node)
    {
        foreach ($this->allowedPrefixes as $prefix) {
            if ($prefix === substr($node->getImage(), 0, strlen($prefix))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check method complexity
     *
     * @param MethodNode|ASTMethod $node
     *
     * @return bool
     */
    private function isSimpleMethod(MethodNode $node)
    {
        $countScope = count($node->findChildrenOfType('ScopeStatement'));

        if (0 !== $countScope) {
            return false;
        }

        $countReturn = count($node->findChildrenOfType('ReturnStatement'));
        $countThis = $this->countThis($node);

        if (1 < $countReturn) {
            return false;
        }

        if (($countReturn + 1) < $countThis) {
            return false;
        }

        return true;
    }

    /**
     * Count $this in this method
     *
     * @param MethodNode $node
     *
     * @return int
     */
    private function countThis(MethodNode $node)
    {
        $count = 0;
        $variables = $node->findChildrenOfType('Variable');

        foreach ($variables as $variable) {
            if ($variable->getImage() === '$this') {
                $count++;
            }
        }

        return $count;
    }
}
