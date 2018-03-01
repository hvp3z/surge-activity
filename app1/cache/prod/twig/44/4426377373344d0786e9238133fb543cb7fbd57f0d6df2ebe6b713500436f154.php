<?php

/* ZesharCRMCoreBundle:Widget:activity.html.twig */
class __TwigTemplate_368a8bb6a2a83eac45546201aa81b0761a36f7ab5e5dba2d938ca3c555d62ed8 extends Twig_Template
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
            <h3>My Calendar <span>Today is ";
        // line 18
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "M d, Y"), "html", null, true);
        echo "</span></h3>
        </div>
        <div class=\"custom-content\">
            <ul class=\"calendar-list\">
                    <li>
                        <h4>Happening today</h4>
                    ";
        // line 24
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["calendarData"]) ? $context["calendarData"] : null), "today", array(), "array"));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 25
            echo "                        <div class=\"calendar-row\">
                            ";
            // line 26
            if ($this->getAttribute($context["item"], "activity", array(), "any", true, true)) {
                // line 27
                echo "                                <a href=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("admin_zesharcrm_core_lead_list", array("filters" => "reset", "filter" => array("leadCampaign" => array("value" => $this->getAttribute($this->getAttribute($context["item"], "activity", array()), "id", array(), "array"))))), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["item"], "activity", array()), "title", array(), "array"), "html", null, true);
                echo "</a>
                                <span class=\"date\">";
                // line 28
                echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($this->getAttribute($context["item"], "activity", array()), "startTime", array(), "array"), "H:i"), "html", null, true);
                echo "
                                    ";
                // line 29
                if (($this->getAttribute($this->getAttribute($context["item"], "activity", array()), "startTime", array(), "array") != $this->getAttribute($this->getAttribute($context["item"], "activity", array()), "endTime", array(), "array"))) {
                    // line 30
                    echo "                                        - ";
                    echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($this->getAttribute($context["item"], "activity", array()), "endTime", array(), "array"), "H:i"), "html", null, true);
                    echo "
                                    ";
                }
                // line 32
                echo "                            </span>
                            ";
            } else {
                // line 34
                echo "                                <a href=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath($this->getAttribute($context["item"], "url", array()), array("id" => $this->getAttribute($context["item"], "lead", array()))), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "firstName", array()), "html", null, true);
                echo " ";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "middleName", array()), "html", null, true);
                echo " ";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "lastName", array()), "html", null, true);
                echo " - ";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "location", array()), "html", null, true);
                echo "</a>
                                <span style=\"font-size:10px;\">(";
                // line 35
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "type", array()), "html", null, true);
                echo ")</span>
                                <span class=\"date\"> ";
                // line 36
                echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($context["item"], "time", array()), "H:i"), "html", null, true);
                echo " </span>
                            ";
            }
            // line 38
            echo "
                        </div>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 41
        echo "                </li>
                <li>
                    <h4>Upcoming events</h4>
                    ";
        // line 44
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["calendarData"]) ? $context["calendarData"] : null), "future", array(), "array"));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 45
            echo "                        <div class=\"calendar-row\">
                            <span class=\"date\">
                                ";
            // line 47
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($context["item"], "time", array()), "d"), "html", null, true);
            echo "
                                <span>";
            // line 48
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($context["item"], "time", array()), "M"), "html", null, true);
            echo "</span>
                            </span>
                            ";
            // line 50
            if ($this->getAttribute($context["item"], "activity", array(), "any", true, true)) {
                // line 51
                echo "                                <a href=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("admin_zesharcrm_core_lead_list", array("filters" => "reset", "filter" => array("leadCampaign" => array("value" => $this->getAttribute($this->getAttribute($context["item"], "activity", array()), "id", array(), "array"))))), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["item"], "activity", array()), "title", array(), "array"), "html", null, true);
                echo "</a>
                                <span class=\"date\">";
                // line 52
                echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($this->getAttribute($context["item"], "activity", array()), "startTime", array(), "array"), "H:i"), "html", null, true);
                echo "
                                    ";
                // line 53
                if (($this->getAttribute($this->getAttribute($context["item"], "activity", array()), "startTime", array(), "array") != $this->getAttribute($this->getAttribute($context["item"], "activity", array()), "endTime", array(), "array"))) {
                    // line 54
                    echo "                                        - ";
                    echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($this->getAttribute($context["item"], "activity", array()), "endTime", array(), "array"), "H:i"), "html", null, true);
                    echo "
                                    ";
                }
                // line 56
                echo "                            </span>
                            ";
            } else {
                // line 58
                echo "                                <a href=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath($this->getAttribute($context["item"], "url", array()), array("id" => $this->getAttribute($context["item"], "lead", array()))), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "firstName", array()), "html", null, true);
                echo " ";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "middleName", array()), "html", null, true);
                echo " ";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "lastName", array()), "html", null, true);
                echo " - ";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "location", array()), "html", null, true);
                echo "</a>
                                <span style=\"font-size:10px;\">(";
                // line 59
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "type", array()), "html", null, true);
                echo ")</span>
                                <span class=\"date\"> ";
                // line 60
                echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($context["item"], "time", array()), "H:i"), "html", null, true);
                echo " </span>
                            ";
            }
            // line 62
            echo "
                        </div>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 65
        echo "                </li>
            </ul>
        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "ZesharCRMCoreBundle:Widget:activity.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  213 => 65,  205 => 62,  200 => 60,  196 => 59,  183 => 58,  179 => 56,  173 => 54,  171 => 53,  167 => 52,  160 => 51,  158 => 50,  153 => 48,  149 => 47,  145 => 45,  141 => 44,  136 => 41,  128 => 38,  123 => 36,  119 => 35,  106 => 34,  102 => 32,  96 => 30,  94 => 29,  90 => 28,  83 => 27,  81 => 26,  78 => 25,  74 => 24,  65 => 18,  62 => 17,  58 => 15,  45 => 13,  41 => 12,  38 => 11,  36 => 10,  26 => 2,  20 => 1,);
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
/*             <h3>My Calendar <span>Today is {{"now"|date('M d, Y')}}</span></h3>*/
/*         </div>*/
/*         <div class="custom-content">*/
/*             <ul class="calendar-list">*/
/*                     <li>*/
/*                         <h4>Happening today</h4>*/
/*                     {% for item in calendarData['today'] %}*/
/*                         <div class="calendar-row">*/
/*                             {% if item.activity is defined %}*/
/*                                 <a href="{{ path('admin_zesharcrm_core_lead_list', {'filters': 'reset', 'filter' : {'leadCampaign' : {'value' : item.activity['id'] } } } ) }}">{{ item.activity['title'] }}</a>*/
/*                                 <span class="date">{{ item.activity['startTime']|date("H:i") }}*/
/*                                     {% if item.activity['startTime'] !=  item.activity['endTime']  %}*/
/*                                         - {{ item.activity['endTime']|date("H:i") }}*/
/*                                     {% endif %}*/
/*                             </span>*/
/*                             {% else %}*/
/*                                 <a href="{{ path(item.url, {'id': item.lead}) }}">{{ item.firstName }} {{ item.middleName }} {{ item.lastName }} - {{ item.location }}</a>*/
/*                                 <span style="font-size:10px;">({{ item.type }})</span>*/
/*                                 <span class="date"> {{ item.time|date("H:i") }} </span>*/
/*                             {% endif %}*/
/* */
/*                         </div>*/
/*                     {% endfor %}*/
/*                 </li>*/
/*                 <li>*/
/*                     <h4>Upcoming events</h4>*/
/*                     {% for item in calendarData['future'] %}*/
/*                         <div class="calendar-row">*/
/*                             <span class="date">*/
/*                                 {{ item.time|date("d") }}*/
/*                                 <span>{{ item.time|date("M") }}</span>*/
/*                             </span>*/
/*                             {% if item.activity is defined %}*/
/*                                 <a href="{{ path('admin_zesharcrm_core_lead_list', {'filters': 'reset', 'filter' : {'leadCampaign' : {'value' : item.activity['id'] } } } ) }}">{{ item.activity['title'] }}</a>*/
/*                                 <span class="date">{{ item.activity['startTime']|date("H:i") }}*/
/*                                     {% if item.activity['startTime'] !=  item.activity['endTime']  %}*/
/*                                         - {{ item.activity['endTime']|date("H:i") }}*/
/*                                     {% endif %}*/
/*                             </span>*/
/*                             {% else %}*/
/*                                 <a href="{{ path(item.url, {'id': item.lead}) }}">{{ item.firstName }} {{ item.middleName }} {{ item.lastName }} - {{ item.location }}</a>*/
/*                                 <span style="font-size:10px;">({{ item.type }})</span>*/
/*                                 <span class="date"> {{ item.time|date("H:i") }} </span>*/
/*                             {% endif %}*/
/* */
/*                         </div>*/
/*                     {% endfor %}*/
/*                 </li>*/
/*             </ul>*/
/*         </div>*/
/*     </div>*/
/* {% endblock %}*/
/* */
