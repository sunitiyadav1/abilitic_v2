<?php

class __Mustache_33a569f313384c1b60d6162197ad04cd extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<header class="ccnHeader1 header-nav menu_style_home_one navbar-scrolltofixed stricky main-menu">
';
        $buffer .= $indent . '  <div class="container-fluid">
';
        $buffer .= $indent . '    <!-- Ace Responsive Menu -->
';
        $buffer .= $indent . '    <nav>
';
        $buffer .= $indent . '      <!-- Menu Toggle btn-->
';
        $buffer .= $indent . '      <div class="menu-toggle">
';
        $buffer .= $indent . '        <img class="nav_logo_img img-fluid" src="';
        $value = $this->resolveValue($context->find('headerlogo1'), $context);
        $buffer .= $value;
        $buffer .= '" alt="';
        $value = $this->resolveValue($context->find('sitename'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= '">
';
        $buffer .= $indent . '        <button type="button" id="menu-btn">
';
        $buffer .= $indent . '          <span class="icon-bar"></span>
';
        $buffer .= $indent . '          <span class="icon-bar"></span>
';
        $buffer .= $indent . '          <span class="icon-bar"></span>
';
        $buffer .= $indent . '        </button>
';
        $buffer .= $indent . '      </div>
';
        // 'logo' section
        $value = $context->find('logo');
        $buffer .= $this->section1289f146621b3c52ef8d1ecac98f67cf($context, $indent, $value);
        // 'display_library_list' section
        $value = $context->find('display_library_list');
        $buffer .= $this->section40837ce5195d6a35a31141dece49ea2f($context, $indent, $value);
        // 'header_search_bar' section
        $value = $context->find('header_search_bar');
        $buffer .= $this->section037d57456155ed7157365b645b685983($context, $indent, $value);
        $buffer .= $indent . '      <ul id="respMenu" class="ace-responsive-menu" data-menu-style="horizontal">
';
        $buffer .= $indent . '        ';
        $value = $this->resolveValue($context->findDot('output.custom_menu'), $context);
        $buffer .= $value;
        $buffer .= '
';
        if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_navbar_user')) {
            $buffer .= $partial->renderInternal($context, $indent . '        ');
        }
        $buffer .= $indent . '      </ul>
';
        $buffer .= $indent . '      <ul class="sign_up_btn pull-right dn-smd mt20">
';
        if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_navbar_user_popup')) {
            $buffer .= $partial->renderInternal($context, $indent . '        ');
        }
        // 'header_search_icon' section
        $value = $context->find('header_search_icon');
        $buffer .= $this->section747e5e7dfc70af5813e453dcfab8f400($context, $indent, $value);
        $buffer .= $indent . '      </ul><!-- Button trigger modal -->
';
        $buffer .= $indent . '    </nav>
';
        $buffer .= $indent . '  </div>
';
        $buffer .= $indent . '</header>
