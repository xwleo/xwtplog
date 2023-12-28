<?php

namespace XwTpLog;

class XwHelp
{
    //处理Exception为简单格式。
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

    //模擬處理data轉json
    public static function dataToJson($data, $isJson = true)
    {
        $data = [
            'code' => !empty($data['code']) ? $data['code'] : 0,
            'message' => !empty($data['message']) ? $data['message'] : '',
            'file' => !empty($data['file']) ? $data['file'] : '',
            'line' => !empty($data['line']) ? $data['line'] : 0,
        ];
        if ($isJson) {
            return json_encode($data);
        }

        return $data;
    }
}