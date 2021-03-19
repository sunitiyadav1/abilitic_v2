<?php

class __Mustache_a8167375c1bd599fc83df032dca7cead extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $buffer .= $indent . '<div class="search_overlay">
';
        $buffer .= $indent . '  <a id="search-button-listener" class="mk-search-trigger mk-fullscreen-trigger" href="#">
';
        $buffer .= $indent . '    <span id="search-button"><i class="flaticon-magnifying-glass"></i></span>
';
        $buffer .= $indent . '  </a>
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }
}
