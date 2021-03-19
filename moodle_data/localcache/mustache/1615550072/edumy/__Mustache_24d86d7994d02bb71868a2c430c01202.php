<?php

class __Mustache_24d86d7994d02bb71868a2c430c01202 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        // 'preloader_disable' inverted section
        $value = $context->find('preloader_disable');
        if (empty($value)) {
            
            $buffer .= $indent . '  <div class="preloader
';
            $buffer .= $indent . '    ';
            // 'preloader_load' section
            $value = $context->find('preloader_load');
            $buffer .= $this->section249b2725dbe6007f74b327822c1d25a3($context, $indent, $value);
            $buffer .= '
';
            $buffer .= $indent . '    ';
            // 'preloader_ready' section
            $value = $context->find('preloader_ready');
            $buffer .= $this->section7172bd803d9e48d2175e7d8f33f9d0f7($context, $indent, $value);
            $buffer .= '
';
            $buffer .= $indent . '    ';
            // 'preloader_5' section
            $value = $context->find('preloader_5');
            $buffer .= $this->section69fcdcd00c982787c477f5b213a98551($context, $indent, $value);
            $buffer .= '
';
            $buffer .= $indent . '    ';
            // 'preloader_4' section
            $value = $context->find('preloader_4');
            $buffer .= $this->section01e8e415812b1ac1b5a90ccbb269c8d4($context, $indent, $value);
            $buffer .= '
';
            $buffer .= $indent . '    ';
            // 'preloader_3' section
            $value = $context->find('preloader_3');
            $buffer .= $this->section283c46046c8836c84f7ee7aab50f3248($context, $indent, $value);
            $buffer .= '
';
            $buffer .= $indent . '    ';
            // 'preloader_2' section
            $value = $context->find('preloader_2');
            $buffer .= $this->section752dca96d02b20900522d3cfbbe0e3b1($context, $indent, $value);
            $buffer .= '
';
            $buffer .= $indent . '  "></div>
';
        }

        return $buffer;
    }

    private function section249b2725dbe6007f74b327822c1d25a3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' ccn_preloader_load ';
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
                
                $buffer .= ' ccn_preloader_load ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section7172bd803d9e48d2175e7d8f33f9d0f7(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' ccn_preloader_ready ';
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
                
                $buffer .= ' ccn_preloader_ready ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section69fcdcd00c982787c477f5b213a98551(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' ccn_preloader_5 ';
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
                
                $buffer .= ' ccn_preloader_5 ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section01e8e415812b1ac1b5a90ccbb269c8d4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' ccn_preloader_4 ';
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
                
                $buffer .= ' ccn_preloader_4 ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section283c46046c8836c84f7ee7aab50f3248(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' ccn_preloader_3 ';
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
                
                $buffer .= ' ccn_preloader_3 ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section752dca96d02b20900522d3cfbbe0e3b1(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' ccn_preloader_2 ';
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
                
                $buffer .= ' ccn_preloader_2 ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
