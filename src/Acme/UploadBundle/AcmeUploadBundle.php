<?php

namespace Acme\UploadBundle;

use Acme\UploadBundle\Lib\Globals;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AcmeUploadBundle extends Bundle
{
    public function boot()
    {
        // Set some static globals 
        Globals::setUploadDir($this->container->getParameter('acme_upload.upload_dir'));
    }
}
