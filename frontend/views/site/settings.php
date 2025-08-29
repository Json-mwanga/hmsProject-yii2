<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Settings';
$user = Yii::$app->user->identity;
$username = $user ? $user->username : 'User';
$theme = $user->theme ?? 'system';
$lang = $user->language ?? 'en';
$email = $user->email ?? '';

$languages = [
    'en' => 'English (US)',
    'es' => 'Español',
    'fr' => 'Français',
    'de' => 'Deutsch',
    'it' => 'Italiano',
    'pt' => 'Português',
    'sw' => 'Kiswahili',
    'ru' => 'Русский',
    'zh' => '中文 (简体)',
    'ja' => '日本語',
    'ko' => '한국어',
    'ar' => 'العربية',
    'hi' => 'हिन्दी',
    'bn' => 'বাংলা',
    'th' => 'ภาษาไทย',
    'vi' => 'Tiếng Việt',
];
?>

<style>
/* Modal Styles */
.modal {
  position: fixed;
  z-index: 2000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: white;
  padding: 24px;
  border-radius: 8px;
  width: 400px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.2);
  max-width: 90vw;
}

.modal-content input {
  width: 100%;
  padding: 10px;
  margin: 8px 0;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 14px;
}

.btn-primary {
  background: #007aff;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-primary:hover {
  background: #005edb;
}

:root {
  --bg: #fff;
  --text: #1a1a1a;
  --border: #e5e5e5;
  --primary: #007aff;
  --btn-outline: #d1d5da;
  --danger: #ff3b30;
  --radius: 8px;
  --shadow: 0 4px 6px rgba(0,0,0,0.1);
}

/* Dark Mode */
body.dark-mode {
  --bg: #1c1c1e;
  --text: #fff;
  --text-light: #ccc;
  --border: #333;
}
body {
  background: #f0f0f0;
  margin: 0;
  padding: 0;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
  transition: background 0.3s ease;
}

body, .settings-panel {
  background-color: var(--bg);
  color: var(--text);
}

.settings-modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.3);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.settings-panel {
  width: 700px;
  max-width: 90vw;
  background: var(--bg);
  border-radius: var(--radius);
  box-shadow: var(--shadow);
  overflow: hidden;
  border: 1px solid var(--border);
}

.settings-header {
  padding: 16px 24px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid var(--border);
  font-size: 18px;
  font-weight: 600;
}

.settings-close {
  background: none;
  border: none;
  font-size: 20px;
  cursor: pointer;
  color: var(--text-light);
}

.settings-body {
  display: flex;
  height: calc(100vh - 80px);
}

.settings-sidebar {
  width: 180px;
  background: #f9f9fb;
  border-right: 1px solid var(--border);
  padding: 20px 0;
}

body.dark-mode .settings-sidebar {
  background: #2c2c2e;
  border-right-color: #333;
}

.settings-sidebar ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.settings-sidebar li {
  padding: 12px 16px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
  color: var(--text-light);
  transition: all 0.2s;
}

.settings-sidebar li.active,
.settings-sidebar li:hover {
  background: #f0f3ff;
  color: var(--text);
  border-radius: 6px;
}

body.dark-mode .settings-sidebar li:hover {
  background: #3a3a3c;
}

.settings-content {
  flex: 1;
  padding: 24px;
  overflow-y: auto;
}

.settings-item {
  margin-bottom: 24px;
  padding-bottom: 24px;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.settings-item:last-child {
  border-bottom: none;
}

.settings-item label {
  font-size: 14px;
  font-weight: 500;
  color: var(--text);
}

/* Theme Buttons */
.theme-buttons {
  display: flex;
  gap: 8px;
  background: #f0f3ff;
  border-radius: 20px;
  padding: 4px;
}

body.dark-mode .theme-buttons {
  background: #3a3a3c;
}

.theme-button {
  padding: 6px 12px;
  border: none;
  background: transparent;
  color: #666;
  font-size: 13px;
  cursor: pointer;
  border-radius: 16px;
  transition: all 0.2s;
}

.theme-button.active {
  background: white;
  color: var(--primary);
  font-weight: 500;
}

body.dark-mode .theme-button.active {
  background: #1c1c1e;
}

/* Language Dropdown */
.language-select {
  font-size: 14px;
  color: var(--text);
  background: transparent;
  border: none;
  cursor: pointer;
  padding: 4px;
}

/* Toggle Switch */
.toggle-switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 24px;
}

