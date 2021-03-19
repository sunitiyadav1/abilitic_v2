<?php

class __Mustache_4617e08fd6c91809c26d8f12433fe399 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        if ($partial = $this->mustache->loadPartial('theme_edumy/head_dashboard')) {
            $buffer .= $partial->renderInternal($context);
        }
        $buffer .= $indent . '<body ';
        $value = $this->resolveValue($context->find('bodyattributes'), $context);
        $buffer .= $value;
        $buffer .= '>
';
        $buffer .= $indent . '  <div class="wrapper">
';
        if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_clean_navbar')) {
            $buffer .= $partial->renderInternal($context, $indent . '    ');
        }
        $buffer .= $indent . '    <div class="our-dashbord dashbord">
';
        $buffer .= $indent . '      <div class="dashboard_main_content">
';
        $buffer .= $indent . '        <div class="container-fluid">
';
        $buffer .= $indent . '          <div class="main_content_container">
';
        $buffer .= $indent . '            <div class="row">
';
        $buffer .= $indent . '              <div class="col-xl-12">
';
        $buffer .= $indent . '                <div class="row">
';
        $buffer .= $indent . '                  <div class="col-lg-12">
';
        $buffer .= $indent . '                    <nav class="breadcrumb_widgets ';
        $value = $this->resolveValue($context->find('breadcrumb_clip_dash'), $context);
        $buffer .= $value;
        $buffer .= '" aria-label="breadcrumb mb30">
';
        $buffer .= $indent . '                      <h4 class="title float-left">';
        $value = $this->resolveValue($context->find('pageheading'), $context);
        $buffer .= $value;
        $buffer .= '</h4>
';
        $buffer .= $indent . '                      <ol class="breadcrumb float-right">
';
        $buffer .= $indent . '                        ';
        $value = $this->resolveValue($context->findDot('output.navbar'), $context);
        $buffer .= $value;
        $buffer .= '
';
        $buffer .= $indent . '                      </ol>
';
        $buffer .= $indent . '                    </nav>
';
        $buffer .= $indent . '                  </div>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '                <div class="row">
';
        $buffer .= $indent . '                  <div class="col-lg-12">
';
        $buffer .= $indent . '                    ';
        $value = $this->resolveValue($context->findDot('output.standard_top_of_body_html'), $context);
        $buffer .= $value;
        $buffer .= '
';
        $buffer .= $indent . '                    ';
        $value = $this->resolveValue($context->findDot('output.full_header'), $context);
        $buffer .= $value;
        $buffer .= '
';
        $buffer .= $indent . '                    ';
        $value = $this->resolveValue($context->find('blocks_fullwidth_top'), $context);
        $buffer .= $value;
        $buffer .= '
';
        $buffer .= $indent . '                    ';
        $value = $this->resolveValue($context->findDot('output.region_main_settings_menu'), $context);
        $buffer .= $value;
        $buffer .= '
';
        $buffer .= $indent . '                    ';
        $value = $this->resolveValue($context->findDot('output.course_content_header'), $context);
        $buffer .= $value;
        $buffer .= '
';
        $buffer .= $indent . '                    ';
        $value = $this->resolveValue($context->findDot('output.main_content'), $context);
        $buffer .= $value;
        $buffer .= '
';
        $buffer .= $indent . '                    ';
        $value = $this->resolveValue($context->findDot('output.activity_navigation'), $context);
        $buffer .= $value;
        $buffer .= '
';
        $buffer .= $indent . '                    ';
        $value = $this->resolveValue($context->findDot('output.course_content_footer'), $context);
        $buffer .= $value;
        $buffer .= '
';
        $buffer .= $indent . '                  </div>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '              </div>
';
        $buffer .= $indent . '            </div>
';
        if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_clean_footer')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        $buffer .= $indent . '          </div>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '      </div>
';
        $buffer .= $indent . '    </div>
';
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
