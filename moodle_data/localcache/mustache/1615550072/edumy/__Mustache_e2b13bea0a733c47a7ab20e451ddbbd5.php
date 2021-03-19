<?php

class __Mustache_e2b13bea0a733c47a7ab20e451ddbbd5 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        if ($partial = $this->mustache->loadPartial('theme_boost/head')) {
            $buffer .= $partial->renderInternal($context);
        }
        $buffer .= $indent . '<body ';
        $value = $this->resolveValue($context->find('bodyattributes'), $context);
        $buffer .= $value;
        $buffer .= '>
';
        if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_preloader')) {
            $buffer .= $partial->renderInternal($context, $indent . '  ');
        }
        $buffer .= $indent . '  <div class="wrapper">
';
        if ($partial = $this->mustache->loadPartial('theme_boost/navbar')) {
            $buffer .= $partial->renderInternal($context, $indent . '    ');
        }
        $buffer .= $indent . '    <div id="ccn-page-wrapper">
';
        $buffer .= $indent . '      <div id="ccnSettingsMenuContainer"><div id="ccnSettingsMenuInner">';
        $buffer .= '
';
        // 'show_settings_controls' section
        $value = $context->find('show_settings_controls');
        $buffer .= $this->section6d41d18206c31ce4a21e583a36fd6ee5($context, $indent, $value);
        $buffer .= $indent . '      </div></div>
';
        $buffer .= $indent . '      ';
        $value = $this->resolveValue($context->findDot('output.standard_top_of_body_html'), $context);
        $buffer .= $value;
        $buffer .= '
';
        $buffer .= $indent . '      <div>
';
        $buffer .= $indent . '        ';
        $value = $this->resolveValue($context->findDot('output.full_header'), $context);
        $buffer .= $value;
        $buffer .= '
';
        $buffer .= $indent . '        ';
        $value = $this->resolveValue($context->find('blocks_fullwidth_top'), $context);
        $buffer .= $value;
        $buffer .= '
';
        $buffer .= $indent . '        <div id="ccn-main-region">
';
        $buffer .= $indent . '          <div class="container">
';
        $buffer .= $indent . '            <div class="row">
';
        // 'sidebar_left' section
        $value = $context->find('sidebar_left');
        $buffer .= $this->section7ab151a12205bfc9e8e349fdcaabbaa5($context, $indent, $value);
        $buffer .= $indent . '              <div class="
