<?php

class __Mustache_6808b185fc80985b45ec9b88090b88bb extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        // 'notloggedin' section
        $value = $context->find('notloggedin');
        $buffer .= $this->section8e3a579e3b6288806c9cfde9c9bd32d9($context, $indent, $value);

        return $buffer;
    }

    private function sectionC7b6709ae6ebdb57564a95078a1496f9(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'login_register, theme_edumy';
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
                
                $buffer .= 'login_register, theme_edumy';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFbeaa45e2a5e2dc1a9ce4a63dec33283(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <a href="#" class="btn flaticon-user" data-toggle="modal" data-target="#exampleModalCenter"> <span class="dn-lg">{{#str}}login_register, theme_edumy{{/str}}</span></a>
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
                
                $buffer .= $indent . '    <a href="#" class="btn flaticon-user" data-toggle="modal" data-target="#exampleModalCenter"> <span class="dn-lg">';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->sectionC7b6709ae6ebdb57564a95078a1496f9($context, $indent, $value);
                $buffer .= '</span></a>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section2583d269b387396477edc113675dcbfa(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <a href="{{{ config.wwwroot }}}/login" class="btn flaticon-user"> <span class="dn-lg">{{#str}}login_register, theme_edumy{{/str}}</span></a>
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
                
                $buffer .= $indent . '    <a href="';
                $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
                $buffer .= $value;
                $buffer .= '/login" class="btn flaticon-user"> <span class="dn-lg">';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->sectionC7b6709ae6ebdb57564a95078a1496f9($context, $indent, $value);
                $buffer .= '</span></a>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8e3a579e3b6288806c9cfde9c9bd32d9(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item list_s">
    {{#header_login_popup}}
    <a href="#" class="btn flaticon-user" data-toggle="modal" data-target="#exampleModalCenter"> <span class="dn-lg">{{#str}}login_register, theme_edumy{{/str}}</span></a>
    {{/header_login_popup}}
    {{#header_login_link}}
    <a href="{{{ config.wwwroot }}}/login" class="btn flaticon-user"> <span class="dn-lg">{{#str}}login_register, theme_edumy{{/str}}</span></a>
    {{/header_login_link}}
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
                
                $buffer .= $indent . '  <li class="list-inline-item list_s">
';
                // 'header_login_popup' section
                $value = $context->find('header_login_popup');
                $buffer .= $this->sectionFbeaa45e2a5e2dc1a9ce4a63dec33283($context, $indent, $value);
                // 'header_login_link' section
                $value = $context->find('header_login_link');
                $buffer .= $this->section2583d269b387396477edc113675dcbfa($context, $indent, $value);
                $buffer .= $indent . '  </li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
