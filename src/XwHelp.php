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
    public static function msgToJson($message, $isJson = true)
    {
        $trace = debug_backtrace();
        $caller = $trace[0];
        $data = [
            'message' => !empty($message) ? $message : '',
            'file' => !empty($caller['file'])? $caller['file'] : '',
            'line' => !empty($caller['line'])? $caller['line'] : '',
        ];
        if ($isJson) {
            return json_encode($data);
        }
        return $data;
    }
}