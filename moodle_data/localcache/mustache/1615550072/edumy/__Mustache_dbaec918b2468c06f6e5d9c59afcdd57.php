<?php

class __Mustache_dbaec918b2468c06f6e5d9c59afcdd57 extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $buffer .= $indent . '<div class="row mt10 pb50">
';
        $buffer .= $indent . '  <div class="col-lg-12">
';
        $buffer .= $indent . '    <div class="copyright-widget text-center">
';
        $buffer .= $indent . '      <p class="color-black2">';
        $value = $this->resolveValue($context->find('cocoon_copyright'), $context);
        $buffer .= $value;
        $buffer .= '</p>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '  </div>
';
        $buffer .= $indent . '</div>
';
        $value = $this->resolveValue($context->find('custom_js_dashboard'), $context);
        $buffer .= $indent . $value;
        $buffer .= '
';
        $value = $this->resolveValue($context->findDot('output.standard_end_of_body_html'), $context);
        $buffer .= $indent . $value;
        $buffer .= '
';

        return $buffer;
    }
}
