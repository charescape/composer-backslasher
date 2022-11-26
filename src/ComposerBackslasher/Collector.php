<?php

declare(strict_types=1);

namespace Charescape\ComposerBackslasher;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\NodeVisitorAbstract;

class Collector extends NodeVisitorAbstract
{
    /** @var array */
    public $positions = [];

    /** @var array */
    public $ignored = [];

    /** @var bool */
    private $inNamespace = false;

    public function enterNode(Node $node): void
    {
        if ($node instanceof Node\Stmt\Namespace_) {
            $this->inNamespace = true;
        } elseif (!$this->inNamespace) {
            // ignore
        } elseif ($node instanceof Expr\FuncCall
            && $node->name instanceof Node\Name
            && !$node->name instanceof Node\Name\FullyQualified
            && function_exists((string) $node->name)
            && !isset($this->ignored[(string) $node->name->getAttribute('namespacedName')])
        ) {
            $this->positions[] = $node->name->getAttribute('startFilePos');
        } elseif ($node instanceof Expr\ConstFetch
            && $node->name instanceof Node\Name
            && !$node->name instanceof Node\Name\FullyQualified
            && defined((string) $node->name)
            && !preg_match('~true|false|null~i', (string) $node->name)
            && !isset($this->ignored[(string) $node->name->getAttribute('namespacedName')])
        ) {
            $this->positions[] = $node->name->getAttribute('startFilePos');
        }
    }
}
