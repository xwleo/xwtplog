<?php

namespace XwTpLog;

use think\facade\Config;
use think\facade\Request;
use think\log\driver\File;
use Ramsey\Uuid\Uuid;

class XwTpLog extends File
{
    public function save(array $log): bool
    {
        //生成uuid
        $uuid = Uuid::uuid4()->toString();

        $destination = $this->getMasterLogFile();

        $path = dirname($destination);
        !is_dir($path) && mkdir($path, 0755, true);

        $project = Config::get('app.project');

        $params = Request::instance()->param();
        $info = [];
        // 日志信息封装
        $time = \DateTime::createFromFormat('0.u00 U', microtime())->setTimezone(new \DateTimeZone(date_default_timezone_get()))->format($this->config['time_format']);
        foreach ($log as $type => $val) {
            $message = [];
            foreach ($val as $msg) {
                $line = 0;
                $file = '';
                $projectName = '';
                $parsed = @json_decode($msg, true);
                if ($parsed != null) {
                    $msg = !empty($parsed['message']) ? $parsed['message'] : '';
                    $line = !empty($parsed['line']) ? $parsed['line'] : '';
                    $file = !empty($parsed['file']) ? $parsed['file'] : '';
                    $project  = !empty($parsed['project']) ? $parsed['project'] : '';
                } else if (!is_string($msg)) {
                    $msg = var_export($msg, true);
                }

                if ($this->config['json']) {
                    $message[] = json_encode(['time' => $time, 'type' => $type, 'project' => $project, 'uuid' => $uuid, 'msg' => $msg, 'line' => $line, 'file' => $file, 'params' => $params], $this->config['json_options']);
                } else {
                    $message[] = sprintf($this->config['format'], $time, $type, $msg);
                }

            }

            if (true === $this->config['apart_level'] || in_array($type, $this->config['apart_level'])) {
                // 独立记录的日志级别
                $filename = $this->getApartLevelFile($path, $type);
                $this->write($message, $filename);
                continue;
            }

            $info[$type] = $message;
        }

        if ($info) {
            return $this->write($info, $destination);
        }

        return true;
    }
}