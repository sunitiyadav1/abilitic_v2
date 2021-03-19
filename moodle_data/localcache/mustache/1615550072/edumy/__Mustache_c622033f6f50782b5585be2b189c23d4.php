<?php

class __Mustache_c622033f6f50782b5585be2b189c23d4 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        // 'isloggedin' section
        $value = $context->find('isloggedin');
        $buffer .= $this->section5be9afe434fc7bf2b4b7f1a267ebc804($context, $indent, $value);
        // 'notloggedin' section
        $value = $context->find('notloggedin');
        $buffer .= $this->sectionF314283c15877f781c2f22a01639987f($context, $indent, $value);

        return $buffer;
    }

    private function sectionDa605edbc853c08f5b28ff61f0be8df3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'navigation, theme_edumy';
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
                
                $buffer .= 'navigation, theme_edumy';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5be9afe434fc7bf2b4b7f1a267ebc804(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li>
    <a href="#">{{#str}}navigation, theme_edumy{{/str}}</a>
    <ul>{{> theme_boost/flat_navigation }}</ul>
  </li>
  <li>
    <a href="#">{{{ user_username }}} <img class="rounded-circle" src="{{{ user_profile_picture }}}" alt="{{{ user_username }}}"></a>
    <ul>{{{ output.user_menu }}}</ul>
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
                
                $buffer .= $indent . '  <li>
';
                $buffer .= $indent . '    <a href="#">';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->sectionDa605edbc853c08f5b28ff61f0be8df3($context, $indent, $value);
                $buffer .= '</a>
';
                $buffer .= $indent . '    <ul>';
                if ($partial = $this->mustache->loadPartial('theme_boost/flat_navigation')) {
                    $buffer .= $partial->renderInternal($context);
                }
                $buffer .= '</ul>
';
                $buffer .= $indent . '  </li>
';
                $buffer .= $indent . '  <li>
';
                $buffer .= $indent . '    <a href="#">';
                $value = $this->resolveValue($context->find('user_username'), $context);
                $buffer .= $value;
                $buffer .= ' <img class="rounded-circle" src="';
                $value = $this->resolveValue($context->find('user_profile_picture'), $context);
                $buffer .= $value;
                $buffer .= '" alt="';
                $value = $this->resolveValue($context->find('user_username'), $context);
                $buffer .= $value;
                $buffer .= '"></a>
';
                $buffer .= $indent . '    <ul>';
                $value = $this->resolveValue($context->findDot('output.user_menu'), $context);
                $buffer .= $value;
                $buffer .= '</ul>
';
                $buffer .= $indent . '  </li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionCbb4560469c0093048983420c21ea716(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'login, theme_edumy';
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
                
                $buffer .= 'login, theme_edumy';
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

    private function sectionF1ff04743baccd373d9636be7f59837b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
   <li><a href="{{{ ccnLogoUrl }}}/login/signup.php"><span class="ccn-flaticon-login"></span> {{#str}} signup, theme_edumy {{/str}}</a></li>
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
                
                $buffer .= $indent . '   <li><a href="';
                $value = $this->resolveValue($context->find('ccnLogoUrl'), $context);
                $buffer .= $value;
                $buffer .= '/login/signup.php"><span class="ccn-flaticon-login"></span> ';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->sectionFd97ddb6e9f26cd17a12533e4e47054d($context, $indent, $value);
                $buffer .= '</a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF314283c15877f781c2f22a01639987f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li><a href="{{{ ccnLogoUrl }}}/login/index.php"><span class="ccn-flaticon-user"></span> {{#str}}login, theme_edumy{{/str}}</a></li>
  {{#signup_is_enabled}}
   <li><a href="{{{ ccnLogoUrl }}}/login/signup.php"><span class="ccn-flaticon-login"></span> {{#str}} signup, theme_edumy {{/str}}</a></li>
  {{/signup_is_enabled}}
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
                
                $buffer .= $indent . '  <li><a href="';
                $value = $this->resolveValue($context->find('ccnLogoUrl'), $context);
                $buffer .= $value;
                $buffer .= '/login/index.php"><span class="ccn-flaticon-user"></span> ';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->sectionCbb4560469c0093048983420c21ea716($context, $indent, $value);
                $buffer .= '</a></li>
';
                // 'signup_is_enabled' section
                $value = $context->find('signup_is_enabled');
                $buffer .= $this->sectionF1ff04743baccd373d9636be7f59837b($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
