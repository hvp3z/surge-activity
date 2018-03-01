<?php

/* loading_spinner.html.twig */
class __TwigTemplate_93994d931151a0b287cb2c8efe4854a3662a949e3d9eaded33ec050a0fb9ee11 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'spinner' => array($this, 'block_spinner'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('spinner', $context, $blocks);
    }

    public function block_spinner($context, array $blocks = array())
    {
        // line 2
        echo "    <link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("css/jquery-loading.min.css"), "html", null, true);
        echo "\">
    <script src=\"";
        // line 3
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/jquery-loading.js"), "html", null, true);
        echo "\"></script>
    <script>
        Spinner = function (elemId) {
            var elemName = '#'+elemId;
            var spinner = null;
            return {
                show : function () {
                    spinner.show();
                },
                hide : function () {
                    spinner.hide();
                },
                destroy : function () {
                    spinner.destroy();
                    spinner = null;
                },
                option: function (key, value) {
                    spinner.option(key, value)
                },
                create : function (options) {
                    var elem = \$(elemName).loading(options);
                    spinner = elem.data().plugin_loading;
                },
                init : function () {
                    spinner.init()
                }
            }
        };
    </script>
";
    }

    public function getTemplateName()
    {
        return "loading_spinner.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  31 => 3,  26 => 2,  20 => 1,);
    }
}
/* {% block spinner %}*/
/*     <link rel="stylesheet" href="{{ asset('css/jquery-loading.min.css') }}">*/
/*     <script src="{{ asset('js/jquery-loading.js') }}"></script>*/
/*     <script>*/
/*         Spinner = function (elemId) {*/
/*             var elemName = '#'+elemId;*/
/*             var spinner = null;*/
/*             return {*/
/*                 show : function () {*/
/*                     spinner.show();*/
/*                 },*/
/*                 hide : function () {*/
/*                     spinner.hide();*/
/*                 },*/
/*                 destroy : function () {*/
/*                     spinner.destroy();*/
/*                     spinner = null;*/
/*                 },*/
/*                 option: function (key, value) {*/
/*                     spinner.option(key, value)*/
/*                 },*/
/*                 create : function (options) {*/
/*                     var elem = $(elemName).loading(options);*/
/*                     spinner = elem.data().plugin_loading;*/
/*                 },*/
/*                 init : function () {*/
/*                     spinner.init()*/
/*                 }*/
/*             }*/
/*         };*/
/*     </script>*/
/* {% endblock %}*/
