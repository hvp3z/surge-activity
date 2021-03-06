<?php

/* ZesharCRMCoreBundle::main_menu.html.twig */
class __TwigTemplate_f2531bec201a5150d8fcca89c7360793833524d6e05850ba976bf5c03362827e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("knp_menu.html.twig", "ZesharCRMCoreBundle::main_menu.html.twig", 1);
        $this->blocks = array(
            'list' => array($this, 'block_list'),
            'children' => array($this, 'block_children'),
            'item' => array($this, 'block_item'),
            'linkElement' => array($this, 'block_linkElement'),
            'spanElement' => array($this, 'block_spanElement'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "knp_menu.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 11
    public function block_list($context, array $blocks = array())
    {
        // line 12
        if ((($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "hasChildren", array()) &&  !($this->getAttribute((isset($context["options"]) ? $context["options"] : null), "depth", array()) === 0)) && $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "displayChildren", array()))) {
            // line 13
            echo "    <ul ";
            if (twig_test_empty($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "parent", array()))) {
                echo "class=\"menu\"";
            }
            echo " ";
            echo $this->getAttribute($this, "attributes", array(0 => (isset($context["listAttributes"]) ? $context["listAttributes"] : null)), "method");
            echo ">
        ";
            // line 14
            if (twig_test_empty($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "parent", array()))) {
                echo " ";
                // line 15
                echo "            <li style=\"width: 260px;\">
                <img src=\"";
                // line 16
                echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("images/logo2.png"), "html", null, true);
                echo "\" alt=\"\" width=\"41px\">
                <p class=\"title-logo\">Surge<span>Activity</span></p>
            </li>
        ";
            }
            // line 20
            echo "        ";
            $this->displayBlock("children", $context, $blocks);
            echo "
        ";
            // line 21
            if (twig_test_empty($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "parent", array()))) {
                echo " ";
                // line 22
                echo "            <li>";
                echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('http_kernel')->controller("ZesharCRMCoreBundle:Default:profileInfo"));
                echo "</li>
        ";
            }
            // line 24
            echo "    </ul>
";
        }
    }

    // line 28
    public function block_children($context, array $blocks = array())
    {
        // line 30
        $context["currentOptions"] = (isset($context["options"]) ? $context["options"] : null);
        // line 31
        $context["currentItem"] = (isset($context["item"]) ? $context["item"] : null);
        // line 33
        if ( !(null === $this->getAttribute((isset($context["options"]) ? $context["options"] : null), "depth", array()))) {
            // line 34
            $context["options"] = twig_array_merge((isset($context["currentOptions"]) ? $context["currentOptions"] : null), array("depth" => ($this->getAttribute((isset($context["currentOptions"]) ? $context["currentOptions"] : null), "depth", array()) - 1)));
        }
        // line 36
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["currentItem"]) ? $context["currentItem"] : null), "children", array()));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 37
            echo "    ";
            $this->displayBlock("item", $context, $blocks);
            echo "
