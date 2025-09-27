<nav class="sidebar <?= session()->get('sidebar_collapsed') ? 'collapsed' : '' ?>">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <div class="d-flex align-items-center justify-content-between p-4">
            <div class="logo d-flex align-items-center">
                <div class="logo-icon bg-white rounded-circle p-2 me-3">
                    <i class="fas fa-robot text-primary fs-4"></i>
                </div>
                <div class="logo-text">
                    <span class="h5 mb-0 text-white fw-bold">LaFab AI</span>
                    <small class="text-white-50 d-block">Job Posting</small>
                </div>
            </div>
            <button class="btn-close btn-close-white d-lg-none" onclick="closeSidebar()"></button>
        </div>
    </div>

    <!-- User Profile -->
    <div class="user-profile border-bottom border-dark px-4 py-3">
        <div class="d-flex align-items-center">
            <div class="user-avatar bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                <span class="text-white fw-bold fs-5"><?= strtoupper(substr(session()->get('username') ?? 'U', 0, 1)) ?></span>
            </div>
            <div class="user-info">
                <div class="text-white fw-semibold"><?= session()->get('full_name') ?? 'User' ?></div>
                <small class="text-white-50"><?= session()->get('email') ?></small>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <div class="sidebar-menu p-3">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="<?= base_url('dashboard') ?>" class="nav-link text-white d-flex align-items-center px-3 py-3 mb-2 rounded-3 <?= current_url() == base_url('dashboard') ? 'active' : '' ?>">
                    <i class="fas fa-tachometer-alt me-3 fs-5"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="<?= base_url('job-parser') ?>" class="nav-link text-white d-flex align-items-center px-3 py-3 mb-2 rounded-3 <?= current_url() == base_url('job-parser') ? 'active' : '' ?>">
                    <i class="fas fa-plus me-3 fs-5"></i>
                    <span class="menu-text">New Job Post</span>
                    <span class="badge bg-success ms-auto">38</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="<?= base_url('companies') ?>" class="nav-link text-white d-flex align-items-center px-3 py-3 mb-2 rounded-3 <?= current_url() == base_url('companies') ? 'active' : '' ?>">
                    <i class="fas fa-university me-3 fs-5"></i>
                    <span class="menu-text">Company</span>
                    <span class="badge bg-primary ms-auto">12</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="<?= base_url('job-postings') ?>" class="nav-link text-white d-flex align-items-center px-3 py-3 mb-2 rounded-3 <?= current_url() == base_url('job-postings') ? 'active' : '' ?>">
                    <i class="fas fa-briefcase me-3 fs-5"></i>
                    <span class="menu-text">Job Postings</span>
                    <span class="badge bg-success ms-auto">18</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="<?= base_url('ai-assistant') ?>" class="nav-link text-white d-flex align-items-center px-3 py-3 mb-2 rounded-3">
                    <i class="fas fa-robot me-3 fs-5"></i>
                    <span class="menu-text">AI Assistant</span>
                    <span class="badge bg-warning ms-auto">New</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="<?= base_url('analytics') ?>" class="nav-link text-white d-flex align-items-center px-3 py-3 mb-2 rounded-3">
                    <i class="fas fa-chart-bar me-3 fs-5"></i>
                    <span class="menu-text">Analytics</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="<?= base_url('candidates') ?>" class="nav-link text-white d-flex align-items-center px-3 py-3 mb-2 rounded-3">
                    <i class="fas fa-users me-3 fs-5"></i>
                    <span class="menu-text">Candidates</span>
                    <span class="badge bg-info ms-auto">247</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="<?= base_url('templates') ?>" class="nav-link text-white d-flex align-items-center px-3 py-3 mb-2 rounded-3">
                    <i class="fas fa-file-alt me-3 fs-5"></i>
                    <span class="menu-text">Templates</span>
                </a>
            </li>
        </ul>

        <!-- Settings Section -->
        <div class="mt-4 pt-3 border-top border-dark">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="<?= base_url('settings') ?>" class="nav-link text-white d-flex align-items-center px-3 py-3 mb-2 rounded-3">
                        <i class="fas fa-cog me-3 fs-5"></i>
                        <span class="menu-text">Settings</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="<?= base_url('auth/logout') ?>" class="nav-link text-white d-flex align-items-center px-3 py-3 mb-2 rounded-3">
                        <i class="fas fa-sign-out-alt me-3 fs-5"></i>
                        <span class="menu-text">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Sidebar Toggle -->
    <div class="sidebar-footer p-3 border-top border-dark d-none d-lg-block">
        <button class="btn btn-outline-light w-100 sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-chevron-left me-2"></i>
            <span>Collapse Menu</span>
        </button>
    </div>
</nav>

<style>
    .sidebar {
        width: var(--sidebar-width);
        background: var(--gradient-primary);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: fixed;
        height: 100vh;
        z-index: 1000;
        overflow-y: auto;
    }

    .sidebar.collapsed {
        width: var(--sidebar-collapsed);
    }

    .main-content {
        margin-left: var(--sidebar-width);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        width: calc(100% - var(--sidebar-width));
    }

    .sidebar.collapsed ~ .main-content {
        margin-left: var(--sidebar-collapsed);
        width: calc(100% - var(--sidebar-collapsed));
    }

    /* Sidebar Elements */
    .sidebar-header {
        background: rgba(0,0,0,0.1);
    }

    .logo-icon {
        transition: all 0.3s;
    }

    .user-avatar {
        width: 45px;
        height: 45px;
        transition: all 0.3s;
    }

    .sidebar-menu .nav-link {
        transition: all 0.3s;
        border: none;
        background: transparent;
    }

    .sidebar-menu .nav-link:hover {
        background: rgba(255,255,255,0.15) !important;
        transform: translateX(5px);
    }

    .sidebar-menu .nav-link.active {
        background: rgba(255,255,255,0.2) !important;
        border-left: 4px solid var(--warning);
    }

    .sidebar-menu .badge {
        font-size: 0.7em;
        transition: all 0.3s;
    }

    /* Collapsed State */
    .sidebar.collapsed .logo-text,
    .sidebar.collapsed .menu-text,
    .sidebar.collapsed .user-info,
    .sidebar.collapsed .badge,
    .sidebar.collapsed .sidebar-footer span {
        display: none;
    }

    .sidebar.collapsed .logo-icon {
        margin-right: 0;
    }

    .sidebar.collapsed .user-avatar {
        width: 35px;
        height: 35px;
        font-size: 0.8em;
    }

    .sidebar.collapsed .nav-link {
        justify-content: center;
        padding: 1rem !important;
    }

    .sidebar.collapsed .nav-link i {
        margin-right: 0;
        font-size: 1.2em;
    }

    /* Mobile Styles */
    @media (max-width: 991.98px) {
        .sidebar {
            width: 280px;
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar.mobile-open {
            transform: translateX(0);
        }

        .main-content {
            margin-left: 0 !important;
            width: 100%;
        }

        .sidebar-footer {
            display: none;
        }
    }

    /* Scrollbar Styling */
    .sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: rgba(0,0,0,0.1);
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.3);
        border-radius: 3px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255,255,255,0.5);
    }
</style>