<?php

/* ZesharCRMGoalsBundle:Widget:performance.html.twig */
class __TwigTemplate_f3f1b9d4c469f3fa8d14b8e7187614f46e696761ac6df1e430f232a24b8e23f0 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'widget' => array($this, 'block_widget'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('widget', $context, $blocks);
        // line 32
        $this->displayBlock('javascripts', $context, $blocks);
    }

    // line 1
    public function block_widget($context, array $blocks = array())
    {
        // line 2
        echo "    <div class=\"custom-block\">
        <div class=\"custom-head clear-fix\">
            <div class=\"custom-menu\">
                <button class=\"up-custom\"></button>
                <button class=\"settings-custom\"></button>
                <button class=\"close-custom\"></button>
            </div>
            <div class=\"custom-menu-select\">
                ";
        // line 10
        if ( !twig_test_empty((isset($context["persons"]) ? $context["persons"] : null))) {
            // line 11
            echo "                    <select class=\"user_data\">
                        ";
            // line 12
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["persons"]) ? $context["persons"] : null));
            foreach ($context['_seq'] as $context["_key"] => $context["person"]) {
                // line 13
                echo "                            <option ";
                if (((isset($context["selectedUser"]) ? $context["selectedUser"] : null) == $this->getAttribute($context["person"], "username", array()))) {
                    echo " selected ";
                }
                echo ">";
                echo twig_escape_filter($this->env, $this->getAttribute($context["person"], "username", array()), "html", null, true);
                echo "</option>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['person'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 15
            echo "                    </select>
                ";
        }
        // line 17
        echo "            </div>
            <h3>My performance</h3>
        </div>
        <div class=\"custom-content\">
            ";
        // line 21
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["data"]) ? $context["data"] : null));
        foreach ($context['_seq'] as $context["key"] => $context["value"]) {
            // line 22
            echo "                        <div class=\"wrap-bar\">
                            <div class=\"column-bar\">
                                <i data-percent-height=\"";
            // line 24
            echo twig_escape_filter($this->env, $this->getAttribute($context["value"], "value", array(), "array"), "html", null, true);
            echo "%\" class=\"icon-bar icon-widget\"></i>
                            </div>
                            <div class=\"legend widget-performance-title\" data-hover-title=\"";
            // line 26
            echo twig_escape_filter($this->env, $this->getAttribute($context["value"], "title", array(), "array"), "html", null, true);
            echo "\" data-unhover-title=\"Line ";
            echo twig_escape_filter($this->env, $context["key"], "html", null, true);
            echo "\"><a>Line ";
            echo twig_escape_filter($this->env, $context["key"], "html", null, true);
            echo "</a></div>
                        </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['value'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 29
        echo "        </div>
    </div>
";
    }

    // line 32
    public function block_javascripts($context, array $blocks = array())
    {
        // line 33
        echo "    <script src=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("bundles/zesharcrmgoals/js/widget_performance.js"), "html", null, true);
        echo "\"></script>
";
    }

    public function getTemplateName()
    {
        return "ZesharCRMGoalsBundle:Widget:performance.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  107 => 33,  104 => 32,  98 => 29,  85 => 26,  80 => 24,  76 => 22,  72 => 21,  66 => 17,  62 => 15,  49 => 13,  45 => 12,  42 => 11,  40 => 10,  30 => 2,  27 => 1,  23 => 32,  21 => 1,);
    }
}
/* {% block widget %}*/
/*     <div class="custom-block">*/
/*         <div class="custom-head clear-fix">*/
/*             <div class="custom-menu">*/
/*                 <button class="up-custom"></button>*/
/*                 <button class="settings-custom"></button>*/
/*                 <button class="close-custom"></button>*/
/*             </div>*/
/*             <div class="custom-menu-select">*/
/*                 {% if persons is not empty %}*/
/*                     <select class="user_data">*/
/*                         {% for person in persons %}*/
/*                             <option {% if selectedUser == person.username %} selected {% endif %}>{{ person.username}}</option>*/
/*                         {% endfor %}*/
/*                     </select>*/
/*                 {% endif %}*/
/*             </div>*/
/*             <h3>My performance</h3>*/
/*         </div>*/
/*         <div class="custom-content">*/
/*             {% for key, value in data %}*/
/*                         <div class="wrap-bar">*/
/*                             <div class="column-bar">*/
/*                                 <i data-percent-height="{{ value['value'] }}%" class="icon-bar icon-widget"></i>*/
/*                             </div>*/
/*                             <div class="legend widget-performance-title" data-hover-title="{{ value['title'] }}" data-unhover-title="Line {{ key }}"><a>Line {{ key }}</a></div>*/
/*                         </div>*/
/*             {% endfor %}*/
/*         </div>*/
/*     </div>*/
/* {% endblock %}*/
/* {% block javascripts %}*/
/*     <script src="{{ asset('bundles/zesharcrmgoals/js/widget_performance.js') }}"></script>*/
/* {% endblock %}*/
/* */
