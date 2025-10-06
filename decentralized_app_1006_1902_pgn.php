<?php
// 代码生成时间: 2025-10-06 19:02:44
// 引入ZEND框架的自动加载功能
require_once 'vendor/autoload.php';

use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;

// 定义模块类
class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    // 获取自动加载配置
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}

// 创建应用实例
$app = Application::init(include __DIR__ . '/config/application.config.php');

// 运行应用
$app->run();
