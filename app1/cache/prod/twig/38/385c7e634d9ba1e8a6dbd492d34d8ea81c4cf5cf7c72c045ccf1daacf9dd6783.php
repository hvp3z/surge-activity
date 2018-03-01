<?php

/* ZesharCRMCoreBundle:Dashboard:index.html.twig */
class __TwigTemplate_838f453f825b1077ce45169931eb4d7fd85d250a59d5f006a88e0ab38f7dd42a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("::base.html.twig", "ZesharCRMCoreBundle:Dashboard:index.html.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'page_title' => array($this, 'block_page_title'),
            'left_column' => array($this, 'block_left_column'),
            'widget_list' => array($this, 'block_widget_list'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo "Dashboard";
    }

    // line 4
    public function block_page_title($context, array $blocks = array())
    {
        echo "Dashboard";
    }

    // line 6
    public function block_left_column($context, array $blocks = array())
    {
        // line 7
        echo "    <div class=\"table-wrap\" data-url=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "getSchemeAndHttpHost", array(), "method"), "html", null, true);
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "getBaseURL", array(), "method"), "html", null, true);
        echo "\">
        <div class=\"drop\" default_user=\"";
        // line 8
        echo twig_escape_filter($this->env, (isset($context["userName"]) ? $context["userName"] : null), "html", null, true);
        echo "\">
        </div>
    </div>
    ";
        // line 11
        if ( !twig_test_empty((isset($context["persons"]) ? $context["persons"] : null))) {
            // line 12
            echo "        <select class=\"user_data\" style=\"display: none\">
            <option></option>
            ";
            // line 14
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["persons"]) ? $context["persons"] : null));
            foreach ($context['_seq'] as $context["_key"] => $context["person"]) {
                // line 15
                echo "                <option>";
                echo twig_escape_filter($this->env, $this->getAttribute($context["person"], "username", array()), "html", null, true);
                echo "</option>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['person'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 17
            echo "        </select>
    ";
        }
        // line 19
        echo "
    <style>
        .table-wrap .custom-block {
            height: auto!important;
        }
    </style>
";
    }

    // line 27
    public function block_widget_list($context, array $blocks = array())
    {
        // line 28
        echo "    <select class=\"custom-select widget\">
        <option></option>
        ";
        // line 30
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["widgets"]) ? $context["widgets"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["widget"]) {
            // line 31
            echo "        <option name=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["widget"], "title", array()), "html", null, true);
            echo "\" value=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["widget"], "title", array()), "html", null, true);
            echo "\" data_x=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["widget"], "width", array()), "html", null, true);
            echo "\" data_y=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["widget"], "height", array()), "html", null, true);
            echo "\" >";
            echo twig_escape_filter($this->env, $this->getAttribute($context["widget"], "title", array()), "html", null, true);
            echo "</option>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['widget'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 33
        echo "    </select>
";
    }

    // line 36
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 37
        echo "    <link rel=\"stylesheet\" type=\"text/css\"  href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("bundles/zesharcrmcore/css/sonata_fixes.css"), "html", null, true);
        echo "\"  />
";
    }

    // line 39
    public function block_javascripts($context, array $blocks = array())
    {
        // line 40
        echo "    ";
        // line 41
        echo "    <script src=\"https://code.jquery.com/ui/1.10.4/jquery-ui.js\"></script>
    <script src=\"";
        // line 42
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("bundles/zesharcrmcore/js/dashboard.js"), "html", null, true);
        echo "\"></script>
";
    }

    public function getTemplateName()
    {
        return "ZesharCRMCoreBundle:Dashboard:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  144 => 42,  141 => 41,  139 => 40,  136 => 39,  129 => 37,  126 => 36,  121 => 33,  104 => 31,  100 => 30,  96 => 28,  93 => 27,  83 => 19,  79 => 17,  70 => 15,  66 => 14,  62 => 12,  60 => 11,  54 => 8,  48 => 7,  45 => 6,  39 => 4,  33 => 3,  11 => 1,);
    }
}
/* {% extends '::base.html.twig' %}*/
/* */
/* {% block title %}Dashboard{% endblock %}*/
/* {% block page_title %}Dashboard{% endblock %}*/
/* */
/* {% block left_column %}*/
/*     <div class="table-wrap" data-url="{{ app.request.getSchemeAndHttpHost()}}{{ app.request.getBaseURL() }}">*/
/*         <div class="drop" default_user="{{ userName }}">*/
/*         </div>*/
/*     </div>*/
/*     {% if persons is not empty %}*/
/*         <select class="user_data" style="display: none">*/
/*             <option></option>*/
/*             {% for person in persons %}*/
/*                 <option>{{ person.username}}</option>*/
/*             {% endfor %}*/
/*         </select>*/
/*     {% endif %}*/
/* */
/*     <style>*/
/*         .table-wrap .custom-block {*/
/*             height: auto!important;*/
/*         }*/
/*     </style>*/
/* {% endblock %}*/
/* */
/* {% block widget_list %}*/
/*     <select class="custom-select widget">*/
/*         <option></option>*/
/*         {% for widget in widgets %}*/
/*         <option name="{{ widget.title }}" value="{{ widget.title }}" data_x="{{ widget.width }}" data_y="{{ widget.height }}" >{{ widget.title }}</option>*/
/*         {% endfor %}*/
/*     </select>*/
/* {% endblock %}*/
/* */
/* {% block stylesheets %}*/
/*     <link rel="stylesheet" type="text/css"  href="{{ asset('bundles/zesharcrmcore/css/sonata_fixes.css') }}"  />*/
/* {% endblock %}*/
/* {% block javascripts %}*/
/*     {#<script src="http://code.jquery.com/jquery-1.10.2.js"></script>#}*/
/*     <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>*/
/*     <script src="{{ asset('bundles/zesharcrmcore/js/dashboard.js') }}"></script>*/
/* {% endblock %}*/