';

        return $buffer;
    }

    private function sectionF4ae517f1e51da61f377c3a37c32b2b7(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' style="{{{logo_styles}}}" ';
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
                $value = $this->resolveValue($context->find('logo_styles'), $context);
                $buffer .= $value;
                $buffer .= '" ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section399be54e0a94cffcc73da4a2e29a7510(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<img class="logo1 img-fluid" src="{{{headerlogo1}}}{{!output.get_logo_url}}" alt="{{sitename}}" {{#logo_styles}} style="{{{logo_styles}}}" {{/logo_styles}}>';
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
                
                $buffer .= '<img class="logo1 img-fluid" src="';
                $value = $this->resolveValue($context->find('headerlogo1'), $context);
                $buffer .= $value;
                $buffer .= '" alt="';
                $value = $this->resolveValue($context->find('sitename'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '" ';
                // 'logo_styles' section
                $value = $context->find('logo_styles');
                $buffer .= $this->sectionF4ae517f1e51da61f377c3a37c32b2b7($context, $indent, $value);
                $buffer .= '>';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionDf06384b4e759b6b2be9147d409ad885(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<img class="logo2 img-fluid" src="{{{headerlogo2}}}{{!output.get_logo_url}}" alt="{{sitename}}" {{#logo_styles}} style="{{{logo_styles}}}" {{/logo_styles}}>';
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
                
                $buffer .= '<img class="logo2 img-fluid" src="';
                $value = $this->resolveValue($context->find('headerlogo2'), $context);
                $buffer .= $value;
                $buffer .= '" alt="';
                $value = $this->resolveValue($context->find('sitename'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '" ';
                // 'logo_styles' section
                $value = $context->find('logo_styles');
                $buffer .= $this->sectionF4ae517f1e51da61f377c3a37c32b2b7($context, $indent, $value);
                $buffer .= '>';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section675f23d2691a1d78291e2a27c079194a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<span>{{{ sitename }}}</span>';
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
                $buffer .= $value;
                $buffer .= '</span>';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section1289f146621b3c52ef8d1ecac98f67cf(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <a href="{{{ ccnLogoUrl }}}" class="navbar_brand float-left dn-smd">
          {{#logo_image}}<img class="logo1 img-fluid" src="{{{headerlogo1}}}{{!output.get_logo_url}}" alt="{{sitename}}" {{#logo_styles}} style="{{{logo_styles}}}" {{/logo_styles}}>{{/logo_image}}
          {{#logo_image}}<img class="logo2 img-fluid" src="{{{headerlogo2}}}{{!output.get_logo_url}}" alt="{{sitename}}" {{#logo_styles}} style="{{{logo_styles}}}" {{/logo_styles}}>{{/logo_image}}
          {{#logotype}}<span>{{{ sitename }}}</span>{{/logotype}}
        </a>
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
                
                $buffer .= $indent . '        <a href="';
                $value = $this->resolveValue($context->find('ccnLogoUrl'), $context);
                $buffer .= $value;
                $buffer .= '" class="navbar_brand float-left dn-smd">
';
                $buffer .= $indent . '          ';
                // 'logo_image' section
                $value = $context->find('logo_image');
                $buffer .= $this->section399be54e0a94cffcc73da4a2e29a7510($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '          ';
                // 'logo_image' section
                $value = $context->find('logo_image');
                $buffer .= $this->sectionDf06384b4e759b6b2be9147d409ad885($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '          ';
                // 'logotype' section
                $value = $context->find('logotype');
                $buffer .= $this->section675f23d2691a1d78291e2a27c079194a($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '        </a>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section2d7889726863be25ca4e27460768b174(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'library, theme_edumy';
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
                
                $buffer .= 'library, theme_edumy';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section40837ce5195d6a35a31141dece49ea2f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <ul class="mt20 pull-left mr20 ml10">
          <li class="list-inline-item">
            <div class="header_top_lang_widget">
              <div class="ht-widget-container">
                <div class="vertical-wrapper">
                  <h2 class="title-vertical home3">
                    <span class="text-title">{{#str}}library, theme_edumy{{/str}}</span> <i class="fa fa-angle-down show-down" aria-hidden="true"></i>
                  </h2>
                  <div class="content-vertical">
                    {{{ ccn_librarylist }}}
                  </div>
                </div>
              </div>
            </div>
          </li>
        </ul>
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
                
                $buffer .= $indent . '        <ul class="mt20 pull-left mr20 ml10">
';
                $buffer .= $indent . '          <li class="list-inline-item">
';
                $buffer .= $indent . '            <div class="header_top_lang_widget">
';
                $buffer .= $indent . '              <div class="ht-widget-container">
';
                $buffer .= $indent . '                <div class="vertical-wrapper">
';
                $buffer .= $indent . '                  <h2 class="title-vertical home3">
';
                $buffer .= $indent . '                    <span class="text-title">';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section2d7889726863be25ca4e27460768b174($context, $indent, $value);
                $buffer .= '</span> <i class="fa fa-angle-down show-down" aria-hidden="true"></i>
';
                $buffer .= $indent . '                  </h2>
';
                $buffer .= $indent . '                  <div class="content-vertical">
';
                $buffer .= $indent . '                    ';
                $value = $this->resolveValue($context->find('ccn_librarylist'), $context);
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
                $buffer .= $indent . '          </li>
';
                $buffer .= $indent . '        </ul>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section037d57456155ed7157365b645b685983(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <ul class="pull-left mt15 mr20 ml10">
          <li class="list-inline-item dn-1366">
            <div class="ht_search_widget">
              <div class="header_search_widget">
                {{{ccn_globalsearch_navbar}}}
              </div>
            </div>
          </li>
        </ul>
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
                
                $buffer .= $indent . '        <ul class="pull-left mt15 mr20 ml10">
';
                $buffer .= $indent . '          <li class="list-inline-item dn-1366">
';
                $buffer .= $indent . '            <div class="ht_search_widget">
';
                $buffer .= $indent . '              <div class="header_search_widget">
';
                $buffer .= $indent . '                ';
                $value = $this->resolveValue($context->find('ccn_globalsearch_navbar'), $context);
                $buffer .= $value;
                $buffer .= '
';
                $buffer .= $indent . '              </div>
';
                $buffer .= $indent . '            </div>
';
                $buffer .= $indent . '          </li>
';
                $buffer .= $indent . '        </ul>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section747e5e7dfc70af5813e453dcfab8f400(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
          <li class="list-inline-item list_s">
            {{> theme_edumy/ccn_navbar_search_icon }}
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
                
                $buffer .= $indent . '          <li class="list-inline-item list_s">
';
                if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_navbar_search_icon')) {
                    $buffer .= $partial->renderInternal($context, $indent . '            ');
                }
                $buffer .= $indent . '          </li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
