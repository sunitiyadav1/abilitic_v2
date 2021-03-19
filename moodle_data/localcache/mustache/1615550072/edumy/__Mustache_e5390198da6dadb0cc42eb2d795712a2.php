<?php

class __Mustache_e5390198da6dadb0cc42eb2d795712a2 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        // 'cocoon_facebook_url' section
        $value = $context->find('cocoon_facebook_url');
        $buffer .= $this->sectionF689409544657cf6d1b65099ac6dab4f($context, $indent, $value);
        // 'cocoon_twitter_url' section
        $value = $context->find('cocoon_twitter_url');
        $buffer .= $this->sectionD25d3f98992262c38409e12a9852591a($context, $indent, $value);
        // 'cocoon_instagram_url' section
        $value = $context->find('cocoon_instagram_url');
        $buffer .= $this->sectionE65a9c115a1f6a564356244e813b7387($context, $indent, $value);
        // 'cocoon_pinterest_url' section
        $value = $context->find('cocoon_pinterest_url');
        $buffer .= $this->sectionA816738e8b16cd5124a35ee8bd1a3743($context, $indent, $value);
        // 'cocoon_dribbble_url' section
        $value = $context->find('cocoon_dribbble_url');
        $buffer .= $this->section26906e023512d342d9af85a766809ea2($context, $indent, $value);
        // 'cocoon_google_url' section
        $value = $context->find('cocoon_google_url');
        $buffer .= $this->section7b1e17831471f86f357881a1fb45af4b($context, $indent, $value);
        // 'cocoon_youtube_url' section
        $value = $context->find('cocoon_youtube_url');
        $buffer .= $this->sectionB0aa68ef7907920569fb232927199096($context, $indent, $value);
        // 'cocoon_vk_url' section
        $value = $context->find('cocoon_vk_url');
        $buffer .= $this->section2de4d688845824851844720420572a27($context, $indent, $value);
        // 'cocoon_500px_url' section
        $value = $context->find('cocoon_500px_url');
        $buffer .= $this->section6233ecc4b48e855228868b8a41f8cadf($context, $indent, $value);
        // 'cocoon_behance_url' section
        $value = $context->find('cocoon_behance_url');
        $buffer .= $this->section9bc66de4dc39e7283882181b550965ff($context, $indent, $value);
        // 'cocoon_digg_url' section
        $value = $context->find('cocoon_digg_url');
        $buffer .= $this->sectionDf06ba842148c46e00b287a8767da68f($context, $indent, $value);
        // 'cocoon_flickr_url' section
        $value = $context->find('cocoon_flickr_url');
        $buffer .= $this->section4510de26a79077b370a6314599838e83($context, $indent, $value);
        // 'cocoon_foursquare_url' section
        $value = $context->find('cocoon_foursquare_url');
        $buffer .= $this->section0c523f7940934926020ad9d4218b007c($context, $indent, $value);
        // 'cocoon_linkedin_url' section
        $value = $context->find('cocoon_linkedin_url');
        $buffer .= $this->section35313d6201d32730924c0426dfc51173($context, $indent, $value);
        // 'cocoon_medium_url' section
        $value = $context->find('cocoon_medium_url');
        $buffer .= $this->sectionC00d8b085b872a0270dd733f76c1f26c($context, $indent, $value);
        // 'cocoon_meetup_url' section
        $value = $context->find('cocoon_meetup_url');
        $buffer .= $this->sectionCfe2a9ef8d7197f3be30bef64a7d1ee0($context, $indent, $value);
        // 'cocoon_snapchat_url' section
        $value = $context->find('cocoon_snapchat_url');
        $buffer .= $this->section23a0d7ef61a077d0be8b0684e45d6097($context, $indent, $value);
        // 'cocoon_tumblr_url' section
        $value = $context->find('cocoon_tumblr_url');
        $buffer .= $this->section42fe31faaff1c3a37d9e1649f5830ca1($context, $indent, $value);
        // 'cocoon_vimeo_url' section
        $value = $context->find('cocoon_vimeo_url');
        $buffer .= $this->section067d4ce509ced3a8fc02cd2b2ecbdd6a($context, $indent, $value);
        // 'cocoon_wechat_url' section
        $value = $context->find('cocoon_wechat_url');
        $buffer .= $this->sectionAdb01e72f9b2c8ea1b286ce771416438($context, $indent, $value);
        // 'cocoon_whatsapp_url' section
        $value = $context->find('cocoon_whatsapp_url');
        $buffer .= $this->sectionC92ad74f45af70a1d4129c824cad19c3($context, $indent, $value);
        // 'cocoon_wordpress_url' section
        $value = $context->find('cocoon_wordpress_url');
        $buffer .= $this->section99f9ac72b7fc2259e48461736dfe0d80($context, $indent, $value);
        // 'cocoon_weibo_url' section
        $value = $context->find('cocoon_weibo_url');
        $buffer .= $this->sectionA3660e253e6ec1e590d899352949187c($context, $indent, $value);
        // 'cocoon_telegram_url' section
        $value = $context->find('cocoon_telegram_url');
        $buffer .= $this->section39b8213fcc07b1035d65fc48257b17f3($context, $indent, $value);
        // 'cocoon_moodle_url' section
        $value = $context->find('cocoon_moodle_url');
        $buffer .= $this->sectionFf39c915b2068ff91105e054697562ed($context, $indent, $value);
        // 'cocoon_amazon_url' section
        $value = $context->find('cocoon_amazon_url');
        $buffer .= $this->sectionCb8c47ddbd1119cb8dbbb348eb6e53a6($context, $indent, $value);
        // 'cocoon_slideshare_url' section
        $value = $context->find('cocoon_slideshare_url');
        $buffer .= $this->section26ecc074edcc2c1dcfac8262ac3e1876($context, $indent, $value);
        // 'cocoon_soundcloud_url' section
        $value = $context->find('cocoon_soundcloud_url');
        $buffer .= $this->section4591ff5fb97b2d0321906c0545dc4d71($context, $indent, $value);
        // 'cocoon_leanpub_url' section
        $value = $context->find('cocoon_leanpub_url');
        $buffer .= $this->section23dffc2d783567a881e9cf4590babe7f($context, $indent, $value);
        // 'cocoon_xing_url' section
        $value = $context->find('cocoon_xing_url');
        $buffer .= $this->sectionC6758515a4b1794c5538f0de5c8c0a7c($context, $indent, $value);
        // 'cocoon_bitcoin_url' section
        $value = $context->find('cocoon_bitcoin_url');
        $buffer .= $this->sectionFa80bf23606f69b067601db45f4cb1d1($context, $indent, $value);
        // 'cocoon_twitch_url' section
        $value = $context->find('cocoon_twitch_url');
        $buffer .= $this->sectionB4ce84fa2d78e737b39b574986efb6a9($context, $indent, $value);
        // 'cocoon_github_url' section
        $value = $context->find('cocoon_github_url');
        $buffer .= $this->sectionF29380bd56f709990c54d72b61b6c0ab($context, $indent, $value);
        // 'cocoon_gitlab_url' section
        $value = $context->find('cocoon_gitlab_url');
        $buffer .= $this->sectionCad5507b720323788ff0e4cbadab5e02($context, $indent, $value);
        // 'cocoon_forumbee_url' section
        $value = $context->find('cocoon_forumbee_url');
        $buffer .= $this->sectionB252a4af075a275dc297ccc986215383($context, $indent, $value);
        // 'cocoon_trello_url' section
        $value = $context->find('cocoon_trello_url');
        $buffer .= $this->sectionC036b29ec627cda1e7c8d6e15b023407($context, $indent, $value);
        // 'cocoon_weixin_url' section
        $value = $context->find('cocoon_weixin_url');
        $buffer .= $this->sectionEfd47c7c01dc059fc7bc700d056667b3($context, $indent, $value);

        return $buffer;
    }

    private function section0eab6084e945dfe0b2e0627b4cd4caa8(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' {{{ social_target_href }}} ';
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
                
                $buffer .= ' ';
                $value = $this->resolveValue($context->find('social_target_href'), $context);
                $buffer .= $value;
                $buffer .= ' ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF689409544657cf6d1b65099ac6dab4f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_facebook_url }}}"><i class="fa fa-facebook"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_facebook_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-facebook"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD25d3f98992262c38409e12a9852591a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_twitter_url }}}"><i class="fa fa-twitter"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_twitter_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-twitter"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE65a9c115a1f6a564356244e813b7387(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_instagram_url }}}"><i class="fa fa-instagram"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_instagram_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-instagram"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionA816738e8b16cd5124a35ee8bd1a3743(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_pinterest_url }}}"><i class="fa fa-pinterest"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_pinterest_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-pinterest"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section26906e023512d342d9af85a766809ea2(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_dribbble_url }}}"><i class="fa fa-dribbble"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_dribbble_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-dribbble"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section7b1e17831471f86f357881a1fb45af4b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_google_url }}}"><i class="fa fa-google"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_google_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-google"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB0aa68ef7907920569fb232927199096(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_youtube_url }}}"><i class="fa fa-youtube-play"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_youtube_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-youtube-play"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section2de4d688845824851844720420572a27(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_vk_url }}}"><i class="fa fa-vk"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_vk_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-vk"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6233ecc4b48e855228868b8a41f8cadf(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_500px_url }}}"><i class="fa fa-500px"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_500px_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-500px"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9bc66de4dc39e7283882181b550965ff(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_behance_url }}}"><i class="fa fa-behance"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_behance_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-behance"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionDf06ba842148c46e00b287a8767da68f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_digg_url }}}"><i class="fa fa-digg"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_digg_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-digg"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section4510de26a79077b370a6314599838e83(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_flickr_url }}}"><i class="fa fa-flickr"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_flickr_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-flickr"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section0c523f7940934926020ad9d4218b007c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_foursquare_url }}}"><i class="fa fa-foursquare"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_foursquare_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-foursquare"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section35313d6201d32730924c0426dfc51173(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_linkedin_url }}}"><i class="fa fa-linkedin"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_linkedin_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-linkedin"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC00d8b085b872a0270dd733f76c1f26c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_medium_url }}}"><i class="fa fa-medium"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_medium_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-medium"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionCfe2a9ef8d7197f3be30bef64a7d1ee0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_meetup_url }}}"><i class="fa fa-meetup"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_meetup_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-meetup"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section23a0d7ef61a077d0be8b0684e45d6097(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_snapchat_url }}}"><i class="fa fa-snapchat-ghost"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_snapchat_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-snapchat-ghost"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section42fe31faaff1c3a37d9e1649f5830ca1(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_tumblr_url }}}"><i class="fa fa-tumblr"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_tumblr_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-tumblr"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section067d4ce509ced3a8fc02cd2b2ecbdd6a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_vimeo_url }}}"><i class="fa fa-vimeo"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_vimeo_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-vimeo"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionAdb01e72f9b2c8ea1b286ce771416438(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_wechat_url }}}"><i class="fa fa-wechat"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_wechat_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-wechat"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC92ad74f45af70a1d4129c824cad19c3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_whatsapp_url }}}"><i class="fa fa-whatsapp"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_whatsapp_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-whatsapp"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section99f9ac72b7fc2259e48461736dfe0d80(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_wordpress_url }}}"><i class="fa fa-wordpress"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_wordpress_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-wordpress"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionA3660e253e6ec1e590d899352949187c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_weibo_url }}}"><i class="fa fa-weibo"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_weibo_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-weibo"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section39b8213fcc07b1035d65fc48257b17f3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_telegram_url }}}"><i class="fa fa-telegram"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_telegram_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-telegram"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFf39c915b2068ff91105e054697562ed(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_moodle_url }}}"><i class="fa fa-graduation-cap"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_moodle_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-graduation-cap"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionCb8c47ddbd1119cb8dbbb348eb6e53a6(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_amazon_url }}}"><i class="fa fa-amazon"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_amazon_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-amazon"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section26ecc074edcc2c1dcfac8262ac3e1876(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_slideshare_url }}}"><i class="fa fa-slideshare"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_slideshare_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-slideshare"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section4591ff5fb97b2d0321906c0545dc4d71(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_soundcloud_url }}}"><i class="fa fa-soundcloud"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_soundcloud_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-soundcloud"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section23dffc2d783567a881e9cf4590babe7f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_leanpub_url }}}"><i class="fa fa-leanpub"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_leanpub_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-leanpub"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC6758515a4b1794c5538f0de5c8c0a7c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_xing_url }}}"><i class="fa fa-xing"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_xing_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-xing"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFa80bf23606f69b067601db45f4cb1d1(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_bitcoin_url }}}"><i class="fa fa-btc"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_bitcoin_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-btc"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB4ce84fa2d78e737b39b574986efb6a9(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_twitch_url }}}"><i class="fa fa-twitch"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_twitch_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-twitch"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF29380bd56f709990c54d72b61b6c0ab(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_github_url }}}"><i class="fa fa-github"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_github_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-github"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionCad5507b720323788ff0e4cbadab5e02(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_gitlab_url }}}"><i class="fa fa-gitlab"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_gitlab_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-gitlab"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB252a4af075a275dc297ccc986215383(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_forumbee_url }}}"><i class="fa fa-forumbee"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_forumbee_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-forumbee"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC036b29ec627cda1e7c8d6e15b023407(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_trello_url }}}"><i class="fa fa-trello"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_trello_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-trello"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionEfd47c7c01dc059fc7bc700d056667b3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <li class="list-inline-item"><a {{#social_target_href}} {{{ social_target_href }}} {{/social_target_href}} href="{{{ cocoon_weixin_url }}}"><i class="fa fa-weixin"></i></a></li>
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
                
                $buffer .= $indent . '  <li class="list-inline-item"><a ';
                // 'social_target_href' section
                $value = $context->find('social_target_href');
                $buffer .= $this->section0eab6084e945dfe0b2e0627b4cd4caa8($context, $indent, $value);
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('cocoon_weixin_url'), $context);
                $buffer .= $value;
                $buffer .= '"><i class="fa fa-weixin"></i></a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