";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 40
        $context["item"] = (isset($context["currentItem"]) ? $context["currentItem"] : null);
        // line 41
        $context["options"] = (isset($context["currentOptions"]) ? $context["currentOptions"] : null);
    }

    // line 44
    public function block_item($context, array $blocks = array())
    {
        // line 45
        if ($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "displayed", array())) {
            // line 47
            $context["classes"] = (( !twig_test_empty($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "attribute", array(0 => "class"), "method"))) ? (array(0 => $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "attribute", array(0 => "class"), "method"))) : (array()));
            // line 48
            if ($this->getAttribute((isset($context["matcher"]) ? $context["matcher"] : null), "isCurrent", array(0 => (isset($context["item"]) ? $context["item"] : null)), "method")) {
                // line 49
                $context["classes"] = twig_array_merge((isset($context["classes"]) ? $context["classes"] : null), array(0 => $this->getAttribute((isset($context["options"]) ? $context["options"] : null), "currentClass", array())));
            } elseif ($this->getAttribute(            // line 50
(isset($context["matcher"]) ? $context["matcher"] : null), "isAncestor", array(0 => (isset($context["item"]) ? $context["item"] : null), 1 => $this->getAttribute((isset($context["options"]) ? $context["options"] : null), "matchingDepth", array())), "method")) {
                // line 51
                $context["classes"] = twig_array_merge((isset($context["classes"]) ? $context["classes"] : null), array(0 => $this->getAttribute((isset($context["options"]) ? $context["options"] : null), "ancestorClass", array())));
            }
            // line 53
            if ($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "actsLikeFirst", array())) {
                // line 54
                $context["classes"] = twig_array_merge((isset($context["classes"]) ? $context["classes"] : null), array(0 => $this->getAttribute((isset($context["options"]) ? $context["options"] : null), "firstClass", array())));
            }
            // line 56
            if ($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "actsLikeLast", array())) {
                // line 57
                $context["classes"] = twig_array_merge((isset($context["classes"]) ? $context["classes"] : null), array(0 => $this->getAttribute((isset($context["options"]) ? $context["options"] : null), "lastClass", array())));
            }
            // line 59
            $context["attributes"] = $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "attributes", array());
            // line 60
            if ( !twig_test_empty((isset($context["classes"]) ? $context["classes"] : null))) {
                // line 61
                $context["attributes"] = twig_array_merge((isset($context["attributes"]) ? $context["attributes"] : null), array("class" => twig_join_filter((isset($context["classes"]) ? $context["classes"] : null), " ")));
            }
            // line 64
            echo "    ";
            $context["knp_menu"] = $this;
            // line 65
            echo "    <li";
            echo $context["knp_menu"]->getattributes((isset($context["attributes"]) ? $context["attributes"] : null));
            echo ">
    ";
            // line 67
            if (( !twig_test_empty($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "uri", array())) && ( !$this->getAttribute((isset($context["item"]) ? $context["item"] : null), "current", array()) || $this->getAttribute((isset($context["options"]) ? $context["options"] : null), "currentAsLink", array())))) {
                // line 68
                echo "        ";
                $this->displayBlock("linkElement", $context, $blocks);
            } else {
                // line 70
                echo "        ";
                $this->displayBlock("spanElement", $context, $blocks);
            }
            // line 73
            $context["childrenClasses"] = (( !twig_test_empty($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "childrenAttribute", array(0 => "class"), "method"))) ? (array(0 => $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "childrenAttribute", array(0 => "class"), "method"))) : (array()));
            // line 74
            $context["childrenClasses"] = twig_array_merge((isset($context["childrenClasses"]) ? $context["childrenClasses"] : null), array(0 => ("menu_level_" . $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "level", array()))));
            // line 75
            $context["listAttributes"] = twig_array_merge($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "childrenAttributes", array()), array("class" => twig_join_filter((isset($context["childrenClasses"]) ? $context["childrenClasses"] : null), " ")));
            // line 76
            echo "        ";
            if ($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "hasChildren", array())) {
                // line 77
                echo "            <div class=\"drop-menu\">
                ";
                // line 78
                $this->displayBlock("list", $context, $blocks);
                echo "
            </div>
        ";
            }
            // line 81
            echo "    </li>
