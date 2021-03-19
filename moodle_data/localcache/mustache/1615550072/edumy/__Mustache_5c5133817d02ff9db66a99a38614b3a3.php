<?php

class __Mustache_5c5133817d02ff9db66a99a38614b3a3 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $value = $this->resolveValue($context->find('custom_css_dashboard'), $context);
        $buffer .= $indent . $value;
        $buffer .= '
';
        $buffer .= $indent . '<header class="header-nav menu_style_home_one dashbord_pages navbar-scrolltofixed stricky main-menu ';
        // 'disable_stricky_dashboard' section
        $value = $context->find('disable_stricky_dashboard');
        $buffer .= $this->section242d48f18c1c5366815456cf04d4a400($context, $indent, $value);
        $buffer .= '">
';
        $buffer .= $indent . '  <div class="container-fluid">
';
        $buffer .= $indent . '    <nav>
';
        $buffer .= $indent . '      <div class="menu-toggle">
';
        $buffer .= $indent . '        <img class="nav_logo_img img-fluid" src="';
        $value = $this->resolveValue($context->find('headerlogo1'), $context);
        $buffer .= $value;
        $buffer .= '" alt="';
        $value = $this->resolveValue($context->find('sitename'), $context);
        $buffer .= $value;
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
        $buffer .= $this->sectionA3a9ac4bc439565400991354aa55340e($context, $indent, $value);
        // 'display_library_list' section
        $value = $context->find('display_library_list');
        $buffer .= $this->section40837ce5195d6a35a31141dece49ea2f($context, $indent, $value);
        $buffer .= $indent . '      <ul id="respMenu" class="ace-responsive-menu" data-menu-style="horizontal">
';
        $buffer .= $indent . '        ';
        $value = $this->resolveValue($context->findDot('output.custom_menu'), $context);
        $buffer .= $value;
        $buffer .= '
';
        $buffer .= $indent . '      </ul>
';
        if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_navbar_user')) {
            $buffer .= $partial->renderInternal($context, $indent . '      ');
        }
        $buffer .= $indent . '    </nav>
';
        $buffer .= $indent . '  </div>
';
        $buffer .= $indent . '</header>
';
        $buffer .= $indent . '<div id="page" class="stylehome1 h0">
';
        $buffer .= $indent . '  <div class="mobile-menu">
';
        $buffer .= $indent . '    <div class="header stylehome1 dashbord_mobile_logo dashbord_pages">
';
        $buffer .= $indent . '      <div class="main_logo_home2">
';
        $buffer .= $indent . '        <a href="';
        $value = $this->resolveValue($context->find('ccnLogoUrl'), $context);
        $buffer .= $value;
        $buffer .= '" class="mobileBrand">
';
        // 'logo_image' section
        $value = $context->find('logo_image');
        $buffer .= $this->sectionEeeb868f77e66dd85a129eaea31598d5($context, $indent, $value);
        $buffer .= $indent . '          ';
        // 'logotype' section
        $value = $context->find('logotype');
        $buffer .= $this->sectionF9f2d3a9498e7d8c18d9510e8a8d96ee($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '        </a>
';
        $buffer .= $indent . '      </div>
';
        $buffer .= $indent . '      <ul class="menu_bar_home2">
';
        $buffer .= $indent . '        <li class="list-inline-item"></li>
';
        $buffer .= $indent . '        <li class="list-inline-item"><a href="#menu"><span></span></a></li>
';
        $buffer .= $indent . '      </ul>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '  </div><!-- /.mobile-menu -->
';
        $buffer .= $indent . '  <nav id="menu" class="stylehome1">
';
        $buffer .= $indent . '    <ul>
';
        // 'display_library_list' section
        $value = $context->find('display_library_list');
        $buffer .= $this->sectionC637405f66398e85ad681e4c18788226($context, $indent, $value);
        $buffer .= $indent . '      ';
        $value = $this->resolveValue($context->findDot('output.custom_menu'), $context);
        $buffer .= $value;
        $buffer .= '
';
        if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_header_mob_user')) {
            $buffer .= $partial->renderInternal($context, $indent . '      ');
        }
        $buffer .= $indent . '    </ul>
