<?php
// 代码生成时间: 2025-09-16 18:47:38
// access_control.php
// Zend框架访问权限控制示例

use Zend\Acl\Acl;
use Zend\Acl\Role\GenericRole;
use Zend\Acl\Resource\GenericResource;
use Zend\Permissions\Acl as PermissionsAcl;
use Zend\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\Permissions\Acl\AclFactory;
use Zend\Permissions\Acl\Role\GenericRole as AclRole;
use Zend\Permissions\Acl\Resource\GenericResource as AclResource;

// 定义访问控制类
class AccessControl extends AbstractActionController
{
    private $acl;
    private $role;
    private $resource;

    public function __construct(AclFactory $aclFactory)
    {
        $this->acl = $aclFactory->createAcl();
        $this->role = new AclRole('guest');
        $this->resource = new AclResource('default');
    }

    // 初始化访问控制列表
    private function initAcl()
    {
        // 添加角色
        $this->acl->addRole($this->role);

        // 添加资源
        $this->acl->addResource($this->resource);

        // 设置规则
        $this->acl->deny($this->role, $this->resource, 'delete');
        $this->acl->allow($this->role, $this->resource);
    }

    // 检查是否允许访问
    private function isAllowed($role = null, $resource = null, $privilege = null)
    {
        if (null === $role) {
            $role = $this->role;
        }

        if (null === $resource) {
            $resource = $this->resource;
        }

        if (null === $privilege) {
            return $this->acl->isAllowed($role, $resource);
        } else {
            return $this->acl->isAllowed($role, $resource, $privilege);
        }
    }

    // 实现访问权限控制
    public function accessControlAction()
    {
        try {
            // 初始化访问控制列表
            $this->initAcl();

            // 检查是否允许访问
            if (!$this->isAllowed()) {
                // 抛出异常
                throw new Exception('You do not have permission to access this resource.');
            }

            // 如果允许访问，执行操作
            echo 'Access granted.';
        } catch (Exception $e) {
            // 错误处理
            echo 'Error: ' . $e->getMessage();
        }
    }

    // 事件监听器，用于初始化访问控制
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'accessControlAction'], 100);
    }
}
