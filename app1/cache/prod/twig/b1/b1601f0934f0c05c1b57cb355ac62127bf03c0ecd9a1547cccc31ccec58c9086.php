<?php

/* ZesharCRMCoreBundle:Default:profile-info.html.twig */
class __TwigTemplate_f7aae88a32765c0b629da1cfb089325ba724e1303830535dd3ff91fde8cf949f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<a class=\"drop-link acc-menu\" href=\"#\"><img src=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("pict/menu-acc.png"), "html", null, true);
        echo "\" alt=\"\"></a>
<div class=\"drop-menu\">
    <ul>
        <li><a class=\"disable\" href=\"javascript:void(0);\">";
        // line 4
        echo twig_escape_filter($this->env, (isset($context["username"]) ? $context["username"] : null), "html", null, true);
        echo "</a></li>
        <li><a href=\"";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "baseUrl", array()), "html", null, true);
        echo "/admin/logout\">Logout</a></li>
    </ul>
</div>
";
    }

    public function getTemplateName()
    {
        return "ZesharCRMCoreBundle:Default:profile-info.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  30 => 5,  26 => 4,  19 => 1,);
    }
}
/* <a class="drop-link acc-menu" href="#"><img src="{{ asset('pict/menu-acc.png') }}" alt=""></a>*/
/* <div class="drop-menu">*/
/*     <ul>*/
/*         <li><a class="disable" href="javascript:void(0);">{{ username }}</a></li>*/
/*         <li><a href="{{ app.request.baseUrl }}/admin/logout">Logout</a></li>*/
/*     </ul>*/
/* </div>*/
/* */
