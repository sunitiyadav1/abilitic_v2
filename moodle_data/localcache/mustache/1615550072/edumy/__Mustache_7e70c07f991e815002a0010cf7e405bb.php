<?php

class __Mustache_7e70c07f991e815002a0010cf7e405bb extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $buffer .= $indent . '<div class="sign_up_modal modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
';
        $buffer .= $indent . '  <div class="modal-dialog modal-dialog-centered" role="document">
';
        $buffer .= $indent . '    <div class="modal-content">
';
        $buffer .= $indent . '      <div class="modal-header">
';
        $buffer .= $indent . '        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
';
        $buffer .= $indent . '      </div>
';
        $buffer .= $indent . '      <div class="tab-content" id="myTabContent">
';
        $buffer .= $indent . '        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home">
';
        $buffer .= $indent . '          <div class="login_form">
';
        if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_loginform')) {
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
        $buffer .= $indent . '</div>
';
        $buffer .= $indent . '<div class="search_overlay" id="ccnSearchOverlayWrap">
';
        $buffer .= $indent . '  <div class="mk-fullscreen-search-overlay" id="mk-search-overlay">
';
        $buffer .= $indent . '    <a href="#" class="mk-fullscreen-close" id="mk-fullscreen-close-button"><i class="fa fa-times"></i></a>
';
        $buffer .= $indent . '    <div id="mk-fullscreen-search-wrapper">
';
        $buffer .= $indent . '      <div id="ccn_mk-fullscreen-search-wrapper">
';
        if ($partial = $this->mustache->loadPartial('theme_edumy/ccn_globalsearch')) {
            $buffer .= $partial->renderInternal($context, $indent . '        ');
        }
        $buffer .= $indent . '      </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '  </div>
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }
}
