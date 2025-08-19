<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Login';
?>
<div style="min-height:100vh; display:flex; align-items:center; justify-content:center; background-color:#f4f4f4; padding:20px;">
    <div style="max-width:900px; display:flex; flex-wrap:wrap; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1); overflow:hidden; background:#fff;">
        
        <!-- Left image -->
        <div style="flex:1; min-width:300px;">
            <img src="/assets/images/HMS background.jpg" style="width:100%; height:100%; object-fit:cover;" />
        </div>

        <!-- Login form -->
        <div style="flex:1; padding:40px;">
            <div style="text-align:center; margin-bottom:30px;">
                <img src="/assets/images/logo 2.png" alt="Logo" style="height:80px;">
                <h2>HMS Login</h2>
            </div>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'enableClientValidation' => true,
            ]); ?>

            <?= $form->field($model, 'email')->textInput([
                'autofocus' => true,
                'placeholder' => 'Email Address'
            ]) ?>

            <div style="position:relative;">
                <?= $form->field($model, 'password')->passwordInput([
                    'placeholder' => 'Password',
                    'id' => 'password-field'
                ]) ?>
                <button type="button" onclick="togglePassword()" style="position:absolute; right:10px; top:35px; background:none; border:none; cursor:pointer;">
                    <span id="toggle-icon">👁️</span>
                </button>
            </div>

            <div style="margin-top:20px;">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary w-100', 'id'=>'login-btn']) ?>
            </div>

            <div style="text-align:center; margin-top:15px;">
                <?= Html::a('Forgot your password?', ['site/request-password-reset'], ['style'=>'text-decoration:none;']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const pwField = document.getElementById('password-field');
    const icon = document.getElementById('toggle-icon');
    if (pwField.type === "password") {
        pwField.type = "text";
        icon.textContent = "🙈";
    } else {
        pwField.type = "password";
        icon.textContent = "👁️";
    }
}

// Disable submit button on form submit (loading state)
document.getElementById('login-form').addEventListener('submit', function() {
    document.getElementById('login-btn').disabled = true;
    document.getElementById('login-btn').textContent = "Signing In...";
});
</script>
