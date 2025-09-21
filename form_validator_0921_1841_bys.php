<?php
// 代码生成时间: 2025-09-21 18:41:09
// FormValidator.php
// 这个类提供了基本的表单数据验证功能

class FormValidator {

    private $errors;
    private $data;

    // 构造函数，初始化数据和错误集合
    public function __construct($data = []) {
        $this->data = $data;
        $this->errors = [];
    }

    // 设置表单数据
    public function setData($data) {
        $this->data = $data;
    }

    // 获取表单数据
    public function getData() {
        return $this->data;
    }

    // 添加错误信息
    private function addError($field, $message) {
        $this->errors[$field][] = $message;
    }

    // 获取错误信息
    public function getErrors() {
        return $this->errors;
    }

    // 验证表单数据
    public function validate() {
        $this->errors = [];
        
        // 验证字段 'username'
        if (empty($this->data['username'])) {
            $this->addError('username', 'Username is required.');
        } elseif (!preg_match('/^[a-zA-Z0-9_]{5,12}$/', $this->data['username'])) {
            $this->addError('username', 'Username must be 5-12 characters long and contain only letters, numbers, or underscores.');
        }

        // 验证字段 'email'
        if (empty($this->data['email'])) {
            $this->addError('email', 'Email is required.');
        } elseif (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->addError('email', 'Invalid email format.');
        }

        // 验证字段 'password'
        if (empty($this->data['password'])) {
            $this->addError('password', 'Password is required.');
        } elseif (strlen($this->data['password']) < 8) {
            $this->addError('password', 'Password must be at least 8 characters long.');
        }

        // 返回验证结果
        return empty($this->errors);
    }
}

// 使用示例

// 假设我们从表单接收到了这些数据
$formData = [
    'username' => 'john_doe',
    'email' => 'johndoe@example.com',
    'password' => 'password123'
];

// 创建表单验证器实例
$validator = new FormValidator($formData);

// 执行验证
if ($validator->validate()) {
    echo 'Validation passed.';
} else {
    // 输出错误信息
    foreach ($validator->getErrors() as $field => $messages) {
        echo "Field: $field
";
        foreach ($messages as $message) {
            echo "- $message
";
        }
    }
}
