<?php

class __Mustache_2e700ac8c526d70a877733a7e2181cf8 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<ol class="breadcrumb">
';
        // 'get_items' section
        $value = $context->find('get_items');
        $buffer .= $this->section5266ce947ed75455af92472c929eefb4($context, $indent, $value);
        // 'get_items' inverted section
        $value = $context->find('get_items');
        if (empty($value)) {
            
            $buffer .= $indent . '    <li class="breadcrumb-item">
';
            $buffer .= $indent . '      <a href="';
            $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
            $buffer .= $value;
            $buffer .= '">Home</a>
';
            $buffer .= $indent . '    </li>
';
        }
        $buffer .= $indent . '</ol>
';

        return $buffer;
    }

    private function sectionE42e43b92f3f87d75dfcb5163f98588f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' ccn-inactive';
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
                
                $buffer .= ' ccn-inactive';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section62d5a132907205fc688d69dfdb91b5f9(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'aria-current="page" ';
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
                
                $buffer .= 'aria-current="page" ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8d18ca5e1e0c946c7922a8734bcaa09d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'title="{{get_title}}" ';
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
                
                $buffer .= 'title="';
                $value = $this->resolveValue($context->find('get_title'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '" ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionDd79510ca090cdd5717bdf3b5c3dce5f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
      <li class="breadcrumb-item{{#is_hidden}} ccn-inactive{{/is_hidden}}">
        <a href="{{{action}}}" {{#is_last}}aria-current="page" {{/is_last}} {{#get_title}}title="{{get_title}}" {{/get_title}}>{{{get_content}}}</a>
      </li>
    ';
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
                
                $buffer .= $indent . '      <li class="breadcrumb-item';
                // 'is_hidden' section
                $value = $context->find('is_hidden');
                $buffer .= $this->sectionE42e43b92f3f87d75dfcb5163f98588f($context, $indent, $value);
                $buffer .= '">
';
                $buffer .= $indent . '        <a href="';
                $value = $this->resolveValue($context->find('action'), $context);
                $buffer .= $value;
                $buffer .= '" ';
                // 'is_last' section
                $value = $context->find('is_last');
                $buffer .= $this->section62d5a132907205fc688d69dfdb91b5f9($context, $indent, $value);
                $buffer .= ' ';
                // 'get_title' section
                $value = $context->find('get_title');
                $buffer .= $this->section8d18ca5e1e0c946c7922a8734bcaa09d($context, $indent, $value);
                $buffer .= '>';
                $value = $this->resolveValue($context->find('get_content'), $context);
                $buffer .= $value;
                $buffer .= '</a>
';
                $buffer .= $indent . '      </li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5266ce947ed75455af92472c929eefb4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{#has_action}}
      <li class="breadcrumb-item{{#is_hidden}} ccn-inactive{{/is_hidden}}">
        <a href="{{{action}}}" {{#is_last}}aria-current="page" {{/is_last}} {{#get_title}}title="{{get_title}}" {{/get_title}}>{{{get_content}}}</a>
      </li>
    {{/has_action}}
    {{^has_action}}
      <li class="breadcrumb-item active {{#is_hidden}} ccn-inactive{{/is_hidden}}">{{{text}}}</li>
    {{/has_action}}
  ';
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
                
                // 'has_action' section
                $value = $context->find('has_action');
                $buffer .= $this->sectionDd79510ca090cdd5717bdf3b5c3dce5f($context, $indent, $value);
                // 'has_action' inverted section
                $value = $context->find('has_action');
                if (empty($value)) {
                    
                    $buffer .= $indent . '      <li class="breadcrumb-item active ';
                    // 'is_hidden' section
                    $value = $context->find('is_hidden');
                    $buffer .= $this->sectionE42e43b92f3f87d75dfcb5163f98588f($context, $indent, $value);
                    $buffer .= '">';
                    $value = $this->resolveValue($context->find('text'), $context);
                    $buffer .= $value;
                    $buffer .= '</li>
';
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
