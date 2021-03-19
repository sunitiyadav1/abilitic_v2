<?php

class __Mustache_971fd0a39acc171f4f5dd01ab38847d2 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        // 'footer_4' section
        $value = $context->find('footer_4');
        $buffer .= $this->section467c8ea0e052d9be92cb72ed8d29d0a8($context, $indent, $value);
        // 'footer_4' inverted section
        $value = $context->find('footer_4');
        if (empty($value)) {
            
            // 'footer_1' section
            $value = $context->find('footer_1');
            $buffer .= $this->section365da4058c36ddb7cc12f79af6702f36($context, $indent, $value);
            // 'footer_2' section
            $value = $context->find('footer_2');
            $buffer .= $this->section365da4058c36ddb7cc12f79af6702f36($context, $indent, $value);
            // 'footer_3' section
            $value = $context->find('footer_3');
            $buffer .= $this->section365da4058c36ddb7cc12f79af6702f36($context, $indent, $value);
            // 'footer_5' section
            $value = $context->find('footer_5');
            $buffer .= $this->section365da4058c36ddb7cc12f79af6702f36($context, $indent, $value);
            // 'footer_6' section
            $value = $context->find('footer_6');
            $buffer .= $this->section365da4058c36ddb7cc12f79af6702f36($context, $indent, $value);
            // 'footer_7' section
            $value = $context->find('footer_7');
            $buffer .= $this->section365da4058c36ddb7cc12f79af6702f36($context, $indent, $value);
            // 'footer_8' section
            $value = $context->find('footer_8');
            $buffer .= $this->section66c963945ff5c5348fb9c36ded5cd6b8($context, $indent, $value);
            // 'footer_9' section
            $value = $context->find('footer_9');
            $buffer .= $this->section64b698ea7cb11442917cd6baebe6dcb3($context, $indent, $value);
        }
        $buffer .= $indent . '
';
        // 'back_to_top' section
        $value = $context->find('back_to_top');
        $buffer .= $this->section5aa096c8cddc0853fbe03993f81ba285($context, $indent, $value);
        $buffer .= $indent . '
';
        // 'gmaps_key' section
        $value = $context->find('gmaps_key');
        $buffer .= $this->section1a7284b9d6e7de10ecdcf71b0f6e2bed($context, $indent, $value);
        $buffer .= $indent . '
';
        $value = $this->resolveValue($context->find('custom_js'), $context);
        $buffer .= $indent . $value;
        $buffer .= '
';
        $value = $this->resolveValue($context->findDot('output.standard_end_of_body_html'), $context);
        $buffer .= $indent . $value;
        $buffer .= '
