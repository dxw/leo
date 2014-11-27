<?php
namespace Peridot\Leo\Interfaces;

use Peridot\Leo\Behavior\Bdd\EmptyBehavior;
use Peridot\Leo\Behavior\Bdd\EqualBehavior;
use Peridot\Leo\Behavior\Bdd\FalseBehavior;
use Peridot\Leo\Behavior\Bdd\NullBehavior;
use Peridot\Leo\Behavior\Bdd\TrueBehavior;
use Peridot\Leo\Behavior\Bdd\InclusionBehavior;
use Peridot\Leo\Behavior\Bdd\OkBehavior;
use Peridot\Leo\Behavior\Bdd\TypeBehavior;
use Peridot\Leo\Flag\NotFlag;
use Peridot\Leo\Formatter\ObjectFormatter;
use Peridot\Leo\Matcher\EmptyMatcher;
use Peridot\Leo\Matcher\EqualMatcher;
use Peridot\Leo\Matcher\FalseMatcher;
use Peridot\Leo\Matcher\InclusionMatcher;
use Peridot\Leo\Matcher\NullMatcher;
use Peridot\Leo\Matcher\OkMatcher;
use Peridot\Leo\Matcher\TrueMatcher;
use Peridot\Leo\Matcher\TypeMatcher;

/**
 * The BDD interface contains a chainable interface that enhances
 * the readability of expectations.
 *
 * @package Peridot\Leo
 *
 * @property Bdd $to
 * @property Bdd $be
 * @property Bdd $been
 * @property Bdd $is
 * @property Bdd $that
 * @property Bdd $and
 * @property Bdd $has
 * @property Bdd $have
 * @property Bdd $with
 * @property Bdd $at
 * @property Bdd $of
 * @property Bdd $same
 * @property Bdd $not
 * @property Bdd $negated
 * @property Bdd $a
 * @property Bdd $an
 *
 * @method void an() an(string $type, string $message = "") validates the type of a subject
 * @method void a() a(string $type, string $message = "") validates the type of a subject
 * @method void include() include(mixed $needle, string $message = "") validates that a subject contains the needle
 * @method void contain() contain(mixed $needle, string $message = "") validates that a subject contains the needle
 * @method void ok() ok(string $message = "") validates that a subject is truthy
 * @method void true() true(string $message = "") validates that a subject is true
 * @method void false() false(string $message = "") validates that a subject is false
 * @method void null() null(string $message = "") validates that a subject is null
 * @method void empty() empty(string $message = "") validates that a subject is empty
 * @method void equal() equal(mixed $subject, string $message = "") validates that a subject is the same as a value
 */
class Bdd extends AbstractBaseInterface
{
    /**
     * Specifies the chainable interface for assertions
     *
     * @var array
     */
    protected $chainables = [
        'to',
        'be',
        'been',
        'is',
        'that',
        'and',
        'has',
        'have',
        'with',
        'at',
        'of',
        'same'
    ];

    /**
     * Initialize BDD interface with chainable properties
     */
    public function __construct($subject)
    {
        parent::__construct($subject);

        foreach ($this->chainables as $property) {
            $this->$property = $this;
        }

        $formatter = new ObjectFormatter();

        $this->setFlag(new NotFlag());
        $this->addBehavior(new TypeBehavior(new TypeMatcher($formatter), $this));
        $this->addBehavior(new InclusionBehavior(new InclusionMatcher($formatter), $this));
        $this->addBehavior(new OkBehavior(new OkMatcher($formatter), $this));
        $this->addBehavior(new TrueBehavior(new TrueMatcher($formatter), $this));
        $this->addBehavior(new FalseBehavior(new FalseMatcher($formatter), $this));
        $this->addBehavior(new NullBehavior(new NullMatcher($formatter), $this));
        $this->addBehavior(new EmptyBehavior(new EmptyMatcher($formatter), $this));
        $this->addBehavior(new EqualBehavior(new EqualMatcher($formatter), $this));
    }

    /**
     * __call is defined to cover reserved word cases for various assertions, such as
     * include and empty.
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {

        if ($name == "include") {
            return call_user_func_array([$this, 'contain'], $arguments);
        }

        if ($name == "empty") {
            return call_user_func_array([$this, 'emtee'], $arguments);
        }

        return parent::__call($name, $arguments);
    }
}
