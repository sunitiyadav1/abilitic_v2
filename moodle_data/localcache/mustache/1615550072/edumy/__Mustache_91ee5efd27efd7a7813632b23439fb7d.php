<?php

class __Mustache_91ee5efd27efd7a7813632b23439fb7d extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        // 'haspages' section
        $value = $context->find('haspages');
        $buffer .= $this->sectionD94a77bf074387da310029e75ea5a11e($context, $indent, $value);

        return $buffer;
    }

    private function section10a27552023257677ce3fa260b61f9a3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'prev';
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
                
                $buffer .= 'prev';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionCba31ff1149a4de879c004711ddd4e31(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <li class="page-item ccn-page-item-prev">
          <a href="{{url}}" class="page-link" aria-label="Previous">
            <span class="flaticon-left-arrow"></span> {{#str}}prev{{/str}}
          </a>
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
                
                $buffer .= $indent . '        <li class="page-item ccn-page-item-prev">
';
                $buffer .= $indent . '          <a href="';
                $value = $this->resolveValue($context->find('url'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '" class="page-link" aria-label="Previous">
';
                $buffer .= $indent . '            <span class="flaticon-left-arrow"></span> ';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section10a27552023257677ce3fa260b61f9a3($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '          </a>
';
                $buffer .= $indent . '        </li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section91e715112a06794d811658b18cac0c9a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <li class="page-item ccn-page-item-first">
          <a href="{{url}}" class="page-link">{{page}}</a>
        </li>
        <li class="page-item disabled">
          <span class="page-link">&hellip;</a>
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
                
                $buffer .= $indent . '        <li class="page-item ccn-page-item-first">
';
                $buffer .= $indent . '          <a href="';
                $value = $this->resolveValue($context->find('url'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '" class="page-link">';
                $value = $this->resolveValue($context->find('page'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '</a>
';
                $buffer .= $indent . '        </li>
';
                $buffer .= $indent . '        <li class="page-item disabled">
';
                $buffer .= $indent . '          <span class="page-link">&hellip;</a>
';
                $buffer .= $indent . '        </li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5749c750acb0d7477dd5257d00cc6d53(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'active';
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
                
                $buffer .= 'active';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE6922901afa7b60d3ce7403587f8d6c3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{.}}';
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
                
                $value = $this->resolveValue($context->last(), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5d08f03ddf472d777bddede343f67f67(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'currentinparentheses, theme_boost';
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
                
                $buffer .= 'currentinparentheses, theme_boost';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC10dc13ef9142b56d6ff03c51356053e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
              <span class="sr-only">{{#str}}currentinparentheses, theme_boost{{/str}}</span>
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
                
                $buffer .= $indent . '              <span class="sr-only">';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section5d08f03ddf472d777bddede343f67f67($context, $indent, $value);
                $buffer .= '</span>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5eb7ab5a1f3cb585cf9a21bee6dcfc64(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <li class="page-item {{#active}}active{{/active}}">
          <a href="{{#url}}{{.}}{{/url}}{{^url}}#{{/url}}" class="page-link">
            {{page}}
            {{#active}}
              <span class="sr-only">{{#str}}currentinparentheses, theme_boost{{/str}}</span>
            {{/active}}
          </a>
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
                
                $buffer .= $indent . '        <li class="page-item ';
                // 'active' section
                $value = $context->find('active');
                $buffer .= $this->section5749c750acb0d7477dd5257d00cc6d53($context, $indent, $value);
                $buffer .= '">
';
                $buffer .= $indent . '          <a href="';
                // 'url' section
                $value = $context->find('url');
                $buffer .= $this->sectionE6922901afa7b60d3ce7403587f8d6c3($context, $indent, $value);
                // 'url' inverted section
                $value = $context->find('url');
                if (empty($value)) {
                    
                    $buffer .= '#';
                }
                $buffer .= '" class="page-link">
';
                $buffer .= $indent . '            ';
                $value = $this->resolveValue($context->find('page'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '
';
                // 'active' section
                $value = $context->find('active');
                $buffer .= $this->sectionC10dc13ef9142b56d6ff03c51356053e($context, $indent, $value);
                $buffer .= $indent . '          </a>
';
                $buffer .= $indent . '        </li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section2429f3619c106e47d006745a2d84f3c4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <li class="page-item disabled ccn-page-item-last">
          <span class="page-link">&hellip;</a>
        </li>
        <li class="page-item">
          <a href="{{url}}" class="page-link">{{page}}</a>
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
                
                $buffer .= $indent . '        <li class="page-item disabled ccn-page-item-last">
';
                $buffer .= $indent . '          <span class="page-link">&hellip;</a>
';
                $buffer .= $indent . '        </li>
';
                $buffer .= $indent . '        <li class="page-item">
';
                $buffer .= $indent . '          <a href="';
                $value = $this->resolveValue($context->find('url'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '" class="page-link">';
                $value = $this->resolveValue($context->find('page'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '</a>
';
                $buffer .= $indent . '        </li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionBa8bb7b1bb267b8cc98d38fe4bf9f047(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'next';
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
                
                $buffer .= 'next';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section39868c4f28291d33b6285e231727e303(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <li class="page-item ccn-page-item-next">
          <a href="{{url}}" class="page-link" aria-label="Next">
            {{#str}}next{{/str}} <span class="flaticon-right-arrow-1"></span>
          </a>
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
                
                $buffer .= $indent . '        <li class="page-item ccn-page-item-next">
';
                $buffer .= $indent . '          <a href="';
                $value = $this->resolveValue($context->find('url'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '" class="page-link" aria-label="Next">
';
                $buffer .= $indent . '            ';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->sectionBa8bb7b1bb267b8cc98d38fe4bf9f047($context, $indent, $value);
                $buffer .= ' <span class="flaticon-right-arrow-1"></span>
';
                $buffer .= $indent . '          </a>
';
                $buffer .= $indent . '        </li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD94a77bf074387da310029e75ea5a11e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <div class="mbp_pagination">
    <ul class="page_navigation">
      {{#previous}}
        <li class="page-item ccn-page-item-prev">
          <a href="{{url}}" class="page-link" aria-label="Previous">
            <span class="flaticon-left-arrow"></span> {{#str}}prev{{/str}}
          </a>
        </li>
      {{/previous}}
      {{#first}}
        <li class="page-item ccn-page-item-first">
          <a href="{{url}}" class="page-link">{{page}}</a>
        </li>
        <li class="page-item disabled">
          <span class="page-link">&hellip;</a>
        </li>
      {{/first}}
      {{#pages}}
        <li class="page-item {{#active}}active{{/active}}">
          <a href="{{#url}}{{.}}{{/url}}{{^url}}#{{/url}}" class="page-link">
            {{page}}
            {{#active}}
              <span class="sr-only">{{#str}}currentinparentheses, theme_boost{{/str}}</span>
            {{/active}}
          </a>
        </li>
      {{/pages}}
      {{#last}}
        <li class="page-item disabled ccn-page-item-last">
          <span class="page-link">&hellip;</a>
        </li>
        <li class="page-item">
          <a href="{{url}}" class="page-link">{{page}}</a>
        </li>
      {{/last}}
      {{#next}}
        <li class="page-item ccn-page-item-next">
          <a href="{{url}}" class="page-link" aria-label="Next">
            {{#str}}next{{/str}} <span class="flaticon-right-arrow-1"></span>
          </a>
        </li>
      {{/next}}
    </ul>
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
                
                $buffer .= $indent . '  <div class="mbp_pagination">
';
                $buffer .= $indent . '    <ul class="page_navigation">
';
                // 'previous' section
                $value = $context->find('previous');
                $buffer .= $this->sectionCba31ff1149a4de879c004711ddd4e31($context, $indent, $value);
                // 'first' section
                $value = $context->find('first');
                $buffer .= $this->section91e715112a06794d811658b18cac0c9a($context, $indent, $value);
                // 'pages' section
                $value = $context->find('pages');
                $buffer .= $this->section5eb7ab5a1f3cb585cf9a21bee6dcfc64($context, $indent, $value);
                // 'last' section
                $value = $context->find('last');
                $buffer .= $this->section2429f3619c106e47d006745a2d84f3c4($context, $indent, $value);
                // 'next' section
                $value = $context->find('next');
                $buffer .= $this->section39868c4f28291d33b6285e231727e303($context, $indent, $value);
                $buffer .= $indent . '    </ul>
';
                $buffer .= $indent . '  </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
