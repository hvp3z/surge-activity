<?php

/* ::base.html.twig */
class __TwigTemplate_fde2f6a8b124d8a2948019186f9d1a6f0c284b1ba3628b49ff6e73fe273df674 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'javascripts' => array($this, 'block_javascripts'),
            'spinner' => array($this, 'block_spinner'),
            'body' => array($this, 'block_body'),
            'widget_list' => array($this, 'block_widget_list'),
            'page_title' => array($this, 'block_page_title'),
            'content' => array($this, 'block_content'),
            'left_column' => array($this, 'block_left_column'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!doctype html>
<html>
    <head>
        <meta charset=\"utf-8\">
        <title>SurgeActivity - Dashboard</title>

        <meta name=\"description\" content=\"\" />
        <meta name=\"keywords\" content=\"\" />
        <meta name=\"viewport\" content=\"width=device-width,initial-scale=1\">
        <link rel=\"shortcut icon\" href=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\">
        <link href=\"https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css\" rel=\"stylesheet\">
        <link rel=\"stylesheet\" href=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("css/select2.css"), "html", null, true);
        echo "\">
        <link rel=\"stylesheet\" href=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("css/style.css"), "html", null, true);
        echo "\">
        <!--[if lt IE 9]><link rel=\"stylesheet\" href=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("css/ie_style.css"), "html", null, true);
        echo "\" type=\"text/css\" ><![endif]-->

        <script src=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/jquery-1.9.1.min.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 17
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/jquery-ui-1.10.4.custom.min.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 18
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/select2.min.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 19
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/actions.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 20
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/jquery.timepicker.min.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 21
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/jquery.tablesorter.js"), "html", null, true);
        echo "\"></script>
        <!--[if lt IE 9]><script src=\"";
        // line 22
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/html5shiv.js"), "html", null, true);
        echo "\"></script><![endif]-->
        ";
        // line 23
        $this->displayBlock('javascripts', $context, $blocks);
        // line 24
        echo "
        ";
        // line 25
        if (( !array_key_exists("pageTitle", $context) &&  !array_key_exists("activityName", $context))) {
            // line 26
            echo "            <script>
                \$(function() {
                    document.title = document.title.replace('Admin', 'SurgeActivity');
                });
            </script>
        ";
        }
        // line 32
        echo "    </head>
    ";
        // line 33
        $this->displayBlock('spinner', $context, $blocks);
        // line 36
        echo "    ";
        $this->displayBlock('body', $context, $blocks);
        // line 70
        echo "</html>
";
    }

    // line 23
    public function block_javascripts($context, array $blocks = array())
    {
    }

    // line 33
    public function block_spinner($context, array $blocks = array())
    {
        // line 34
        echo "        ";
        $this->loadTemplate("loading_spinner.html.twig", "::base.html.twig", 34)->display($context);
        // line 35
        echo "    ";
    }

    // line 36
    public function block_body($context, array $blocks = array())
    {
        // line 37
        echo "        <body>
            <div class=\"wrapper\">
                <header>
                    <div class=\"menu-wrap\">
                        ";
        // line 41
        echo $this->env->getExtension('knp_menu')->render("main", array("template" => "ZesharCRMCoreBundle::main_menu.html.twig"));
        echo "
                    </div>
                    <div class=\"title-wrap\">
                        ";
        // line 44
        $this->displayBlock('widget_list', $context, $blocks);
        // line 45
        echo "                        <h1>";
        $this->displayBlock('page_title', $context, $blocks);
        echo "</h1>
                    </div>
                </header>

                <div class=\"content clear-fix\">
                    ";
        // line 50
        $this->displayBlock('content', $context, $blocks);
        // line 60
        echo "                </div>

            </div>
            <footer>
                <p class=\"title-logo\">Surge<span>Activity</span></p>
                <p class=\"copy-left\">&copy; ";
        // line 65
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y"), "html", null, true);
        echo " Zeshar</p>
                <p class=\"copy-right\">Powered By Zesharcrm</p>
            </footer>
        </body>
    ";
    }

    // line 44
    public function block_widget_list($context, array $blocks = array())
    {
    }

    // line 45
    public function block_page_title($context, array $blocks = array())
    {
    }

    // line 50
    public function block_content($context, array $blocks = array())
    {
        // line 51
        echo "                        <div class=\"right-column\">
                                <div class=\"widget-wrap\">
                                    ";
        // line 53
        echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('http_kernel')->controller("ZesharCRMCoreBundle:Dashboard:showBlockWidget"));
        echo "
                                </div>
                        </div>
                        <div class=\"left-column\">
                            ";
        // line 57
        $this->displayBlock('left_column', $context, $blocks);
        // line 58
        echo "                        </div>
                    ";
    }

    // line 57
    public function block_left_column($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "::base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  201 => 57,  196 => 58,  194 => 57,  187 => 53,  183 => 51,  180 => 50,  175 => 45,  170 => 44,  161 => 65,  154 => 60,  152 => 50,  143 => 45,  141 => 44,  135 => 41,  129 => 37,  126 => 36,  122 => 35,  119 => 34,  116 => 33,  111 => 23,  106 => 70,  103 => 36,  101 => 33,  98 => 32,  90 => 26,  88 => 25,  85 => 24,  83 => 23,  79 => 22,  75 => 21,  71 => 20,  67 => 19,  63 => 18,  59 => 17,  55 => 16,  50 => 14,  46 => 13,  42 => 12,  37 => 10,  26 => 1,);
    }
}
/* <!doctype html>*/
/* <html>*/
/*     <head>*/
/*         <meta charset="utf-8">*/
/*         <title>SurgeActivity - Dashboard</title>*/
/* */
/*         <meta name="description" content="" />*/
/*         <meta name="keywords" content="" />*/
/*         <meta name="viewport" content="width=device-width,initial-scale=1">*/
/*         <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">*/
/*         <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">*/
/*         <link rel="stylesheet" href="{{ asset('css/select2.css') }}">*/
/*         <link rel="stylesheet" href="{{ asset('css/style.css') }}">*/
/*         <!--[if lt IE 9]><link rel="stylesheet" href="{{ asset('css/ie_style.css') }}" type="text/css" ><![endif]-->*/
/* */
/*         <script src="{{ asset('js/jquery-1.9.1.min.js') }}"></script>*/
/*         <script src="{{ asset('js/jquery-ui-1.10.4.custom.min.js') }}"></script>*/
/*         <script src="{{ asset('js/select2.min.js') }}"></script>*/
/*         <script src="{{ asset('js/actions.js') }}"></script>*/
/*         <script src="{{ asset('js/jquery.timepicker.min.js') }}"></script>*/
/*         <script src="{{ asset('js/jquery.tablesorter.js')}}"></script>*/
/*         <!--[if lt IE 9]><script src="{{ asset('js/html5shiv.js') }}"></script><![endif]-->*/
/*         {% block javascripts %}{% endblock %}*/
/* */
/*         {% if (pageTitle is not defined) and (activityName is not defined) %}*/
/*             <script>*/
/*                 $(function() {*/
/*                     document.title = document.title.replace('Admin', 'SurgeActivity');*/
/*                 });*/
/*             </script>*/
/*         {% endif %}*/
/*     </head>*/
/*     {% block spinner %}*/
/*         {% include 'loading_spinner.html.twig' %}*/
/*     {% endblock %}*/
/*     {% block body %}*/
/*         <body>*/
/*             <div class="wrapper">*/
/*                 <header>*/
/*                     <div class="menu-wrap">*/
/*                         {{ knp_menu_render('main', {'template': 'ZesharCRMCoreBundle::main_menu.html.twig'}) }}*/
/*                     </div>*/
/*                     <div class="title-wrap">*/
/*                         {% block widget_list %}{% endblock %}*/
/*                         <h1>{% block page_title %}{% endblock %}</h1>*/
/*                     </div>*/
/*                 </header>*/
/* */
/*                 <div class="content clear-fix">*/
/*                     {% block content %}*/
/*                         <div class="right-column">*/
/*                                 <div class="widget-wrap">*/
/*                                     {{ render(controller('ZesharCRMCoreBundle:Dashboard:showBlockWidget')) }}*/
/*                                 </div>*/
/*                         </div>*/
/*                         <div class="left-column">*/
/*                             {% block left_column %}{% endblock %}*/
/*                         </div>*/
/*                     {% endblock %}*/
/*                 </div>*/
/* */
/*             </div>*/
/*             <footer>*/
/*                 <p class="title-logo">Surge<span>Activity</span></p>*/
/*                 <p class="copy-left">&copy; {{ "now"|date("Y") }} Zeshar</p>*/
/*                 <p class="copy-right">Powered By Zesharcrm</p>*/
/*             </footer>*/
/*         </body>*/
/*     {% endblock %}*/
/* </html>*/
/* */