';
        $buffer .= $indent . '                ';
        // 'sidebar_none' section
        $value = $context->find('sidebar_none');
        $buffer .= $this->section8a83276f77018d8024cdfa9f88cb26a4($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '                ';
        // 'sidebar_double' section
        $value = $context->find('sidebar_double');
        $buffer .= $this->section48a89749267005c08cb744ec12db6900($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '                ';
        // 'sidebar_single_left' section
        $value = $context->find('sidebar_single_left');
        $buffer .= $this->sectionEe15739d06a889ded9d487c62d2d53f5($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '                ';
        // 'sidebar_single_right' section
        $value = $context->find('sidebar_single_right');
        $buffer .= $this->sectionD573161f14fb065d7ebf39f684b5295f($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '              ">
';
        $buffer .= $indent . '              <div id="region-main" ';
        // 'hasblocks' section
        $value = $context->find('hasblocks');
        $buffer .= $this->sectionA21ff12f1cbdc933a3d7049f000660a7($context, $indent, $value);
        $buffer .= ' aria-label="';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->section6b403a6a78537640b9e04a931aeb6463($context, $indent, $value);
        $buffer .= '">
';
        // 'hasregionmainsettingsmenu' section
        $value = $context->find('hasregionmainsettingsmenu');
        $buffer .= $this->sectionB2c09adf75397e1d177bda0d98ad769b($context, $indent, $value);
        // 'has_blocks_above_content' section
        $value = $context->find('has_blocks_above_content');
        $buffer .= $this->section7728471d8a3e59d963a8f0257e4a0111($context, $indent, $value);
        $buffer .= $indent . '                <div id="ccn-main">
';
        // 'is_course' section
        $value = $context->find('is_course');
        $buffer .= $this->section276a8eccc42a240167b957a05b837a37($context, $indent, $value);
        $buffer .= $indent . '                  ';
        $value = $this->resolveValue($context->findDot('output.course_content_header'), $context);
        $buffer .= $value;
        $buffer .= '
';
        $buffer .= $indent . '                  ';
        $value = $this->resolveValue($context->findDot('output.main_content'), $context);
        $buffer .= $value;
        $buffer .= '
';
        // 'incourse' section
        $value = $context->find('incourse');
        $buffer .= $this->sectionAe669a8cb4c4969d5340ff4f5c353a49($context, $indent, $value);
        $buffer .= $indent . '                  ';
        $value = $this->resolveValue($context->findDot('output.course_content_footer'), $context);
        $buffer .= $value;
        $buffer .= '
';
        // 'is_course' section
        $value = $context->find('is_course');
        $buffer .= $this->section053ff9205ab16ceebb3e0ff44eeb48c0($context, $indent, $value);
        $buffer .= $indent . '                </div>
';
        // 'has_blocks_below_content' section
        $value = $context->find('has_blocks_below_content');
        $buffer .= $this->sectionC9a09eec73ff175fbbff07ee80921867($context, $indent, $value);
        $buffer .= $indent . '              </div>
';
        $buffer .= $indent . '              </div>
';
        // 'sidebar_right' section
        $value = $context->find('sidebar_right');
        $buffer .= $this->section5a7dd639061a268fbad5ae3c9f19e5ba($context, $indent, $value);
        $buffer .= $indent . '            </div>
';
        $buffer .= $indent . '          </div>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '        ';
        $value = $this->resolveValue($context->find('blocks_fullwidth_bottom'), $context);
        $buffer .= $value;
        $buffer .= '
';
        $buffer .= $indent . '      </div>
';
        $buffer .= $indent . '    </div>
';
        if ($partial = $this->mustache->loadPartial('theme_boost/footer')) {
            $buffer .= $partial->renderInternal($context, $indent . '  ');
        }
        $buffer .= $indent . '  </div>
';
        $buffer .= $indent . '  ';
        $value = $this->resolveValue($context->findDot('output.standard_after_main_region_html'), $context);
        $buffer .= $value;
        $buffer .= '
';
        $buffer .= $indent . '</body>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '</html>
';
        // 'js' section
        $value = $context->find('js');
        $buffer .= $this->section594644b43f41eedfedc914de6473d7f6($context, $indent, $value);

        return $buffer;
    }

    private function section8ae768dbd9f60a7f7df4aaf3cee7aa89(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'has-blocks';
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
                
                $buffer .= 'has-blocks';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section04f4045a58c4671a15076b9f3a062fef(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <div id="region-main-settings-menu" class="d-print-none {{#hasblocks}}has-blocks{{/hasblocks}}">
              <div> {{{ output.region_main_settings_menu }}} </div>
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
                
                $buffer .= $indent . '            <div id="region-main-settings-menu" class="d-print-none ';
                // 'hasblocks' section
                $value = $context->find('hasblocks');
                $buffer .= $this->section8ae768dbd9f60a7f7df4aaf3cee7aa89($context, $indent, $value);
                $buffer .= '">
';
                $buffer .= $indent . '              <div> ';
                $value = $this->resolveValue($context->findDot('output.region_main_settings_menu'), $context);
                $buffer .= $value;
                $buffer .= ' </div>
';
                $buffer .= $indent . '            </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6d41d18206c31ce4a21e583a36fd6ee5(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
          {{#hasregionmainsettingsmenu}}
            <div id="region-main-settings-menu" class="d-print-none {{#hasblocks}}has-blocks{{/hasblocks}}">
              <div> {{{ output.region_main_settings_menu }}} </div>
            </div>
          {{/hasregionmainsettingsmenu}}
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
                
                // 'hasregionmainsettingsmenu' section
                $value = $context->find('hasregionmainsettingsmenu');
                $buffer .= $this->section04f4045a58c4671a15076b9f3a062fef($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section0d4e4b25bc133217e63d22bde9040707(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' col-lg-3 col-xl-3 ';
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
                
                $buffer .= ' col-lg-3 col-xl-3 ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC14df02445cdd505a0208e8a56a5f32e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'blocks';
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
                
                $buffer .= 'blocks';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section7ab151a12205bfc9e8e349fdcaabbaa5(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                <div class="{{#sidebar_double}} col-lg-3 col-xl-3 {{/sidebar_double}} {{^sidebar_double}} col-lg-4 col-xl-4 {{/sidebar_double}}">
                  <div class="ccn-sidebar-region" aria-label="{{#str}}blocks{{/str}}">
                    {{{ leftblocks }}}
                  </div>
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
                
                $buffer .= $indent . '                <div class="';
                // 'sidebar_double' section
                $value = $context->find('sidebar_double');
                $buffer .= $this->section0d4e4b25bc133217e63d22bde9040707($context, $indent, $value);
                $buffer .= ' ';
                // 'sidebar_double' inverted section
                $value = $context->find('sidebar_double');
                if (empty($value)) {
                    
                    $buffer .= ' col-lg-4 col-xl-4 ';
                }
                $buffer .= '">
';
                $buffer .= $indent . '                  <div class="ccn-sidebar-region" aria-label="';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->sectionC14df02445cdd505a0208e8a56a5f32e($context, $indent, $value);
                $buffer .= '">
';
                $buffer .= $indent . '                    ';
                $value = $this->resolveValue($context->find('leftblocks'), $context);
                $buffer .= $value;
                $buffer .= '
';
                $buffer .= $indent . '                  </div>
';
                $buffer .= $indent . '                </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8a83276f77018d8024cdfa9f88cb26a4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' col-md-12 col-lg-12 col-xl-12 ';
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
                
                $buffer .= ' col-md-12 col-lg-12 col-xl-12 ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section48a89749267005c08cb744ec12db6900(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' col-lg-6 ';
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
                
                $buffer .= ' col-lg-6 ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionEe15739d06a889ded9d487c62d2d53f5(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' col-lg-8 col-xl-8 ';
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
                
                $buffer .= ' col-lg-8 col-xl-8 ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD573161f14fb065d7ebf39f684b5295f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' col-md-12 col-lg-8 col-xl-9 ';
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
                
                $buffer .= ' col-md-12 col-lg-8 col-xl-9 ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionA21ff12f1cbdc933a3d7049f000660a7(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'class="--rm--has-blocks" ';
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
                
                $buffer .= 'class="--rm--has-blocks" ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6b403a6a78537640b9e04a931aeb6463(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'content';
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
                
                $buffer .= 'content';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB2c09adf75397e1d177bda0d98ad769b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                  <div class="region_main_settings_menu_proxy"></div>
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
                
                $buffer .= $indent . '                  <div class="region_main_settings_menu_proxy"></div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section7728471d8a3e59d963a8f0257e4a0111(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                  {{{ blocks_above_content }}}
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
                
                $buffer .= $indent . '                  ';
                $value = $this->resolveValue($context->find('blocks_above_content'), $context);
                $buffer .= $value;
                $buffer .= '
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section2e6cd0a936901797b090597d2d9a3d5d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'course_content, theme_edumy';
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
                
                $buffer .= 'course_content, theme_edumy';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section873ac88669d0662d7d6427563b77436c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'startdate';
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
                
                $buffer .= 'startdate';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section77f4c5daf234634fd490148584970586(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                                  <li class="list-inline-item"><a href="#">{{#str}}startdate{{/str}}: {{{ coursestartdate }}} </a></li>
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
                
                $buffer .= $indent . '                                  <li class="list-inline-item"><a href="#">';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section873ac88669d0662d7d6427563b77436c($context, $indent, $value);
                $buffer .= ': ';
                $value = $this->resolveValue($context->find('coursestartdate'), $context);
                $buffer .= $value;
                $buffer .= ' </a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section946bec447291f29362b3f4daf03b12c0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'category';
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
                
                $buffer .= 'category';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE3ac27568514b7164ce1763219641d51(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                                  <li class="list-inline-item"><a href="#">{{#str}}category{{/str}}: {{{ coursecategory }}}</a></li>
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
                
                $buffer .= $indent . '                                  <li class="list-inline-item"><a href="#">';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section946bec447291f29362b3f4daf03b12c0($context, $indent, $value);
                $buffer .= ': ';
                $value = $this->resolveValue($context->find('coursecategory'), $context);
                $buffer .= $value;
                $buffer .= '</a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section13a0a6c28ab3861e617035e85ac5ae66(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                      {{^participant_user_profile}}
                        <div class="cs_row_three">
                          <div class="course_content">
                            <div class="cc_headers">
                              <h4 class="title">{{#str}}course_content, theme_edumy{{/str}}</h4>
                              <ul class="course_schdule float-right">
                                {{#show_course_start}}
                                  <li class="list-inline-item"><a href="#">{{#str}}startdate{{/str}}: {{{ coursestartdate }}} </a></li>
                                {{/show_course_start}}
                                {{#show_course_category}}
                                  <li class="list-inline-item"><a href="#">{{#str}}category{{/str}}: {{{ coursecategory }}}</a></li>
                                {{/show_course_category}}
                              </ul>
                            </div>
                            <br>
                      {{/participant_user_profile}}
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
                
                // 'participant_user_profile' inverted section
                $value = $context->find('participant_user_profile');
                if (empty($value)) {
                    
                    $buffer .= $indent . '                        <div class="cs_row_three">
';
                    $buffer .= $indent . '                          <div class="course_content">
';
                    $buffer .= $indent . '                            <div class="cc_headers">
';
                    $buffer .= $indent . '                              <h4 class="title">';
                    // 'str' section
                    $value = $context->find('str');
                    $buffer .= $this->section2e6cd0a936901797b090597d2d9a3d5d($context, $indent, $value);
                    $buffer .= '</h4>
';
                    $buffer .= $indent . '                              <ul class="course_schdule float-right">
';
                    // 'show_course_start' section
                    $value = $context->find('show_course_start');
                    $buffer .= $this->section77f4c5daf234634fd490148584970586($context, $indent, $value);
                    // 'show_course_category' section
                    $value = $context->find('show_course_category');
                    $buffer .= $this->sectionE3ac27568514b7164ce1763219641d51($context, $indent, $value);
                    $buffer .= $indent . '                              </ul>
';
                    $buffer .= $indent . '                            </div>
';
                    $buffer .= $indent . '                            <br>
';
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section276a8eccc42a240167b957a05b837a37(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    {{^display_course_content}}
                      <div id="ccn_prohibit_course_content"></div>
                    {{/display_course_content}}
                    {{#display_course_content}}
                      {{^participant_user_profile}}
                        <div class="cs_row_three">
                          <div class="course_content">
                            <div class="cc_headers">
                              <h4 class="title">{{#str}}course_content, theme_edumy{{/str}}</h4>
                              <ul class="course_schdule float-right">
                                {{#show_course_start}}
                                  <li class="list-inline-item"><a href="#">{{#str}}startdate{{/str}}: {{{ coursestartdate }}} </a></li>
                                {{/show_course_start}}
                                {{#show_course_category}}
                                  <li class="list-inline-item"><a href="#">{{#str}}category{{/str}}: {{{ coursecategory }}}</a></li>
                                {{/show_course_category}}
                              </ul>
                            </div>
                            <br>
                      {{/participant_user_profile}}
                    {{/display_course_content}}
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
                
                // 'display_course_content' inverted section
                $value = $context->find('display_course_content');
                if (empty($value)) {
                    
                    $buffer .= $indent . '                      <div id="ccn_prohibit_course_content"></div>
';
                }
                // 'display_course_content' section
                $value = $context->find('display_course_content');
                $buffer .= $this->section13a0a6c28ab3861e617035e85ac5ae66($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionAe669a8cb4c4969d5340ff4f5c353a49(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    {{{ output.activity_navigation }}}
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
                
                $buffer .= $indent . '                    ';
                $value = $this->resolveValue($context->findDot('output.activity_navigation'), $context);
                $buffer .= $value;
                $buffer .= '
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionA2115c45bc60a0e649457d0ec3097a60(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                      {{^participant_user_profile}}
                          </div>
                        </div>
                      {{/participant_user_profile}}
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
                
                // 'participant_user_profile' inverted section
                $value = $context->find('participant_user_profile');
                if (empty($value)) {
                    
                    $buffer .= $indent . '                          </div>
';
                    $buffer .= $indent . '                        </div>
';
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section053ff9205ab16ceebb3e0ff44eeb48c0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    {{#display_course_content}}
                      {{^participant_user_profile}}
                          </div>
                        </div>
                      {{/participant_user_profile}}
                    {{/display_course_content}}
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
                
                // 'display_course_content' section
                $value = $context->find('display_course_content');
                $buffer .= $this->sectionA2115c45bc60a0e649457d0ec3097a60($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC9a09eec73ff175fbbff07ee80921867(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                  {{{ blocks_below_content }}}
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
                
                $buffer .= $indent . '                  ';
                $value = $this->resolveValue($context->find('blocks_below_content'), $context);
                $buffer .= $value;
                $buffer .= '
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5a7dd639061a268fbad5ae3c9f19e5ba(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                <div class="col-lg-4 col-xl-3">
                  <div class="ccn-sidebar-region" aria-label="{{#str}}blocks{{/str}}">
                    {{{ sidepreblocks }}}
                  </div>
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
                
                $buffer .= $indent . '                <div class="col-lg-4 col-xl-3">
';
                $buffer .= $indent . '                  <div class="ccn-sidebar-region" aria-label="';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->sectionC14df02445cdd505a0208e8a56a5f32e($context, $indent, $value);
                $buffer .= '">
';
                $buffer .= $indent . '                    ';
                $value = $this->resolveValue($context->find('sidepreblocks'), $context);
                $buffer .= $value;
                $buffer .= '
';
                $buffer .= $indent . '                  </div>
';
                $buffer .= $indent . '                </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section594644b43f41eedfedc914de6473d7f6(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  M.util.js_pending(\'theme_boost/loader\');
  require([\'theme_boost/loader\'], function() {
  M.util.js_complete(\'theme_boost/loader\');
  });
  M.util.js_pending(\'theme_boost/drawer\');
  require([\'theme_boost/drawer\'], function(mod) {
  mod.init();
  M.util.js_complete(\'theme_boost/drawer\');
  });
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
                
                $buffer .= $indent . '  M.util.js_pending(\'theme_boost/loader\');
';
                $buffer .= $indent . '  require([\'theme_boost/loader\'], function() {
';
                $buffer .= $indent . '  M.util.js_complete(\'theme_boost/loader\');
';
                $buffer .= $indent . '  });
';
                $buffer .= $indent . '  M.util.js_pending(\'theme_boost/drawer\');
';
                $buffer .= $indent . '  require([\'theme_boost/drawer\'], function(mod) {
';
                $buffer .= $indent . '  mod.init();
';
                $buffer .= $indent . '  M.util.js_complete(\'theme_boost/drawer\');
';
                $buffer .= $indent . '  });
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