.toggle-switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  transition: .4s;
  border-radius: 24px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  left: 4px;
  bottom: 3px;
  background-color: white;
  transition: .4s;
  border-radius: 50%;
}

input:checked + .slider {
  background-color: var(--primary);
}

input:checked + .slider:before {
  transform: translateX(26px);
}

/* Buttons */
.btn-outline {
  padding: 8px 16px;
  border: 1px solid var(--btn-outline);
  background: transparent;
  color: var(--text);
  font-size: 14px;
  border-radius: 20px;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-outline:hover {
  background: #f0f3ff;
}

body.dark-mode .btn-outline:hover {
  background: #3a3a3c;
}

.btn-danger {
  padding: 8px 16px;
  border: 1px solid var(--danger);
  background: transparent;
  color: var(--danger);
  font-size: 14px;
  border-radius: 20px;
  cursor: pointer;
  transition: all 0.2s;
}

/* Avatar */
.avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: #007aff;
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  font-weight: bold;
}

.name {
  font-size: 16px;
  font-weight: 500;
  color: var(--text);
}
</style>

<div class="settings-modal">
  <div class="settings-panel">
    <div class="settings-header">
  <h2>Settings</h2>
  <button class="btn-outline" onclick="goBack()">← Back</button>
</div>

    <div class="settings-body">
      <div class="settings-sidebar">
        <ul>
          <!-- <li class="active" data-tab="general">⚙️ General</li> -->
          <li class="active" data-tab="account">👤 Account</li>
          <li data-tab="about">ℹ️ About</li>
        </ul>
      </div>

      <div class="settings-content">
        <!-- GENERAL -->
        <!-- <div id="general" class="settings-tab active">
          <div class="settings-item">
            <label>Theme</label>
            <div class="theme-buttons">
              <button class="theme-button <?= $theme === 'system' ? 'active' : '' ?>" onclick="setTheme('system')">System</button>
              <button class="theme-button <?= $theme === 'dark' ? 'active' : '' ?>" onclick="setTheme('dark')">Dark</button>
              <button class="theme-button <?= $theme === 'light' ? 'active' : '' ?>" onclick="setTheme('light')">Light</button>
            </div>
          </div>

          <div class="settings-item">
            <label>Language</label>
            <select class="language-select" onchange="setLanguage(this.value)">
              <?php foreach ($languages as $code => $name): ?>
                <option value="<?= $code ?>" <?= $lang === $code ? 'selected' : '' ?>><?= $name ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="settings-item">
            <label>Notifications</label>
            <label class="toggle-switch">
              <input type="checkbox" checked>
              <span class="slider"></span>
            </label>
          </div>
        </div> -->

        <!-- ACCOUNT -->
        <div id="account" class="settings-tab" active style="display: block;">
          <div class="settings-item">
            <div style="display: flex; align-items: center; gap: 12px;">
              <div class="avatar"><?= strtoupper(substr($username, 0, 1)) ?></div>
              <span class="name"><?= Html::encode($username) ?></span>
            </div>
            <button class="btn-outline" onclick="openModal('editAccountModal')">Edit account</button>
          </div>

          <div class="settings-item">
            <label>Password management</label>
            <button class="btn-outline" onclick="openModal('changePasswordModal')">Change password</button>
          </div>

          <div class="settings-item">
            <label>Account Management</label>
            <button class="btn-danger" onclick="confirmDelete()">Delete Account</button>
          </div>
        </div>

        <!-- ABOUT -->
        <div id="about" class="settings-tab" style="display:none;">
          <div class="settings-item">
            <label>About</label>
            <button class="btn-outline" onclick="window.location.href='<?= Url::to(['site/about']) ?>'">View About</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modals -->
<div id="editAccountModal" class="modal" style="display:none;">
  <div class="modal-content">
    <h3>Edit Account</h3>
    <form id="editAccountForm">
      <input type="text" id="edit-username" placeholder="Username" value="<?= Html::encode($username) ?>" required>
      <input type="email" id="edit-email" placeholder="Email" value="<?= Html::encode($email) ?>" required>
      <button type="submit" class="btn-primary">Save Changes</button>
      <button type="button" class="btn-outline" onclick="closeModal('editAccountModal')">Cancel</button>
    </form>
  </div>
