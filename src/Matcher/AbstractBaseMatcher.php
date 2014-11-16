<?php
namespace Peridot\Leo\Matcher;

use Peridot\Leo\Interfaces\AbstractBaseInterface;
use Peridot\Scope\Scope;

abstract class AbstractBaseMatcher extends Scope implements MatcherInterface
{
    /**
     * {@inheritdoc}
     *
     * @param mixed $expected
     * @return bool
     */
    public function isMatch($expected, $actual)
    {
        return $expected === $actual;
    }

    /**
     * Return the subject of the assertion.
     *
     * @return AbstractBaseInterface
     */
    public function getInterface()
    {
        return $this->peridotGetParentScope();
    }

    /**
     * Validate the match and throw an exception if validation
     * fails.
     *
     * @param $type
     * @param $actual
     * @throws \Exception
     */
    public function validate($expected, $actual)
    {
        if ($this->isMatch($expected, $actual)) {
            return;
        }
        throw new \Exception($this->getMessage($expected, $actual));
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed $expected
     * @param mixed $actual
     * @return string
     */
    public function getMessage($expected, $actual)
    {
        return "Expected $expected, got $actual";
    }
}