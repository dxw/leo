<?php

namespace Peridot\Leo\Responder;

use Peridot\Leo\Matcher\LeoMatch;
use Peridot\Leo\Matcher\Template\TemplateInterface;

/**
 * The ResponderInterface is responsible for responding
 * to match results.
 *
 * @package Peridot\Leo\Responder
 */
interface ResponderInterface
{
    /**
     * Respond to a Match given a TemplateInterface to format the message.
     *
     * @param  LeoMatch             $match
     * @param  TemplateInterface $template
     * @param  string            $message  a user provided messaged
     * @return mixed
     */
    public function respond(LeoMatch $match, TemplateInterface $template, $message);
}