';
        $buffer .= $indent . '  </nav>
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section242d48f18c1c5366815456cf04d4a400(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' ccn_disable_stricky ';
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
                
                $buffer .= ' ccn_disable_stricky ';
                $context->pop();
            }
        }
    
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

    private function section45de0ea296cdd742646586ee6156c200(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<img class="logo1 img-fluid" src="{{{headerlogo2}}}" alt="{{{sitename}}}" {{#logo_styles}} style="{{{logo_styles}}}" {{/logo_styles}}>';
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
                $value = $this->resolveValue($context->find('headerlogo2'), $context);
                $buffer .= $value;
                $buffer .= '" alt="';
                $value = $this->resolveValue($context->find('sitename'), $context);
                $buffer .= $value;
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

    private function section8409a9bbabb89b8225c2c230fe313acf(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<img class="logo2 img-fluid" src="{{{headerlogo2}}}" alt="{{{sitename}}}" {{#logo_styles}} style="{{{logo_styles}}}" {{/logo_styles}}>';
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
                $buffer .= $value;
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

    private function section712834cf257e56c574d9bbac9e97e5d4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{#logo_image}}<img class="logo1 img-fluid" src="{{{headerlogo2}}}" alt="{{{sitename}}}" {{#logo_styles}} style="{{{logo_styles}}}" {{/logo_styles}}>{{/logo_image}}
            {{#logo_image}}<img class="logo2 img-fluid" src="{{{headerlogo2}}}" alt="{{{sitename}}}" {{#logo_styles}} style="{{{logo_styles}}}" {{/logo_styles}}>{{/logo_image}}
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
                
                $buffer .= $indent . '            ';
                // 'logo_image' section
                $value = $context->find('logo_image');
                $buffer .= $this->section45de0ea296cdd742646586ee6156c200($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '            ';
                // 'logo_image' section
                $value = $context->find('logo_image');
                $buffer .= $this->section8409a9bbabb89b8225c2c230fe313acf($context, $indent, $value);
                $buffer .= '
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD1c6fd88587b03d1f479ed52b34cc53d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<img class="logo1 img-fluid" src="{{{headerlogo1}}}" alt="{{{sitename}}}" {{#logo_styles}} style="{{{logo_styles}}}" {{/logo_styles}}>';
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
                $buffer .= $value;
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

    private function sectionFd15dd1fbeb9a14dcaceff18b03fdf78(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<img class="logo2 img-fluid" src="{{{headerlogo1}}}" alt="{{{sitename}}}" {{#logo_styles}} style="{{{logo_styles}}}" {{/logo_styles}}>';
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
                $value = $this->resolveValue($context->find('headerlogo1'), $context);
                $buffer .= $value;
                $buffer .= '" alt="';
                $value = $this->resolveValue($context->find('sitename'), $context);
                $buffer .= $value;
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

    private function sectionA3a9ac4bc439565400991354aa55340e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <a href="{{{ ccnLogoUrl }}}" class="navbar_brand float-left dn-smd">
          {{#dash_header_white}}
            {{#logo_image}}<img class="logo1 img-fluid" src="{{{headerlogo2}}}" alt="{{{sitename}}}" {{#logo_styles}} style="{{{logo_styles}}}" {{/logo_styles}}>{{/logo_image}}
            {{#logo_image}}<img class="logo2 img-fluid" src="{{{headerlogo2}}}" alt="{{{sitename}}}" {{#logo_styles}} style="{{{logo_styles}}}" {{/logo_styles}}>{{/logo_image}}
          {{/dash_header_white}}
          {{^dash_header_white}}
            {{#logo_image}}<img class="logo1 img-fluid" src="{{{headerlogo1}}}" alt="{{{sitename}}}" {{#logo_styles}} style="{{{logo_styles}}}" {{/logo_styles}}>{{/logo_image}}
            {{#logo_image}}<img class="logo2 img-fluid" src="{{{headerlogo1}}}" alt="{{{sitename}}}" {{#logo_styles}} style="{{{logo_styles}}}" {{/logo_styles}}>{{/logo_image}}
          {{/dash_header_white}}
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
                // 'dash_header_white' section
                $value = $context->find('dash_header_white');
                $buffer .= $this->section712834cf257e56c574d9bbac9e97e5d4($context, $indent, $value);
                // 'dash_header_white' inverted section
                $value = $context->find('dash_header_white');
                if (empty($value)) {
                    
                    $buffer .= $indent . '            ';
                    // 'logo_image' section
                    $value = $context->find('logo_image');
                    $buffer .= $this->sectionD1c6fd88587b03d1f479ed52b34cc53d($context, $indent, $value);
                    $buffer .= '
';
                    $buffer .= $indent . '            ';
                    // 'logo_image' section
                    $value = $context->find('logo_image');
                    $buffer .= $this->sectionFd15dd1fbeb9a14dcaceff18b03fdf78($context, $indent, $value);
                    $buffer .= '
';
                }
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

    private function section770fea9bbd35e92bca0b195af379b3b1(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
              <img class="nav_logo_img img-fluid float-left mt20" src="{{{headerlogo_mobile}}}" alt="{{{sitename}}}" {{#logo_styles}} style="{{{logo_styles}}}" {{/logo_styles}}>
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
                
                $buffer .= $indent . '              <img class="nav_logo_img img-fluid float-left mt20" src="';
                $value = $this->resolveValue($context->find('headerlogo_mobile'), $context);
                $buffer .= $value;
                $buffer .= '" alt="';
                $value = $this->resolveValue($context->find('sitename'), $context);
                $buffer .= $value;
                $buffer .= '" ';
                // 'logo_styles' section
                $value = $context->find('logo_styles');
                $buffer .= $this->sectionF4ae517f1e51da61f377c3a37c32b2b7($context, $indent, $value);
                $buffer .= '>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionEeeb868f77e66dd85a129eaea31598d5(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{#headerlogo_mobile}}
              <img class="nav_logo_img img-fluid float-left mt20" src="{{{headerlogo_mobile}}}" alt="{{{sitename}}}" {{#logo_styles}} style="{{{logo_styles}}}" {{/logo_styles}}>
            {{/headerlogo_mobile}}
            {{^headerlogo_mobile}}
              <img class="nav_logo_img img-fluid float-left mt20" src="{{{headerlogo1}}}" alt="{{{sitename}}}" {{#logo_styles}} style="{{{logo_styles}}}" {{/logo_styles}}>
            {{/headerlogo_mobile}}
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
                
                // 'headerlogo_mobile' section
                $value = $context->find('headerlogo_mobile');
                $buffer .= $this->section770fea9bbd35e92bca0b195af379b3b1($context, $indent, $value);
                // 'headerlogo_mobile' inverted section
                $value = $context->find('headerlogo_mobile');
                if (empty($value)) {
                    
                    $buffer .= $indent . '              <img class="nav_logo_img img-fluid float-left mt20" src="';
                    $value = $this->resolveValue($context->find('headerlogo1'), $context);
                    $buffer .= $value;
                    $buffer .= '" alt="';
                    $value = $this->resolveValue($context->find('sitename'), $context);
                    $buffer .= $value;
                    $buffer .= '" ';
                    // 'logo_styles' section
                    $value = $context->find('logo_styles');
                    $buffer .= $this->sectionF4ae517f1e51da61f377c3a37c32b2b7($context, $indent, $value);
                    $buffer .= '>
';
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF9f2d3a9498e7d8c18d9510e8a8d96ee(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<span>{{{sitename}}}</span>';
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

    private function sectionC637405f66398e85ad681e4c18788226(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <li class="ccn_mob_menu_library">
          <a href="#vertical-menu">{{#str}}library, theme_edumy{{/str}} <i class="flaticon-right-arrow"></i></a>
          {{{ ccn_librarylist }}}
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
                
                $buffer .= $indent . '        <li class="ccn_mob_menu_library">
';
                $buffer .= $indent . '          <a href="#vertical-menu">';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section2d7889726863be25ca4e27460768b174($context, $indent, $value);
                $buffer .= ' <i class="flaticon-right-arrow"></i></a>
';
                $buffer .= $indent . '          ';
                $value = $this->resolveValue($context->find('ccn_librarylist'), $context);
                $buffer .= $value;
                $buffer .= '
';
                $buffer .= $indent . '        </li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