</div>

<div id="changePasswordModal" class="modal" style="display:none;">
  <div class="modal-content">
    <h3>Change Password</h3>
    <form id="changePasswordForm">
      <input type="password" id="currentPassword" placeholder="Current Password" required>
      <input type="password" id="newPassword" placeholder="New Password" required>
      <input type="password" id="confirmPassword" placeholder="Confirm New Password" required>
      <button type="submit" class="btn-primary">Update Password</button>
      <button type="button" class="btn-outline" onclick="closeModal('changePasswordModal')">Cancel</button>
    </form>
  </div>
</div>

<script>
// Apply theme from DB + system preference
function applyTheme() {
  const savedTheme = '<?= $theme ?>'; // From PHP: user's saved theme
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

  // Remove classes first
  document.body.classList.remove('dark-mode', 'light-mode');

  if (savedTheme === 'dark' || (savedTheme === 'system' && prefersDark)) {
    document.body.classList.add('dark-mode');
  } else if (savedTheme === 'light') {
    document.body.classList.add('light-mode');
  }
}
applyTheme();

// Save theme to DB and apply
function setTheme(theme) {
  fetch('<?= Url::to(['site/set-theme']) ?>', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'theme=' + theme
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      // Update active button
      document.querySelectorAll('.theme-button').forEach(b => b.classList.remove('active'));
      event.target.classList.add('active');
      // Re-apply theme
      applyTheme();
    }
  })
  .catch(err => console.error('Theme save failed:', err));
}

// Save language
function setLanguage(lang) {
  fetch('<?= Url::to(['site/set-language']) ?>', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'language=' + lang
  }).then(r => r.json());
}

// Open Modal
function openModal(id) {
  document.getElementById(id).style.display = 'block';
}

// Close Modal
function closeModal(id) {
  document.getElementById(id).style.display = 'none';
}

// Go back to previous page or fallback to home
function goBack() {
  // Option 1: Try to go back in history
  if (window.history.length > 1) {
    window.history.back();
  } else {
    // Fallback: Redirect to home or dashboard
    window.location.href = '<?= Url::to(['layout/main']) ?>'; // or wherever you want
  }
}

// Save Account
document.getElementById('editAccountForm')?.addEventListener('submit', function(e) {
  e.preventDefault();
  const username = document.getElementById('edit-username').value;
  const email = document.getElementById('edit-email').value;

  fetch('<?= Url::to(['site/update-account']) ?>', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'username=' + encodeURIComponent(username) + '&email=' + encodeURIComponent(email)
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      alert('Account updated!');
      closeModal('editAccountModal');
    } else {
      alert('Error: ' + (data.error || 'Failed to save'));
    }
  });
});

// Change Password
document.getElementById('changePasswordForm')?.addEventListener('submit', function(e) {
  e.preventDefault();
  const current = document.getElementById('currentPassword').value;
  const newPass = document.getElementById('newPassword').value;
  const confirm = document.getElementById('confirmPassword').value;

  if (newPass !== confirm) {
    alert("Passwords don't match!");
    return;
  }

  fetch('<?= Url::to(['site/change-password']) ?>', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'current=' + encodeURIComponent(current) + '&new=' + encodeURIComponent(newPass)
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      alert('Password updated!');
      closeModal('changePasswordModal');
    } else {
      alert('Error: ' + (data.error || 'Wrong current password'));
    }
  });
});

// Delete account
function confirmDelete() {
  if (confirm("Are you sure you want to delete your account? This cannot be undone.")) {
    window.location.href = '<?= Url::to(['site/delete-account']) ?>';
  }
}

// Tab Navigation
document.querySelectorAll('.settings-sidebar li').forEach(item => {
  item.addEventListener('click', function() {
    const tab = this.getAttribute('data-tab');
    document.querySelectorAll('.settings-sidebar li').forEach(li => li.classList.remove('active'));
    this.classList.add('active');
    document.querySelectorAll('.settings-tab').forEach(panel => panel.style.display = 'none');
    document.getElementById(tab).style.display = 'block';
  });
});

// Close Modal
document.querySelector('.settings-close').addEventListener('click', function() {
  document.querySelector('.settings-modal').style.display = 'none';
});
</script>