<?php

class __Mustache_fe90a23eba49b9b88e384d34b893affb extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        // 'headertype_frontpage_only' section
        $value = $context->find('headertype_frontpage_only');
        $buffer .= $this->section5e0005fcff643c52c0cd8080d84116b0($context, $indent, $value);
        // 'headertype_all_pages' section
        $value = $context->find('headertype_all_pages');
        $buffer .= $this->section74da307ce0f4c14f4e1c376afcb28ade($context, $indent, $value);

        return $buffer;
    }

    private function section1749e74e4e4894c12054e935b33c0330(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
      {{> theme_edumy/ccn_header_1 }}
      {{> theme_edumy/ccn_header_mob_1 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_1')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_1')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section95db795894ca6a84940103adffeeb1ff(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
      {{> theme_edumy/ccn_header_2 }}
      {{> theme_edumy/ccn_header_mob_2 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_2')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_2')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section926bd58ad6f3f864a4d88fefbb558846(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
      {{> theme_edumy/ccn_header_3 }}
      {{> theme_edumy/ccn_header_mob_3 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_3')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_3')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section0701ddf9e18a312760cdb51a7fd56b45(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
      {{> theme_edumy/ccn_header_4 }}
      {{> theme_edumy/ccn_header_mob_4 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_4')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_4')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8f1c9a1e6fd07accc76065110700c892(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
      {{> theme_edumy/ccn_header_5 }}
      {{> theme_edumy/ccn_header_mob_5 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_5')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_5')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section45eed7f41439ec9af90ccdc7442c92a0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
      {{> theme_edumy/ccn_header_6 }}
      {{> theme_edumy/ccn_header_mob_6 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_6')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_6')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section850bcd0691fee3df1d9e749ac672fd66(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
      {{> theme_edumy/ccn_header_7 }}
      {{> theme_edumy/ccn_header_mob_7 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_7')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_7')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section4a992b02cf24132cffd8bf9007167151(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
      {{> theme_edumy/ccn_header_8 }}
      {{> theme_edumy/ccn_header_mob_8 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_8')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_8')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD01583b7668cdc2c7681a7f44277ee98(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
      {{> theme_edumy/ccn_header_9 }}
      {{> theme_edumy/ccn_header_mob_9 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_9')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_9')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section24f292825d224d790cfefb720053ab85(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
      {{> theme_edumy/ccn_header_10 }}
      {{> theme_edumy/ccn_header_mob_10 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_10')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_10')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC69e7171792ea2cc54cfb5c7f5b84f0d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
      {{> theme_edumy/ccn_header_11 }}
      {{> theme_edumy/ccn_header_mob_11 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_11')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_11')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section4eb79cd8b1f2bacecee1b2ab953cebb1(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
      {{> theme_edumy/ccn_header_12 }}
      {{> theme_edumy/ccn_header_mob_12 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_12')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_12')) {
                    $buffer .= $partial->renderInternal($context, $indent . '      ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE80308a52de0cfaaac406da90fc5dea3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{#header_1}}
      {{> theme_edumy/ccn_header_1 }}
      {{> theme_edumy/ccn_header_mob_1 }}
    {{/header_1}}
    {{#header_2}}
      {{> theme_edumy/ccn_header_2 }}
      {{> theme_edumy/ccn_header_mob_2 }}
    {{/header_2}}
    {{#header_3}}
      {{> theme_edumy/ccn_header_3 }}
      {{> theme_edumy/ccn_header_mob_3 }}
    {{/header_3}}
    {{#header_4}}
      {{> theme_edumy/ccn_header_4 }}
      {{> theme_edumy/ccn_header_mob_4 }}
    {{/header_4}}
    {{#header_5}}
      {{> theme_edumy/ccn_header_5 }}
      {{> theme_edumy/ccn_header_mob_5 }}
    {{/header_5}}
    {{#header_6}}
      {{> theme_edumy/ccn_header_6 }}
      {{> theme_edumy/ccn_header_mob_6 }}
    {{/header_6}}
    {{#header_7}}
      {{> theme_edumy/ccn_header_7 }}
      {{> theme_edumy/ccn_header_mob_7 }}
    {{/header_7}}
    {{#header_8}}
      {{> theme_edumy/ccn_header_8 }}
      {{> theme_edumy/ccn_header_mob_8 }}
    {{/header_8}}
    {{#header_9}}
      {{> theme_edumy/ccn_header_9 }}
      {{> theme_edumy/ccn_header_mob_9 }}
    {{/header_9}}
    {{#header_10}}
      {{> theme_edumy/ccn_header_10 }}
      {{> theme_edumy/ccn_header_mob_10 }}
    {{/header_10}}
    {{#header_11}}
      {{> theme_edumy/ccn_header_11 }}
      {{> theme_edumy/ccn_header_mob_11 }}
    {{/header_11}}
    {{#header_12}}
      {{> theme_edumy/ccn_header_12 }}
      {{> theme_edumy/ccn_header_mob_12 }}
    {{/header_12}}
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
                
                // 'header_1' section
                $value = $context->find('header_1');
                $buffer .= $this->section1749e74e4e4894c12054e935b33c0330($context, $indent, $value);
                // 'header_2' section
                $value = $context->find('header_2');
                $buffer .= $this->section95db795894ca6a84940103adffeeb1ff($context, $indent, $value);
                // 'header_3' section
                $value = $context->find('header_3');
                $buffer .= $this->section926bd58ad6f3f864a4d88fefbb558846($context, $indent, $value);
                // 'header_4' section
                $value = $context->find('header_4');
                $buffer .= $this->section0701ddf9e18a312760cdb51a7fd56b45($context, $indent, $value);
                // 'header_5' section
                $value = $context->find('header_5');
                $buffer .= $this->section8f1c9a1e6fd07accc76065110700c892($context, $indent, $value);
                // 'header_6' section
                $value = $context->find('header_6');
                $buffer .= $this->section45eed7f41439ec9af90ccdc7442c92a0($context, $indent, $value);
                // 'header_7' section
                $value = $context->find('header_7');
                $buffer .= $this->section850bcd0691fee3df1d9e749ac672fd66($context, $indent, $value);
                // 'header_8' section
                $value = $context->find('header_8');
                $buffer .= $this->section4a992b02cf24132cffd8bf9007167151($context, $indent, $value);
                // 'header_9' section
                $value = $context->find('header_9');
                $buffer .= $this->sectionD01583b7668cdc2c7681a7f44277ee98($context, $indent, $value);
                // 'header_10' section
                $value = $context->find('header_10');
                $buffer .= $this->section24f292825d224d790cfefb720053ab85($context, $indent, $value);
                // 'header_11' section
                $value = $context->find('header_11');
                $buffer .= $this->sectionC69e7171792ea2cc54cfb5c7f5b84f0d($context, $indent, $value);
                // 'header_12' section
                $value = $context->find('header_12');
                $buffer .= $this->section4eb79cd8b1f2bacecee1b2ab953cebb1($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5e0005fcff643c52c0cd8080d84116b0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  {{#is_frontpage}}
    {{#header_1}}
      {{> theme_edumy/ccn_header_1 }}
      {{> theme_edumy/ccn_header_mob_1 }}
    {{/header_1}}
    {{#header_2}}
      {{> theme_edumy/ccn_header_2 }}
      {{> theme_edumy/ccn_header_mob_2 }}
    {{/header_2}}
    {{#header_3}}
      {{> theme_edumy/ccn_header_3 }}
      {{> theme_edumy/ccn_header_mob_3 }}
    {{/header_3}}
    {{#header_4}}
      {{> theme_edumy/ccn_header_4 }}
      {{> theme_edumy/ccn_header_mob_4 }}
    {{/header_4}}
    {{#header_5}}
      {{> theme_edumy/ccn_header_5 }}
      {{> theme_edumy/ccn_header_mob_5 }}
    {{/header_5}}
    {{#header_6}}
      {{> theme_edumy/ccn_header_6 }}
      {{> theme_edumy/ccn_header_mob_6 }}
    {{/header_6}}
    {{#header_7}}
      {{> theme_edumy/ccn_header_7 }}
      {{> theme_edumy/ccn_header_mob_7 }}
    {{/header_7}}
    {{#header_8}}
      {{> theme_edumy/ccn_header_8 }}
      {{> theme_edumy/ccn_header_mob_8 }}
    {{/header_8}}
    {{#header_9}}
      {{> theme_edumy/ccn_header_9 }}
      {{> theme_edumy/ccn_header_mob_9 }}
    {{/header_9}}
    {{#header_10}}
      {{> theme_edumy/ccn_header_10 }}
      {{> theme_edumy/ccn_header_mob_10 }}
    {{/header_10}}
    {{#header_11}}
      {{> theme_edumy/ccn_header_11 }}
      {{> theme_edumy/ccn_header_mob_11 }}
    {{/header_11}}
    {{#header_12}}
      {{> theme_edumy/ccn_header_12 }}
      {{> theme_edumy/ccn_header_mob_12 }}
    {{/header_12}}
  {{/is_frontpage}}
  {{^is_frontpage}}
    {{> theme_edumy/ccn_header_1 }}
    {{> theme_edumy/ccn_header_mob_1 }}
  {{/is_frontpage}}
  {{> theme_edumy/ccn_modals }}
  {{> theme_edumy/ccn_breadcrumb }}
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
                
                // 'is_frontpage' section
                $value = $context->find('is_frontpage');
                $buffer .= $this->sectionE80308a52de0cfaaac406da90fc5dea3($context, $indent, $value);
                // 'is_frontpage' inverted section
                $value = $context->find('is_frontpage');
                if (empty($value)) {
                    
                    if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_1')) {
                        $buffer .= $partial->renderInternal($context, $indent . '    ');
                    }
                    if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_1')) {
                        $buffer .= $partial->renderInternal($context, $indent . '    ');
                    }
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_modals')) {
                    $buffer .= $partial->renderInternal($context, $indent . '  ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_breadcrumb')) {
                    $buffer .= $partial->renderInternal($context, $indent . '  ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section90bbc0eaeea1b89f911df6f612f001ac(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{> theme_edumy/ccn_header_1 }}
    {{> theme_edumy/ccn_header_mob_1 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_1')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_1')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section0b04db77d2b20e7032dd9e5c47844efb(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{> theme_edumy/ccn_header_2 }}
    {{> theme_edumy/ccn_header_mob_2 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_2')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_2')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionAd2e48d8146c29c457ddb1451b94fc1b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{> theme_edumy/ccn_header_3 }}
    {{> theme_edumy/ccn_header_mob_3 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_3')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_3')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section697d95cb6f8e975bf6643fa10b499e1a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{> theme_edumy/ccn_header_4 }}
    {{> theme_edumy/ccn_header_mob_4 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_4')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_4')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section633f7e3739711e9e005695e0b420f1b1(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{> theme_edumy/ccn_header_5 }}
    {{> theme_edumy/ccn_header_mob_5 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_5')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_5')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section3d58fb9fb1d549dfadedb2a88fdae083(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{> theme_edumy/ccn_header_6 }}
    {{> theme_edumy/ccn_header_mob_6 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_6')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_6')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section66ab2b0e02aa9e44c9f7f0eac75733ab(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{> theme_edumy/ccn_header_7 }}
    {{> theme_edumy/ccn_header_mob_7 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_7')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_7')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section30758ff1c243ffdc893399a505cdaf9d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{> theme_edumy/ccn_header_8 }}
    {{> theme_edumy/ccn_header_mob_8 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_8')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_8')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section25df9f81db3e9f06cc8631707dbad440(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{> theme_edumy/ccn_header_9 }}
    {{> theme_edumy/ccn_header_mob_9 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_9')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_9')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionBa448e8e78531ec28e07e57c0ecb8fb4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{> theme_edumy/ccn_header_10 }}
    {{> theme_edumy/ccn_header_mob_10 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_10')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_10')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6c90401367ff96357852c798e4afa68b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{> theme_edumy/ccn_header_11 }}
    {{> theme_edumy/ccn_header_mob_11 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_11')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_11')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD1e5f7cb283e84dae0d436f0f4be0c36(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{> theme_edumy/ccn_header_12 }}
    {{> theme_edumy/ccn_header_mob_12 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_12')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_12')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section74da307ce0f4c14f4e1c376afcb28ade(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  {{#header_1}}
    {{> theme_edumy/ccn_header_1 }}
    {{> theme_edumy/ccn_header_mob_1 }}
  {{/header_1}}
  {{#header_2}}
    {{> theme_edumy/ccn_header_2 }}
    {{> theme_edumy/ccn_header_mob_2 }}
  {{/header_2}}
  {{#header_3}}
    {{> theme_edumy/ccn_header_3 }}
    {{> theme_edumy/ccn_header_mob_3 }}
  {{/header_3}}
  {{#header_4}}
    {{> theme_edumy/ccn_header_4 }}
    {{> theme_edumy/ccn_header_mob_4 }}
  {{/header_4}}
  {{#header_5}}
    {{> theme_edumy/ccn_header_5 }}
    {{> theme_edumy/ccn_header_mob_5 }}
  {{/header_5}}
  {{#header_6}}
    {{> theme_edumy/ccn_header_6 }}
    {{> theme_edumy/ccn_header_mob_6 }}
  {{/header_6}}
  {{#header_7}}
    {{> theme_edumy/ccn_header_7 }}
    {{> theme_edumy/ccn_header_mob_7 }}
  {{/header_7}}
  {{#header_8}}
    {{> theme_edumy/ccn_header_8 }}
    {{> theme_edumy/ccn_header_mob_8 }}
  {{/header_8}}
  {{#header_9}}
    {{> theme_edumy/ccn_header_9 }}
    {{> theme_edumy/ccn_header_mob_9 }}
  {{/header_9}}
  {{#header_10}}
    {{> theme_edumy/ccn_header_10 }}
    {{> theme_edumy/ccn_header_mob_10 }}
  {{/header_10}}
  {{#header_11}}
    {{> theme_edumy/ccn_header_11 }}
    {{> theme_edumy/ccn_header_mob_11 }}
  {{/header_11}}
  {{#header_12}}
    {{> theme_edumy/ccn_header_12 }}
    {{> theme_edumy/ccn_header_mob_12 }}
  {{/header_12}}
  {{> theme_edumy/ccn_modals }}
  {{> theme_edumy/ccn_breadcrumb }}
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
                
                // 'header_1' section
                $value = $context->find('header_1');
                $buffer .= $this->section90bbc0eaeea1b89f911df6f612f001ac($context, $indent, $value);
                // 'header_2' section
                $value = $context->find('header_2');
                $buffer .= $this->section0b04db77d2b20e7032dd9e5c47844efb($context, $indent, $value);
                // 'header_3' section
                $value = $context->find('header_3');
                $buffer .= $this->sectionAd2e48d8146c29c457ddb1451b94fc1b($context, $indent, $value);
                // 'header_4' section
                $value = $context->find('header_4');
                $buffer .= $this->section697d95cb6f8e975bf6643fa10b499e1a($context, $indent, $value);
                // 'header_5' section
                $value = $context->find('header_5');
                $buffer .= $this->section633f7e3739711e9e005695e0b420f1b1($context, $indent, $value);
                // 'header_6' section
                $value = $context->find('header_6');
                $buffer .= $this->section3d58fb9fb1d549dfadedb2a88fdae083($context, $indent, $value);
                // 'header_7' section
                $value = $context->find('header_7');
                $buffer .= $this->section66ab2b0e02aa9e44c9f7f0eac75733ab($context, $indent, $value);
                // 'header_8' section
                $value = $context->find('header_8');
                $buffer .= $this->section30758ff1c243ffdc893399a505cdaf9d($context, $indent, $value);
                // 'header_9' section
                $value = $context->find('header_9');
                $buffer .= $this->section25df9f81db3e9f06cc8631707dbad440($context, $indent, $value);
                // 'header_10' section
                $value = $context->find('header_10');
                $buffer .= $this->sectionBa448e8e78531ec28e07e57c0ecb8fb4($context, $indent, $value);
                // 'header_11' section
                $value = $context->find('header_11');
                $buffer .= $this->section6c90401367ff96357852c798e4afa68b($context, $indent, $value);
                // 'header_12' section
                $value = $context->find('header_12');
                $buffer .= $this->sectionD1e5f7cb283e84dae0d436f0f4be0c36($context, $indent, $value);
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_modals')) {
                    $buffer .= $partial->renderInternal($context, $indent . '  ');
                }
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_breadcrumb')) {
                    $buffer .= $partial->renderInternal($context, $indent . '  ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
