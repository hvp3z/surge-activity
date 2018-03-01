<?php

/* ZesharCRMGoalsBundle:Widget:need.html.twig */
class __TwigTemplate_eac4a19f6b40351b010e8b860d684074c2f5acd26f55c0ff982612805050631c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'widget' => array($this, 'block_widget'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('widget', $context, $blocks);
    }

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
            <h3>My SurgePoint</h3>
        </div>
        <div class=\"custom-content\">
            ";
        // line 21
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["data"]) ? $context["data"] : null));
        foreach ($context['_seq'] as $context["key"] => $context["value"]) {
            // line 22
            echo "                ";
            $context["percent"] = ($this->getAttribute($context["value"], "percent", array()) * sprintf(100, 0));
            // line 23
            echo "                ";
            if (((isset($context["percent"]) ? $context["percent"] : null) > 100)) {
                // line 24
                echo "                    ";
                $context["percent"] = 100;
                // line 25
                echo "                ";
            }
            // line 26
            echo "                <div class=\"wrap-battery\">
                    ";
            // line 27
            $context["count"] = (((twig_number_format_filter($this->env, $this->getAttribute($context["value"], "count", array())) > 0)) ? (twig_number_format_filter($this->env, $this->getAttribute($context["value"], "count", array()))) : (0));
            // line 28
            echo "                    <div class=\"value-battery\">";
            echo twig_escape_filter($this->env, (isset($context["count"]) ? $context["count"] : null), "html", null, true);
            echo "</div>
                    <div class=\"column-battery\">
                        <i data-percent-height=\"";
            // line 30
            echo twig_escape_filter($this->env, (isset($context["percent"]) ? $context["percent"] : null), "html", null, true);
            echo "%\" data-color=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["value"], "color", array()), "html", null, true);
            echo "\" class=\"icon-battery icon-widget\"></i>
                    </div>
                    <div class=\"legend\">";
            // line 32
            echo twig_escape_filter($this->env, $context["key"], "html", null, true);
            echo "</div>
                </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['value'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 35
        echo "        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "ZesharCRMGoalsBundle:Widget:need.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  111 => 35,  102 => 32,  95 => 30,  89 => 28,  87 => 27,  84 => 26,  81 => 25,  78 => 24,  75 => 23,  72 => 22,  68 => 21,  62 => 17,  58 => 15,  45 => 13,  41 => 12,  38 => 11,  36 => 10,  26 => 2,  20 => 1,);
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
/*             <h3>My SurgePoint</h3>*/
/*         </div>*/
/*         <div class="custom-content">*/
/*             {% for key, value in data %}*/
/*                 {% set percent = value.percent*100|format(0) %}*/
/*                 {% if percent > 100 %}*/
/*                     {% set percent = 100 %}*/
/*                 {% endif %}*/
/*                 <div class="wrap-battery">*/
/*                     {% set count = value.count|number_format > 0 ? value.count|number_format : 0 %}*/
/*                     <div class="value-battery">{{ count }}</div>*/
/*                     <div class="column-battery">*/
/*                         <i data-percent-height="{{ percent }}%" data-color="{{ value.color }}" class="icon-battery icon-widget"></i>*/
/*                     </div>*/
/*                     <div class="legend">{{ key }}</div>*/
/*                 </div>*/
/*             {% endfor %}*/
/*         </div>*/
/*     </div>*/
/* {% endblock %}*/
/* */
