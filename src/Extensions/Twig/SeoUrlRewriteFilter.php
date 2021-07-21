<?php

namespace spawnApp\Extensions\Twig;

use spawn\system\Core\Base\Extensions\Twig\FunctionExtension;
use spawn\system\Core\Services\ServiceContainerProvider;
use spawnApp\Models\RewriteUrl;

class SeoUrlRewriteFilter extends FunctionExtension {


    protected function getFunctionName(): string
    {
        return "seo_url";
    }



    protected function getFunctionFunction(): callable
    {
        return function ($controller, $action) {
            $technical_url = "/?controller=$controller&action=$action";
            $dbHelper = ServiceContainerProvider::getServiceContainer()->getServiceInstance('system.database.helper');

            $seo_url = RewriteUrl::findSeoByReplacement($dbHelper, $technical_url);
            return $seo_url;
        };
    }


    protected function getFunctionOptions(): array
    {
        return [
            'needs_context' => false,
        ];
    }
}