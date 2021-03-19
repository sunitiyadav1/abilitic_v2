<?php

class __Mustache_ce50615e5a551717344c62f432f326db extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class=" view-search" ';
        // 'isdrawer' inverted section
        $value = $context->find('isdrawer');
        if (empty($value)) {
            
            $buffer .= 'data-in-panel="true" ';
        }
        $buffer .= ' aria-hidden="true" data-region="view-search">
';
        $buffer .= $indent . '  <div class="iu_heading">
';
        $buffer .= $indent . '    <div class="candidate_revew_search_box">
';
        $buffer .= $indent . '      <a class="ccn-msg-cog" href="#" data-route-back data-action="cancel-search" role="button">
';
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_icon_back')) {
            $buffer .= $partial->renderInternal($context, $indent . '        ');
        }
        $buffer .= $indent . '      </a>
';
        $buffer .= $indent . '      <div class="form-inline my-2 my-lg-0">
';
        $buffer .= $indent . '        <input type="text" class="form-control mr-sm-2" placeholder="';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->section507b9f28a10a9aed70b7b7a308c6a3ca($context, $indent, $value);
        $buffer .= '" aria-label="';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->section507b9f28a10a9aed70b7b7a308c6a3ca($context, $indent, $value);
        $buffer .= '" data-region="search-input">
';
        $buffer .= $indent . '        <button class="btn my-2 my-sm-0" type="button" data-action="search" aria-label="';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->section507b9f28a10a9aed70b7b7a308c6a3ca($context, $indent, $value);
        $buffer .= '">
';
        $buffer .= $indent . '          <span class="flaticon-magnifying-glass"></span>
';
        $buffer .= $indent . '          <span class="hidden" data-region="loading-icon-container">
';
        if ($partial = $this->mustache->loadPartial('core/loading')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        $buffer .= $indent . '          </span>
';
        $buffer .= $indent . '        </button>
';
        $buffer .= $indent . '      </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '  </div>
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section507b9f28a10a9aed70b7b7a308c6a3ca(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' search, core_search ';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' search, core_search ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
