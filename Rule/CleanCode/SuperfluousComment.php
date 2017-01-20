<?php

namespace BTC\PHPMD\Rule\CleanCode;
use PDepend\Source\AST\AbstractASTArtifact;
use PDepend\Source\AST\ASTClass;
use PHPMD\AbstractNode;
use PHPMD\AbstractRule;
use PHPMD\Node\ClassNode;
use PHPMD\Rule\ClassAware;

/**
 * Class SuperfluousComment
 *
 * Don't write superfluous comments. It's adding by subtracting.
 *
 * @package BTC\PHPMD\Rule\CleanCode
 */
class SuperfluousComment extends AbstractRule implements ClassAware
{
    /**
     * Percent
     *
     * @var int
     */
    private $percent;

    /**
     * This method should implement the violation analysis algorithm of concrete
     * rule implementations. All extending classes must implement this method.
     *
     * @param AbstractNode $node
     */
    public function apply(AbstractNode $node)
    {
        $this->percent = $this->getIntProperty('percent');
        if (true === $this->getBooleanProperty('checkClass')) {
            $this->checkClass($node);
        }
        if (true === $this->getBooleanProperty('checkProperties')) {
            $this->checkProperties($node);
        }
        if (true === $this->getBooleanProperty('checkMethods')) {
            $this->checkMethods($node);
        }
    }

    /**
     * Check class
     *
     * @param AbstractNode $node
     */
    private function checkClass(AbstractNode $node)
    {
        $this->checkNode(
            $node,
            $node->getType(),
            $this->calculateNameToCommentSimilarityInPercent($node)
        );
    }

    /**
     * Check properties
     *
     * @param AbstractNode|ASTClass $node
     */
    private function checkProperties(AbstractNode $node)
    {
        foreach ($node->getProperties() as $property) {
            $this->checkNode(
                $node,
                'property ' . $property->getName(),
                $this->calculateNameToCommentSimilarityInPercent($property)
            );
        }
    }

    /**
     * Check methods
     *
     * @param AbstractNode|ClassNode $node
     */
    private function checkMethods(AbstractNode $node)
    {
        foreach ($node->getMethods() as $method) {
            $this->checkNode(
                $method,
                $method->getType(),
                $this->calculateNameToCommentSimilarityInPercent($method)
            );
        }
    }

    /**
     * Check node
     *
     * @param AbstractNode $node
     * @param string       $type
     * @param int          $percent
     */
    private function checkNode(AbstractNode $node, $type, $percent)
    {
        if ($this->percent < $percent) {
            $this->addViolation($node, [$type, $percent]);
        }
    }

    /**
     * Calculate name to comment similarity in percent
     *
     * @param AbstractNode|AbstractASTArtifact $node
     *
     * @return float
     */
    private function calculateNameToCommentSimilarityInPercent($node)
    {
        $comment = $node->getComment();

        if (empty($comment)) {
            return 0;
        }

        similar_text(
            $this->transformString($node->getName()),
            $this->getCommentDescription($comment),
            $percent
        );

        return round($percent);
    }

    /**
     * Get comment description
     *
     * @param string $comment
     *
     * @return string
     */
    private function getCommentDescription($comment)
    {
        $lines = explode(PHP_EOL, $comment);
        $descriptionLines = [];

        foreach ($lines as $line) {
            if (false === strpos($line, '@')) {
                $descriptionLines[] = $line;
            }
        }

        return $this->transformDescriptionLines($descriptionLines);
    }

    /**
     * Transform description lines
     *
     * @param array $descriptionLines
     *
     * @return string
     */
    private function transformDescriptionLines(array $descriptionLines)
    {
        $description = '';

        foreach ($descriptionLines as $line) {
            $description .= $this->transformString($line);
        }

        return $description;
    }

    /**
     * Transform string
     *
     * @param string $string
     *
     * @return string
     */
    private function transformString($string)
    {
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9]/', '', $string);

        return $string;
    }
}
