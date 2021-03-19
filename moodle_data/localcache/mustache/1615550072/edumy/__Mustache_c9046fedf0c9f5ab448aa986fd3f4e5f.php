<?php

class __Mustache_c9046fedf0c9f5ab448aa986fd3f4e5f extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $buffer .= $indent . '
';
        $buffer .= $indent . '<div class="message_input">
';
        $buffer .= $indent . '<div
';
        $buffer .= $indent . '    class="hidden position-relative"
';
        $buffer .= $indent . '    aria-hidden="true"
';
        $buffer .= $indent . '    data-region="view-conversation"
';
        $buffer .= $indent . '    data-enter-to-send="';
        $value = $this->resolveValue($context->findDot('settings.entertosend'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= '"
';
        $buffer .= $indent . '>
';
        $buffer .= $indent . '    <div class="hidden " data-region="content-messages-footer-container">
';
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_conversation_footer_content')) {
            $buffer .= $partial->renderInternal($context, $indent . '        ');
        }
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <div class="hidden " data-region="content-messages-footer-edit-mode-container">
';
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_conversation_footer_edit_mode')) {
            $buffer .= $partial->renderInternal($context, $indent . '        ');
        }
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <div class="hidden " data-region="content-messages-footer-require-contact-container">
';
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_conversation_footer_require_contact')) {
            $buffer .= $partial->renderInternal($context, $indent . '        ');
        }
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <div class="hidden " data-region="content-messages-footer-require-unblock-container">
';
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_conversation_footer_require_unblock')) {
            $buffer .= $partial->renderInternal($context, $indent . '        ');
        }
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <div class="hidden " data-region="content-messages-footer-unable-to-message">
';
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_conversation_footer_unable_to_message')) {
            $buffer .= $partial->renderInternal($context, $indent . '        ');
        }
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <div class="" data-region="placeholder-container">
';
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_conversation_footer_placeholder')) {
            $buffer .= $partial->renderInternal($context, $indent . '        ');
        }
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <div
';
        $buffer .= $indent . '        class="hidden position-absolute"
';
        $buffer .= $indent . '        data-region="confirm-dialogue-container"
';
        $buffer .= $indent . '        style="top: -1px; bottom: 0; right: 0; left: 0; background: rgba(0,0,0,0.3);"
';
        $buffer .= $indent . '    ></div>
';
        $buffer .= $indent . '</div>
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }
}
