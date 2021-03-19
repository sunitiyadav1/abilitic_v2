<?php

class __Mustache_860d9bb25dd3602c9692904299fad85a extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '  <div class="form-inline">
';
        $buffer .= $indent . '    <textarea dir="auto" data-region="send-message-txt" class="form-control" rows="3" data-auto-rows data-min-rows="3" data-max-rows="5" role="textbox" aria-label="';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->section2244054c2b8c2f0af84a759e802290d0($context, $indent, $value);
        $buffer .= '"
';
        $buffer .= $indent . '      placeholder="';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->section2244054c2b8c2f0af84a759e802290d0($context, $indent, $value);
        $buffer .= '" style="resize: none"></textarea>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '    <button class="btn" aria-label="';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->sectionAb824786c8682f6171ef8d2596f84a5d($context, $indent, $value);
        $buffer .= '" data-action="send-message">
';
        $buffer .= $indent . '      <span data-region="send-icon-container"><span class="flaticon-paper-plane"></span></span>
';
        $buffer .= $indent . '      <span class="hidden" data-region="loading-icon-container">';
        if ($partial = $this->mustache->loadPartial('core/loading')) {
            $buffer .= $partial->renderInternal($context);
        }
        $buffer .= '</span>
';
        $buffer .= $indent . '    </button>
';
        $buffer .= $indent . '  </div>
';

        return $buffer;
    }

    private function section2244054c2b8c2f0af84a759e802290d0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' writeamessage, core_message ';
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
                
                $buffer .= ' writeamessage, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionAb824786c8682f6171ef8d2596f84a5d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' sendmessage, core_message ';
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
                
                $buffer .= ' sendmessage, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
