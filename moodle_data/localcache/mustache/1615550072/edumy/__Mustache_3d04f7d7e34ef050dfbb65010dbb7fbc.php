<?php

class __Mustache_3d04f7d7e34ef050dfbb65010dbb7fbc extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="heading">
';
        $buffer .= $indent . '  <h3 class="text-center">';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->section17c879cea99d63d48406fad532e3685a($context, $indent, $value);
        $buffer .= '</h3>
';
        // 'signup_is_enabled' section
        $value = $context->find('signup_is_enabled');
        $buffer .= $this->section41fd30193a640870c438834c8f597cd2($context, $indent, $value);
        $buffer .= $indent . '</div>
';
        $value = $this->resolveValue($context->find('ccn_login'), $context);
        $buffer .= $indent . $value;
        $buffer .= '
';

        return $buffer;
    }

    private function section17c879cea99d63d48406fad532e3685a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' login_welcome, theme_edumy ';
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
                
                $buffer .= ' login_welcome, theme_edumy ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB2fc46d0e41978df672c09ed244628e3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' login_no_account, theme_edumy ';
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
                
                $buffer .= ' login_no_account, theme_edumy ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFd97ddb6e9f26cd17a12533e4e47054d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' signup, theme_edumy ';
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
                
                $buffer .= ' signup, theme_edumy ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section41fd30193a640870c438834c8f597cd2(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <p class="text-center">{{#str}} login_no_account, theme_edumy {{/str}} <a class="text-thm" href="{{{ config.wwwroot }}}/login/signup.php">{{#str}} signup, theme_edumy {{/str}}</a></p>
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
                
                $buffer .= $indent . '    <p class="text-center">';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->sectionB2fc46d0e41978df672c09ed244628e3($context, $indent, $value);
                $buffer .= ' <a class="text-thm" href="';
                $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
                $buffer .= $value;
                $buffer .= '/login/signup.php">';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->sectionFd97ddb6e9f26cd17a12533e4e47054d($context, $indent, $value);
                $buffer .= '</a></p>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