";
        }
    }

    // line 85
    public function block_linkElement($context, array $blocks = array())
    {
        echo "<a class=\"";
        if ($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "hasChildren", array())) {
            echo "drop-link ";
        }
        echo twig_escape_filter($this->env, twig_join_filter($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "linkAttributes", array(0 => "class"), "method"), " "), "html", null, true);
        echo "\" href=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "uri", array()), "html", null, true);
        echo "\">";
        $this->displayBlock("label", $context, $blocks);
        echo "</a>";
    }

    // line 86
    public function block_spanElement($context, array $blocks = array())
    {
        echo "<a class=\"";
        if ($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "hasChildren", array())) {
            echo "drop-link ";
        }
        echo twig_escape_filter($this->env, twig_join_filter($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "labelAttributes", array(0 => "class"), "method"), " "), "html", null, true);
        echo "\" href=\"javascript:void(0);\">";
        $this->displayBlock("label", $context, $blocks);
        echo "</a>";
    }

    // line 3
    public function getattributes($__attributes__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "attributes" => $__attributes__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 4
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["attributes"]) ? $context["attributes"] : null));
            foreach ($context['_seq'] as $context["name"] => $context["value"]) {
                // line 5
                if (( !(null === $context["value"]) &&  !($context["value"] === false))) {
                    // line 6
                    echo sprintf(" %s=\"%s\"", $context["name"], ((($context["value"] === true)) ? (twig_escape_filter($this->env, $context["name"])) : (twig_escape_filter($this->env, $context["value"]))));
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['name'], $context['value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    public function getTemplateName()
    {
        return "ZesharCRMCoreBundle::main_menu.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  252 => 6,  250 => 5,  246 => 4,  234 => 3,  221 => 86,  206 => 85,  200 => 81,  194 => 78,  191 => 77,  188 => 76,  186 => 75,  184 => 74,  182 => 73,  178 => 70,  174 => 68,  172 => 67,  167 => 65,  164 => 64,  161 => 61,  159 => 60,  157 => 59,  154 => 57,  152 => 56,  149 => 54,  147 => 53,  144 => 51,  142 => 50,  140 => 49,  138 => 48,  136 => 47,  134 => 45,  131 => 44,  127 => 41,  125 => 40,  108 => 37,  91 => 36,  88 => 34,  86 => 33,  84 => 31,  82 => 30,  79 => 28,  73 => 24,  67 => 22,  64 => 21,  59 => 20,  52 => 16,  49 => 15,  46 => 14,  37 => 13,  35 => 12,  32 => 11,  11 => 1,);
    }
}
/* {% extends 'knp_menu.html.twig' %}*/
/* */
/* {% macro attributes(attributes) %}*/
/* {% for name, value in attributes %}*/
/*     {%- if value is not none and value is not sameas(false) -%}*/
/*         {{- ' %s="%s"'|format(name, value is sameas(true) ? name|e : value|e)|raw -}}*/
/*     {%- endif -%}*/
/* {%- endfor -%}*/
/* {% endmacro %}*/
/* */
/* {% block list %}*/
/* {% if item.hasChildren and options.depth is not sameas(0) and item.displayChildren %}*/
/*     <ul {% if item.parent is empty %}class="menu"{% endif %} {{ _self.attributes(listAttributes) }}>*/
/*         {% if item.parent is empty %} {# only fot root level - output notifications, profile info and "add" button #}*/
/*             <li style="width: 260px;">*/
/*                 <img src="{{ asset('images/logo2.png') }}" alt="" width="41px">*/
/*                 <p class="title-logo">Surge<span>Activity</span></p>*/
/*             </li>*/
/*         {% endif %}*/
/*         {{ block('children') }}*/
/*         {% if item.parent is empty %} {# only fot root level - output notifications, profile info and "add" button #}*/
/*             <li>{{ render(controller('ZesharCRMCoreBundle:Default:profileInfo')) }}</li>*/
/*         {% endif %}*/
/*     </ul>*/
/* {% endif %}*/
/* {% endblock %}*/
/* */
/* {% block children %}*/
/* {# save current variables #}*/
/* {% set currentOptions = options %}*/
/* {% set currentItem = item %}*/
/* {# update the depth for children #}*/
/* {% if options.depth is not none %}*/
/* {% set options = currentOptions|merge({'depth': currentOptions.depth - 1}) %}*/
/* {% endif %}*/
/* {% for item in currentItem.children %}*/
/*     {{ block('item') }}*/
/* {% endfor %}*/
/* {# restore current variables #}*/
/* {% set item = currentItem %}*/
/* {% set options = currentOptions %}*/
/* {% endblock %}*/
/* */
/* {% block item %}*/
/* {% if item.displayed %}*/
/* {# building the class of the item #}*/
/*     {%- set classes = item.attribute('class') is not empty ? [item.attribute('class')] : [] %}*/
/*     {%- if matcher.isCurrent(item) %}*/
/*         {%- set classes = classes|merge([options.currentClass]) %}*/
/*     {%- elseif matcher.isAncestor(item, options.matchingDepth) %}*/
/*         {%- set classes = classes|merge([options.ancestorClass]) %}*/
/*     {%- endif %}*/
/*     {%- if item.actsLikeFirst %}*/
/*         {%- set classes = classes|merge([options.firstClass]) %}*/
/*     {%- endif %}*/
/*     {%- if item.actsLikeLast %}*/
/*         {%- set classes = classes|merge([options.lastClass]) %}*/
/*     {%- endif %}*/
/*     {%- set attributes = item.attributes %}*/
/*     {%- if classes is not empty %}*/
/*         {%- set attributes = attributes|merge({'class': classes|join(' ')}) %}*/
/*     {%- endif %}*/
/* {# displaying the item #}*/
/*     {% import _self as knp_menu %}*/
/*     <li{{ knp_menu.attributes(attributes) }}>*/
/*     {#<li>#}*/
/*         {%- if item.uri is not empty and (not item.current or options.currentAsLink) %}*/
/*         {{ block('linkElement') }}*/
/*         {%- else %}*/
/*         {{ block('spanElement') }}*/
/*         {%- endif %}*/
/* {# render the list of children#}*/
/*         {%- set childrenClasses = item.childrenAttribute('class') is not empty ? [item.childrenAttribute('class')] : [] %}*/
/*         {%- set childrenClasses = childrenClasses|merge(['menu_level_' ~ item.level]) %}*/
/*         {%- set listAttributes = item.childrenAttributes|merge({'class': childrenClasses|join(' ') }) %}*/
/*         {% if item.hasChildren %}*/
/*             <div class="drop-menu">*/
/*                 {{ block('list') }}*/
/*             </div>*/
/*         {% endif %}*/
/*     </li>*/
/* {% endif %}*/
/* {% endblock %}*/
/*     */
/* {% block linkElement %}<a class="{% if item.hasChildren %}drop-link {% endif %}{{ item.linkAttributes('class')|join(' ') }}" href="{{ item.uri }}">{{ block('label') }}</a>{% endblock %}*/
/* {% block spanElement %}<a class="{% if item.hasChildren %}drop-link {% endif %}{{ item.labelAttributes('class')|join(' ') }}" href="javascript:void(0);">{{ block('label') }}</a>{% endblock %}*/
/* */
