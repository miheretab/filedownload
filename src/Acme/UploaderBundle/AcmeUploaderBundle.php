<?php
// src/Acme/UploaderBundle
namespace Acme\UploaderBundle;
 
use Acme\UploaderBundle\Lib\Globals;
use Symfony\Component\HttpKernel\Bundle\Bundle;
 
class AcmeUploaderBundle extends Bundle
{
    public function boot()
    {
        // Set some static globals 
        Globals::setUploadDir($this->container->getParameter('acme_uploader.upload_dir'));
    }
 
}