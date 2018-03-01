<?php

/* ZesharCRMCoreBundle:Widget:oneMoreActivity.html.twig */
class __TwigTemplate_44906962a018f8d455ff3143e5a5b265841fdfc868805f2e8b6d37560484bb15 extends Twig_Template
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
            </div>
            <h3>My Activities</h3>
        </div>
        <div class=\"custom-content\">
            <table class=\"table-widget\">
                <tr>
                    <th></th>
                    <th></th>
                    <th>Contacted</th>
                    <th>Quoted</th>
                    <th>Sold</th>
                </tr>
                ";
        // line 19
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["activities"]) ? $context["activities"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 20
            echo "                    <tr>
                        <td>";
            // line 21
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "title", array()), "html", null, true);
            echo "</td>
                        ";
            // line 22
            if (($this->getAttribute($context["item"], "allContactedCount", array()) != 0)) {
                // line 23
                echo "                            ";
                $context["percentage"] = sprintf("%.2f", (($this->getAttribute($context["item"], "yesContactedCount", array()) * 100) / $this->getAttribute($context["item"], "allContactedCount", array())));
                // line 24
                echo "                        ";
            } else {
                // line 25
                echo "                            ";
                $context["percentage"] = "0.00";
                // line 26
                echo "                        ";
            }
            // line 27
            echo "                        <td>
                            <div class=\"column-line\">
                                <i data-percent-width=\"";
            // line 29
            echo twig_escape_filter($this->env, (isset($context["percentage"]) ? $context["percentage"] : null), "html", null, true);
            echo "%\" class=\"icon-line icon-widget\"></i>
                            </div>
                        </td>
                        <td>
                            ";
            // line 33
            echo twig_escape_filter($this->env, (isset($context["percentage"]) ? $context["percentage"] : null), "html", null, true);
            echo " %
                        </td>
                        <td>";
            // line 35
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "quoteCount", array()), "html", null, true);
            echo "</td>
                        <td style=\"color: #00a65a\">";
            // line 36
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "soldCount", array()), "html", null, true);
            echo "</td>
                    </tr>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 39
        echo "            </table>
        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "ZesharCRMCoreBundle:Widget:oneMoreActivity.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  99 => 39,  90 => 36,  86 => 35,  81 => 33,  74 => 29,  70 => 27,  67 => 26,  64 => 25,  61 => 24,  58 => 23,  56 => 22,  52 => 21,  49 => 20,  45 => 19,  26 => 2,  20 => 1,);
    }
}
/* {% block widget %}*/
/*     <div class="custom-block">*/
/*         <div class="custom-head clear-fix">*/
/*             <div class="custom-menu">*/
/*                 <button class="up-custom"></button>*/
/*                 <button class="settings-custom"></button>*/
/*             </div>*/
/*             <h3>My Activities</h3>*/
/*         </div>*/
/*         <div class="custom-content">*/
/*             <table class="table-widget">*/
/*                 <tr>*/
/*                     <th></th>*/
/*                     <th></th>*/
/*                     <th>Contacted</th>*/
/*                     <th>Quoted</th>*/
/*                     <th>Sold</th>*/
/*                 </tr>*/
/*                 {% for item in activities %}*/
/*                     <tr>*/
/*                         <td>{{ item.title }}</td>*/
/*                         {% if item.allContactedCount != 0 %}*/
/*                             {% set percentage = '%.2f'|format(item.yesContactedCount*100/item.allContactedCount) %}*/
/*                         {% else %}*/
/*                             {% set percentage = '0.00' %}*/
/*                         {% endif %}*/
/*                         <td>*/
/*                             <div class="column-line">*/
/*                                 <i data-percent-width="{{ percentage  }}%" class="icon-line icon-widget"></i>*/
/*                             </div>*/
/*                         </td>*/
/*                         <td>*/
/*                             {{ percentage }} %*/
/*                         </td>*/
/*                         <td>{{ item.quoteCount }}</td>*/
/*                         <td style="color: #00a65a">{{ item.soldCount }}</td>*/
/*                     </tr>*/
/*                 {% endfor %}*/
/*             </table>*/
/*         </div>*/
/*     </div>*/
/* {% endblock %}*/
/* */