';

        return $buffer;
    }

    private function sectionEbcb475427c7d7727fb30e127940463d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' style="{{{logo_styles_footer}}}" ';
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
                
                $buffer .= ' style="';
                $value = $this->resolveValue($context->find('logo_styles_footer'), $context);
                $buffer .= $value;
                $buffer .= '" ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section4a19a470f89eec2fc8a01d959dcefb49(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<img class="img-fluid" src="{{{footerlogo1}}}" alt="{{ sitename }}" {{#logo_styles_footer}} style="{{{logo_styles_footer}}}" {{/logo_styles_footer}}>';
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
                
                $buffer .= '<img class="img-fluid" src="';
                $value = $this->resolveValue($context->find('footerlogo1'), $context);
                $buffer .= $value;
                $buffer .= '" alt="';
                $value = $this->resolveValue($context->find('sitename'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '" ';
                // 'logo_styles_footer' section
                $value = $context->find('logo_styles_footer');
                $buffer .= $this->sectionEbcb475427c7d7727fb30e127940463d($context, $indent, $value);
                $buffer .= '>';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section254d7600dae2d4e2af67ba2cfb1315f4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<span>{{ sitename }}</span>';
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
                
                $buffer .= '<span>';
                $value = $this->resolveValue($context->find('sitename'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '</span>';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section23791c88e579047fc1fac815ac79b374(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <div class="logo-widget home8 mb60">
              {{#logo_image_footer}}<img class="img-fluid" src="{{{footerlogo1}}}" alt="{{ sitename }}" {{#logo_styles_footer}} style="{{{logo_styles_footer}}}" {{/logo_styles_footer}}>{{/logo_image_footer}}
              {{#logotype_footer}}<span>{{ sitename }}</span>{{/logotype_footer}}
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
                
                $buffer .= $indent . '            <div class="logo-widget home8 mb60">
';
                $buffer .= $indent . '              ';
                // 'logo_image_footer' section
                $value = $context->find('logo_image_footer');
                $buffer .= $this->section4a19a470f89eec2fc8a01d959dcefb49($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '              ';
                // 'logotype_footer' section
                $value = $context->find('logotype_footer');
                $buffer .= $this->section254d7600dae2d4e2af67ba2cfb1315f4($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '            </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB3dc9786162ea2ce03c148df92779261(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
          <div class="col-lg-6 col-xl-6">
            <div class="copyright-widget text-center mt25">
              <p>{{{ cocoon_copyright }}}</p>
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
                
                $buffer .= $indent . '          <div class="col-lg-6 col-xl-6">
';
                $buffer .= $indent . '            <div class="copyright-widget text-center mt25">
';
                $buffer .= $indent . '              <p>';
                $value = $this->resolveValue($context->find('cocoon_copyright'), $context);
                $buffer .= $value;
                $buffer .= '</p>
';
                $buffer .= $indent . '            </div>
';
                $buffer .= $indent . '          </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section99a8b78ecb202442421ce3911634d38c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
          <div class="col-lg-6 col-xl-6 pb25 pt25 text-right tac-smd">
            <div class="footer_menu_widget home3">
              {{{footer_menu}}}
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
                
                $buffer .= $indent . '          <div class="col-lg-6 col-xl-6 pb25 pt25 text-right tac-smd">
';
                $buffer .= $indent . '            <div class="footer_menu_widget home3">
';
                $buffer .= $indent . '              ';
                $value = $this->resolveValue($context->find('footer_menu'), $context);
                $buffer .= $value;
                $buffer .= '
';
                $buffer .= $indent . '            </div>
';
                $buffer .= $indent . '          </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section467c8ea0e052d9be92cb72ed8d29d0a8(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <section class="footer_one home8 pb0">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          {{#logo_footer}}
            <div class="logo-widget home8 mb60">
              {{#logo_image_footer}}<img class="img-fluid" src="{{{footerlogo1}}}" alt="{{ sitename }}" {{#logo_styles_footer}} style="{{{logo_styles_footer}}}" {{/logo_styles_footer}}>{{/logo_image_footer}}
              {{#logotype_footer}}<span>{{ sitename }}</span>{{/logotype_footer}}
            </div>
          {{/logo_footer}}
          <div class="footer_contact_widget home8 text-center">
            {{{footer_col_1_body}}}
          </div>
          <div class="footer_social_widget home8 mt35 mb80">
            <ul>
              {{> theme_edumy/ccn_social_icons }}
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        {{#cocoon_copyright}}
          <div class="col-lg-6 col-xl-6">
            <div class="copyright-widget text-center mt25">
              <p>{{{ cocoon_copyright }}}</p>
            </div>
          </div>
        {{/cocoon_copyright}}
        {{#footer_menu}}
          <div class="col-lg-6 col-xl-6 pb25 pt25 text-right tac-smd">
            <div class="footer_menu_widget home3">
              {{{footer_menu}}}
            </div>
          </div>
        {{/footer_menu}}
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
                
                $buffer .= $indent . '  <section class="footer_one home8 pb0">
';
                $buffer .= $indent . '    <div class="container">
';
                $buffer .= $indent . '      <div class="row">
';
                $buffer .= $indent . '        <div class="col-lg-6 offset-lg-3">
';
                // 'logo_footer' section
                $value = $context->find('logo_footer');
                $buffer .= $this->section23791c88e579047fc1fac815ac79b374($context, $indent, $value);
                $buffer .= $indent . '          <div class="footer_contact_widget home8 text-center">
';
                $buffer .= $indent . '            ';
                $value = $this->resolveValue($context->find('footer_col_1_body'), $context);
                $buffer .= $value;
                $buffer .= '
';
                $buffer .= $indent . '          </div>
';
                $buffer .= $indent . '          <div class="footer_social_widget home8 mt35 mb80">
';
                $buffer .= $indent . '            <ul>
';
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_social_icons')) {
                    $buffer .= $partial->renderInternal($context, $indent . '              ');
                }
                $buffer .= $indent . '            </ul>
';
                $buffer .= $indent . '          </div>
';
                $buffer .= $indent . '        </div>
';
                $buffer .= $indent . '      </div>
';
                $buffer .= $indent . '    </div>
';
                $buffer .= $indent . '    <div class="container">
';
                $buffer .= $indent . '      <div class="row">
';
                // 'cocoon_copyright' section
                $value = $context->find('cocoon_copyright');
                $buffer .= $this->sectionB3dc9786162ea2ce03c148df92779261($context, $indent, $value);
                // 'footer_menu' section
                $value = $context->find('footer_menu');
                $buffer .= $this->section99a8b78ecb202442421ce3911634d38c($context, $indent, $value);
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

    private function section365da4058c36ddb7cc12f79af6702f36(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{> theme_edumy/ccn_footer_default }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_footer_default')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section66c963945ff5c5348fb9c36ded5cd6b8(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{> theme_edumy/ccn_footer_8 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_footer_8')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section64b698ea7cb11442917cd6baebe6dcb3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{> theme_edumy/ccn_footer_9 }}
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
                
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_footer_9')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5aa096c8cddc0853fbe03993f81ba285(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <a class="scrollToHome" href="#"><i class="flaticon-up-arrow-1"></i></a>
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
                
                $buffer .= $indent . '  <a class="scrollToHome" href="#"><i class="flaticon-up-arrow-1"></i></a>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section1a7284b9d6e7de10ecdcf71b0f6e2bed(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <script src="//maps.googleapis.com/maps/api/js?key={{gmaps_key}}"></script>
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
                
                $buffer .= $indent . '  <script src="//maps.googleapis.com/maps/api/js?key=';
                $value = $this->resolveValue($context->find('gmaps_key'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '"></script>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
