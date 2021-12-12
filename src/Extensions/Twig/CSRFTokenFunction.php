<?php

namespace spawnApp\Extensions\Twig;


use spawnCore\Custom\RenderExtensions\Twig\Abstracts\FunctionExtension;

class CSRFTokenFunction extends FunctionExtension {


    protected function getFunctionName(): string
    {
        return 'csrf';
    }

    protected function getFunctionFunction(): callable
    {
        return function(string $purpose) {
            /** @var CSRFTokenAssistant $tokenAssistant */
            $tokenAssistant = ServiceContainerProvider::getServiceContainer()->getServiceInstance('system.csrf_token.helper');
            $token = $tokenAssistant->createToken($purpose);
            return '<input type="hidden" name="csrf" value="'.$token.'" />';
        };
    }

    protected function getFunctionOptions(): array
    {
        return [
            'is_safe' => ['html']
        ];
    }
}