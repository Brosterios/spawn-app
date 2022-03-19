<?php

namespace SpawnCore\System\Custom\Gadgets;

use Exception;
use SpawnCore\System\Custom\Response\Exceptions\JsonConvertionException;

class JsonHelper {

    public static function arrayToJson(array $data, bool $throwOnError = true): string {
        try {
            return json_encode($data, JSON_THROW_ON_ERROR);
        }
        catch (JsonConvertionException $exception) {
            if($throwOnError) {
                throw $exception;
            }

            return '["error":"Could not parse data to JSON"]';
        }
    }

    public static function jsonToArray(string $json, bool $throwOnError = true): string {
        try {
            return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        }
        catch (JsonConvertionException $exception) {
            if($throwOnError) {
                throw $exception;
            }
            return '["error":"Could not parse JSON to array"]';
        }
    }

    public static function validateJson(string $json): bool {
        return (bool)json_decode($json, true);
    }


}