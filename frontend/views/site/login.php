<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Login';
?>
<div style="min-height:100vh; display:flex; align-items:center; justify-content:center; background-color:#f4f4f4; padding:20px;">
    <div style="max-width:900px; display:flex; flex-wrap:wrap; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1); overflow:hidden; background:#fff;">

        <!-- Left image -->
        <div style="flex:1; min-width:300px;">
            <img src="/assets/images/HMS background.jpg" style="width:100%; height:100%; object-fit:cover;" alt="Hospital" />
        </div>

        <!-- Login form -->
        <div style="flex:1; padding:40px;">
            <div style="text-align:center; margin-bottom:30px;">
                <img src="/assets/images/logo 2.png" alt="Logo" style="height:80px;">
                <h2>HMS Login</h2>
            </div>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'action' => ['site/login'],
                'method' => 'post',
            ]); ?>

                <!-- Email Field -->
                <?= $form->field($model, 'email')->textInput([
                    'autofocus' => true,
                    'placeholder' => 'Email Address',
                    'class' => 'form-control'
                ])->label(false) ?>

                <!-- Error Summary -->
                <?= $form->errorSummary($model, ['header' => '<p style="color:red;">Please fix the following errors:</p>']) ?>

                <!-- Password Field with Toggle -->
                <div class="form-group" style="position: relative;">
                    <?= $form->field($model, 'password')->passwordInput([
                        'placeholder' => 'Password',
                        'id' => 'password-field',
                        'class' => 'form-control'
                    ])->label(false) ?>
                    <button 
                        type="button" 
                        id="toggle-password" 
                        style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; font-size:1.2em;"
                        aria-label="Toggle password visibility">
                        <i class="bi bi-eye" id="toggle-icon"></i>
                    </button>
                </div>

                <!-- Submit Button -->
                <div style="margin-top:20px;">
                    <?= Html::submitButton('Login', [
                        'class' => 'btn btn-primary w-100',
                        'id' => 'login-btn'
                    ]) ?>
                </div>

                <!-- Forgot Password -->
                <div style="text-align:center; margin-top:15px;">
                    <?= Html::a('Forgot your password?', ['site/request-password-reset'], ['style'=>'text-decoration:none; color:#007bff;']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<!-- Load Bootstrap Icons (for eye icon) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

<script>
function togglePassword() {
    const pw = document.getElementById('password-field');
    const icon = document.getElementById('toggle-icon');
    if (!pw || !icon) return;

    const isPassword = pw.type === 'password';
    pw.type = isPassword ? 'text' : 'password';

    // Update icon
    icon.classList.toggle('bi-eye', !isPassword);
    icon.classList.toggle('bi-eye-slash', isPassword);
}

// On DOM ready
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('login-form');
    const btn = document.getElementById('login-btn');

    if (!form || !btn) return;

    // Use Yii's beforeSubmit (requires jQuery)
    $(form).on('beforeSubmit', function () {
        const originalText = btn.textContent;
        btn.textContent = "Signing In...";
        btn.disabled = true;

        // Auto-unlock after 5s in case of failure
        setTimeout(() => {
            if (btn.disabled && document.contains(btn)) {
                btn.textContent = originalText;
                btn.disabled = false;
            }
        }, 5000);

        return true; // Allow submission
    });

    // Attach toggle event
    document.getElementById('toggle-password').addEventListener('click', togglePassword);
});
</script>