<?php

namespace ZesharCRM\Bundle\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ZesharCRMCoreBundle extends Bundle
{
    public function getParent()
    {
        return 'SonataAdminBundle';
    }
}
