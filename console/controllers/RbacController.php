<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\rbac\DbManager;

class RbacController extends Controller
{
    /**
     * Initialize roles
     */
    public function actionInit()
    {
        /** @var DbManager $auth */
        $auth = Yii::$app->authManager;

        // Clear old data
        $auth->removeAll();

        // Define roles
        $roles = ['admin', 'lab', 'doctor', 'nurse', 'finance', 'reception', 'hr', 'pharmacy'];

        foreach ($roles as $roleName) {
            $role = $auth->createRole($roleName);
            $auth->add($role);
            echo "Created role: {$roleName}\n";
        }

        echo "✅ RBAC roles initialized.\n";
    }

    /**
     * Assign role to a user
     * Example: php yii rbac/assign admin 1
     */
    public function actionAssign($roleName, $userId)
    {
        /** @var DbManager $auth */
        $auth = Yii::$app->authManager;

        $role = $auth->getRole($roleName);
        if (!$role) {
            echo "❌ Role '{$roleName}' does not exist.\n";
            return;
        }

        $auth->assign($role, $userId);
        echo "✅ Assigned role '{$roleName}' to user ID {$userId}\n";
    }
}
