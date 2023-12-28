<?php

namespace XwTpLog;

class XwHelp
{
    //处理Exception为简单格式
    public static function exceptionToJson($e, $isJson = true)
    {
        $data = [
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ];
        if ($isJson) {
            return json_encode($data);
        }
        return $data;

    }
}