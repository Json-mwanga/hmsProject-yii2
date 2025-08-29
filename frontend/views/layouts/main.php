<!-- views/layouts/main.php -->
<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;

AppAsset::register($this);
$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.0/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        /* Sidebar */
        .sidebar {
            width: 280px;
            background: #1a2435;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 1rem;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .sidebar.collapsed {
            width: 60px;
            padding: 1rem 0.5rem;
        }
        .sidebar.collapsed .sidebar-menu,
        .sidebar.collapsed .sidebar-footer,
        .sidebar.collapsed h5 {
            display: none !important;
        }

        /* Sidebar header */
        .sidebar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .sidebar-header h5 {
            margin: 0;
            font-size: 1rem;
        }
        .sidebar-header button {
            background: transparent;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 1.2rem;
        }

        /* Sidebar menu */
        .sidebar-menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 0;
            margin-bottom: 0.5rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        .sidebar-menu-item:hover {
            background-color: rgba(255,255,255,0.1);
        }
        .sidebar-menu-item i {
            margin-right: 0.75rem;
            width: 20px;
        }
        .sidebar-menu-item span {
            font-size: 0.95rem;
        }

        /* Sidebar footer (user info) */
        .sidebar-footer {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        /* Main content */
        .content {
            margin-left: 280px;
            padding: 20px;
            transition: margin-left 0.3s ease;
            flex: 1;
            overflow: hidden;
        }
        .content.sidebar-collapsed {
            margin-left: 60px;
        }
    </style>

<?php if (!Yii::$app->user->isGuest): ?>
  <?php $user = Yii::$app->user->identity; ?>
  <script>
    // Apply saved theme on every page
    const savedTheme = '<?= $user->theme ?? 'system' ?>';
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    if (savedTheme === 'dark' || (savedTheme === 'system' && prefersDark)) {
      document.body.classList.add('dark-mode');
    }
  </script>
<?php endif; ?>    
</head>

<body>
<?php $this->beginBody() ?>

<div class="d-flex">
    <!-- Sidebar -->
    <?php if (isset($this->params['sidebar'])): ?>
        <aside id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <h5>MENU</h5>
                <button id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Sidebar Menu -->
            <div class="sidebar-menu">
                <?php
                try {
                    echo $this->render($this->params['sidebar']);
                } catch (Exception $e) {
                    if (YII_DEBUG) {
                        echo '<div class="p-3 text-danger small">Sidebar not found: ' . $this->params['sidebar'] . '</div>';
                    }
                }
                ?>
            </div>

            <!-- User Footer -->
            <div class="sidebar-footer">
                <?php if (!Yii::$app->user->isGuest): ?>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="sidebarUserMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-2"></i>
                        <strong><?= Html::encode(Yii::$app->user->identity->username ?? 'Guest') ?></strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark shadow" aria-labelledby="sidebarUserMenu">
                        <li><?= Html::a('⚙️ Settings', ['/site/settings'], ['class' => 'dropdown-item']) ?></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><?= Html::a('🚪 Logout', ['/site/logout'], ['data-method' => 'post', 'class' => 'dropdown-item']) ?></li>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </aside>
    <?php endif; ?>

    <!-- Main Content -->
    <div class="content <?= !isset($this->params['sidebar']) ? 'no-sidebar' : '' ?>">
        <!-- Page content -->
        <?= $content ?>
    </div>
</div>


<?php
$this->registerJs("
    $('#sidebarToggle').on('click', function() {
        $('#sidebar').toggleClass('collapsed');
        $('.content').toggleClass('sidebar-collapsed');
    });
");
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
