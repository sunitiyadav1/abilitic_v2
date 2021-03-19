<?php

class __Mustache_983c47e44d2f5107ec36bf584117c5c2 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        // 'breadcrumb_default' section
        $value = $context->find('breadcrumb_default');
        $buffer .= $this->section18c771f113e012fac3a8e6b103a16728($context, $indent, $value);
        // 'breadcrumb_m' section
        $value = $context->find('breadcrumb_m');
        $buffer .= $this->sectionBa4aa42e600aba88cc3a5a692a9f04bf($context, $indent, $value);
        // 'breadcrumb_s' section
        $value = $context->find('breadcrumb_s');
        $buffer .= $this->sectionE43121e97420e867f85024bac7413c0f($context, $indent, $value);
        // 'breadcrumb_xs' section
        $value = $context->find('breadcrumb_xs');
        $buffer .= $this->sectionF3913661d09b3a098adb30f0fbd6ef9e($context, $indent, $value);
        // 'breadcrumb_hidden' section
        $value = $context->find('breadcrumb_hidden');
        $buffer .= $this->section0ea239abcb330fa9edb793c7b6e418de($context, $indent, $value);

        return $buffer;
    }

    private function section5a76d5450669bf0c9df42bc12df5d0a5(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
              <h4 class="breadcrumb_title">{{{ pageheading }}}</h4>
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
                
                $buffer .= $indent . '              <h4 class="breadcrumb_title">';
                $value = $this->resolveValue($context->find('pageheading'), $context);
                $buffer .= $value;
                $buffer .= '</h4>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section0d6c2a2eaf2b510cb531548c16413925(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
              {{{ output.navbar }}}
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
                
                $buffer .= $indent . '              ';
                $value = $this->resolveValue($context->findDot('output.navbar'), $context);
                $buffer .= $value;
                $buffer .= '
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section18c771f113e012fac3a8e6b103a16728(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <section class="inner_page_breadcrumb ccn_breadcrumb_default {{{ breadcrumb_classes }}}">
    <div class="container">
      <div class="row">
        <div class="col-xl-12 text-center">
          <div class="breadcrumb_content">
            {{#if_breadcrumb_title}}
              <h4 class="breadcrumb_title">{{{ pageheading }}}</h4>
            {{/if_breadcrumb_title}}
            {{#if_breadcrumb_trail}}
              {{{ output.navbar }}}
            {{/if_breadcrumb_trail}}
          </div>
        </div>
      </div>
    </div>
  </section>
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
                
                $buffer .= $indent . '  <section class="inner_page_breadcrumb ccn_breadcrumb_default ';
                $value = $this->resolveValue($context->find('breadcrumb_classes'), $context);
                $buffer .= $value;
                $buffer .= '">
';
                $buffer .= $indent . '    <div class="container">
';
                $buffer .= $indent . '      <div class="row">
';
                $buffer .= $indent . '        <div class="col-xl-12 text-center">
';
                $buffer .= $indent . '          <div class="breadcrumb_content">
';
                // 'if_breadcrumb_title' section
                $value = $context->find('if_breadcrumb_title');
                $buffer .= $this->section5a76d5450669bf0c9df42bc12df5d0a5($context, $indent, $value);
                // 'if_breadcrumb_trail' section
                $value = $context->find('if_breadcrumb_trail');
                $buffer .= $this->section0d6c2a2eaf2b510cb531548c16413925($context, $indent, $value);
                $buffer .= $indent . '          </div>
';
                $buffer .= $indent . '        </div>
';
                $buffer .= $indent . '      </div>
';
                $buffer .= $indent . '    </div>
';
                $buffer .= $indent . '  </section>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionBa4aa42e600aba88cc3a5a692a9f04bf(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <section class="inner_page_breadcrumb ccn_breadcrumb_m {{{ breadcrumb_classes }}}">
    <div class="container">
      <div class="row">
        <div class="col-xl-12 text-center">
          <div class="breadcrumb_content">
            {{#if_breadcrumb_title}}
              <h4 class="breadcrumb_title">{{{ pageheading }}}</h4>
            {{/if_breadcrumb_title}}
            {{#if_breadcrumb_trail}}
              {{{ output.navbar }}}
            {{/if_breadcrumb_trail}}
          </div>
        </div>
      </div>
    </div>
  </section>
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
                
                $buffer .= $indent . '  <section class="inner_page_breadcrumb ccn_breadcrumb_m ';
                $value = $this->resolveValue($context->find('breadcrumb_classes'), $context);
                $buffer .= $value;
                $buffer .= '">
';
                $buffer .= $indent . '    <div class="container">
';
                $buffer .= $indent . '      <div class="row">
';
                $buffer .= $indent . '        <div class="col-xl-12 text-center">
';
                $buffer .= $indent . '          <div class="breadcrumb_content">
';
                // 'if_breadcrumb_title' section
                $value = $context->find('if_breadcrumb_title');
                $buffer .= $this->section5a76d5450669bf0c9df42bc12df5d0a5($context, $indent, $value);
                // 'if_breadcrumb_trail' section
                $value = $context->find('if_breadcrumb_trail');
                $buffer .= $this->section0d6c2a2eaf2b510cb531548c16413925($context, $indent, $value);
                $buffer .= $indent . '          </div>
';
                $buffer .= $indent . '        </div>
';
                $buffer .= $indent . '      </div>
';
                $buffer .= $indent . '    </div>
';
                $buffer .= $indent . '  </section>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC66a181ded1ede1c23ab7fa681e3fbd6(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'col-xl-6';
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
                
                $buffer .= 'col-xl-6';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionBbb7c30a0378a8730b55d32968921460(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <div class="{{#if_breadcrumb_trail}}col-xl-6{{/if_breadcrumb_trail}}{{^if_breadcrumb_trail}}col-xl-12{{/if_breadcrumb_trail}}">
              <h4 class="breadcrumb_title">{{{ pageheading }}}</h4>
            </div>
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
                
                $buffer .= $indent . '            <div class="';
                // 'if_breadcrumb_trail' section
                $value = $context->find('if_breadcrumb_trail');
                $buffer .= $this->sectionC66a181ded1ede1c23ab7fa681e3fbd6($context, $indent, $value);
                // 'if_breadcrumb_trail' inverted section
                $value = $context->find('if_breadcrumb_trail');
                if (empty($value)) {
                    
                    $buffer .= 'col-xl-12';
                }
                $buffer .= '">
';
                $buffer .= $indent . '              <h4 class="breadcrumb_title">';
                $value = $this->resolveValue($context->find('pageheading'), $context);
                $buffer .= $value;
                $buffer .= '</h4>
';
                $buffer .= $indent . '            </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionA4770e8fbd9cf36ef71a38169b19953c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <div class="{{#if_breadcrumb_title}}col-xl-6{{/if_breadcrumb_title}}{{^if_breadcrumb_title}}col-xl-12{{/if_breadcrumb_title}}">
              {{{ output.navbar }}}
            </div>
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
                
                $buffer .= $indent . '            <div class="';
                // 'if_breadcrumb_title' section
                $value = $context->find('if_breadcrumb_title');
                $buffer .= $this->sectionC66a181ded1ede1c23ab7fa681e3fbd6($context, $indent, $value);
                // 'if_breadcrumb_title' inverted section
                $value = $context->find('if_breadcrumb_title');
                if (empty($value)) {
                    
                    $buffer .= 'col-xl-12';
                }
                $buffer .= '">
';
                $buffer .= $indent . '              ';
                $value = $this->resolveValue($context->findDot('output.navbar'), $context);
                $buffer .= $value;
                $buffer .= '
';
                $buffer .= $indent . '            </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE43121e97420e867f85024bac7413c0f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <section class="inner_page_breadcrumb ccn_breadcrumb_s {{{ breadcrumb_classes }}}">
    <div class="container">
      <div class="breadcrumb_content">
        <div class="row">
          {{#if_breadcrumb_title}}
            <div class="{{#if_breadcrumb_trail}}col-xl-6{{/if_breadcrumb_trail}}{{^if_breadcrumb_trail}}col-xl-12{{/if_breadcrumb_trail}}">
              <h4 class="breadcrumb_title">{{{ pageheading }}}</h4>
            </div>
          {{/if_breadcrumb_title}}
          {{#if_breadcrumb_trail}}
            <div class="{{#if_breadcrumb_title}}col-xl-6{{/if_breadcrumb_title}}{{^if_breadcrumb_title}}col-xl-12{{/if_breadcrumb_title}}">
              {{{ output.navbar }}}
            </div>
          {{/if_breadcrumb_trail}}
        </div>
      </div>
    </div>
  </section>
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
                
                $buffer .= $indent . '  <section class="inner_page_breadcrumb ccn_breadcrumb_s ';
                $value = $this->resolveValue($context->find('breadcrumb_classes'), $context);
                $buffer .= $value;
                $buffer .= '">
';
                $buffer .= $indent . '    <div class="container">
';
                $buffer .= $indent . '      <div class="breadcrumb_content">
';
                $buffer .= $indent . '        <div class="row">
';
                // 'if_breadcrumb_title' section
                $value = $context->find('if_breadcrumb_title');
                $buffer .= $this->sectionBbb7c30a0378a8730b55d32968921460($context, $indent, $value);
                // 'if_breadcrumb_trail' section
                $value = $context->find('if_breadcrumb_trail');
                $buffer .= $this->sectionA4770e8fbd9cf36ef71a38169b19953c($context, $indent, $value);
                $buffer .= $indent . '        </div>
';
                $buffer .= $indent . '      </div>
';
                $buffer .= $indent . '    </div>
';
                $buffer .= $indent . '  </section>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF3913661d09b3a098adb30f0fbd6ef9e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <section class="inner_page_breadcrumb ccn_breadcrumb_s ccn_breadcrumb_xs {{{ breadcrumb_classes }}}">
    <div class="container">
      <div class="breadcrumb_content">
        <div class="row">
          {{#if_breadcrumb_title}}
            <div class="{{#if_breadcrumb_trail}}col-xl-6{{/if_breadcrumb_trail}}{{^if_breadcrumb_trail}}col-xl-12{{/if_breadcrumb_trail}}">
              <h4 class="breadcrumb_title">{{{ pageheading }}}</h4>
            </div>
          {{/if_breadcrumb_title}}
          {{#if_breadcrumb_trail}}
            <div class="{{#if_breadcrumb_title}}col-xl-6{{/if_breadcrumb_title}}{{^if_breadcrumb_title}}col-xl-12{{/if_breadcrumb_title}}">
              {{{ output.navbar }}}
            </div>
          {{/if_breadcrumb_trail}}
        </div>
      </div>
    </div>
  </section>
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
                
                $buffer .= $indent . '  <section class="inner_page_breadcrumb ccn_breadcrumb_s ccn_breadcrumb_xs ';
                $value = $this->resolveValue($context->find('breadcrumb_classes'), $context);
                $buffer .= $value;
                $buffer .= '">
';
                $buffer .= $indent . '    <div class="container">
';
                $buffer .= $indent . '      <div class="breadcrumb_content">
';
                $buffer .= $indent . '        <div class="row">
';
                // 'if_breadcrumb_title' section
                $value = $context->find('if_breadcrumb_title');
                $buffer .= $this->sectionBbb7c30a0378a8730b55d32968921460($context, $indent, $value);
                // 'if_breadcrumb_trail' section
                $value = $context->find('if_breadcrumb_trail');
                $buffer .= $this->sectionA4770e8fbd9cf36ef71a38169b19953c($context, $indent, $value);
                $buffer .= $indent . '        </div>
';
                $buffer .= $indent . '      </div>
';
                $buffer .= $indent . '    </div>
';
                $buffer .= $indent . '  </section>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section0ea239abcb330fa9edb793c7b6e418de(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <section class="inner_page_breadcrumb ccn_breadcrumb_absent">
    <div class="container">
      <div class="row">
        <div class="col-xl-12 text-center">
        </div>
      </div>
    </div>
  </section>
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
                
                $buffer .= $indent . '  <section class="inner_page_breadcrumb ccn_breadcrumb_absent">
';
                $buffer .= $indent . '    <div class="container">
';
                $buffer .= $indent . '      <div class="row">
';
                $buffer .= $indent . '        <div class="col-xl-12 text-center">
';
                $buffer .= $indent . '        </div>
';
                $buffer .= $indent . '      </div>
';
                $buffer .= $indent . '    </div>
';
                $buffer .= $indent . '  </section>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
