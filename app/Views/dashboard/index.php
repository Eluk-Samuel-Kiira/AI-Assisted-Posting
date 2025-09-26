<?= $this->extend('layouts/dashboard_layout') ?>

<?= $this->section('title') ?>Dashboard - LaFab AI Posting<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Mobile Header -->
<div class="d-lg-none bg-primary text-white p-3">
    <div class="d-flex align-items-center">
        <button class="btn btn-light me-3" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <div>
            <h5 class="mb-0">Dashboard</h5>
            <small>Welcome back, <?= session()->get('full_name') ?? 'User' ?></small>
        </div>
    </div>
</div>

<!-- Desktop Header -->
<div class="content-header bg-white shadow-sm d-none d-lg-block">
    <div class="container-fluid py-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h2 mb-1 text-primary">Dashboard Overview</h1>
                <p class="text-muted mb-0">Welcome back, <?= session()->get('full_name') ?? 'User' ?>! Here's your AI-powered hiring insights.</p>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary sidebar-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars me-2"></i>
                    <span>Menu</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container-fluid py-4">
    <!-- Statistics Cards -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-lg-6">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-muted text-uppercase fw-semibold small">Active Jobs</h6>
                            <h2 class="text-primary mb-2 fw-bold">18</h2>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success bg-opacity-10 text-success small">
                                    <i class="fas fa-arrow-up me-1"></i>12.5%
                                </span>
                                <span class="text-muted small ms-2">from last month</span>
                            </div>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-briefcase fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-muted text-uppercase fw-semibold small">Applications</h6>
                            <h2 class="text-success mb-2 fw-bold">247</h2>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success bg-opacity-10 text-success small">
                                    <i class="fas fa-arrow-up me-1"></i>23.1%
                                </span>
                                <span class="text-muted small ms-2">from last month</span>
                            </div>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-users fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-muted text-uppercase fw-semibold small">AI Optimized</h6>
                            <h2 class="text-warning mb-2 fw-bold">42</h2>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success bg-opacity-10 text-success small">
                                    <i class="fas fa-arrow-up me-1"></i>8.3%
                                </span>
                                <span class="text-muted small ms-2">from last month</span>
                            </div>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-robot fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-muted text-uppercase fw-semibold small">Success Rate</h6>
                            <h2 class="text-info mb-2 fw-bold">89%</h2>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success bg-opacity-10 text-success small">
                                    <i class="fas fa-arrow-up me-1"></i>5.2%
                                </span>
                                <span class="text-muted small ms-2">from last month</span>
                            </div>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-chart-line fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="card-title mb-0 text-dark">Applications Trend</h5>
                    <p class="text-muted small mb-0">Monthly application growth analysis</p>
                </div>
                <div class="card-body pt-0">
                    <canvas id="applicationsChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="card-title mb-0 text-dark">Job Status Distribution</h5>
                    <p class="text-muted small mb-0">Current job posting status</p>
                </div>
                <div class="card-body pt-0">
                    <canvas id="statusChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0 text-dark">Recent Activity</h5>
                        <p class="text-muted small mb-0">Latest system activities</p>
                    </div>
                    <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <?php for($i = 0; $i < 3; $i++): ?>
                        <div class="list-group-item border-0 px-0 py-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-success rounded-circle p-2 me-3">
                                    <i class="fas fa-<?= ['plus', 'user', 'robot'][$i] ?> text-white"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold"><?= ['New job posted', '15 new applications', 'AI optimization completed'][$i] ?></h6>
                                    <p class="text-muted mb-1 small"><?= ['Senior Developer position', 'Marketing Manager role', '3 job descriptions improved'][$i] ?></p>
                                    <small class="text-muted"><?= ['2 hours ago', '5 hours ago', 'Yesterday'][$i] ?></small>
                                </div>
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="card-title mb-0 text-dark">Quick Actions</h5>
                    <p class="text-muted small mb-0">Frequently used features</p>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <?php 
                        $actions = [
                            ['icon' => 'plus', 'color' => 'primary', 'text' => 'New Job Post'],
                            ['icon' => 'robot', 'color' => 'success', 'text' => 'AI Assistant'],
                            ['icon' => 'chart-bar', 'color' => 'warning', 'text' => 'Analytics'],
                            ['icon' => 'cog', 'color' => 'info', 'text' => 'Settings']
                        ];
                        ?>
                        <?php foreach($actions as $action): ?>
                        <div class="col-6">
                            <a href="#" class="btn btn-<?= $action['color'] ?> btn-hover w-100 h-100 py-4 d-flex flex-column align-items-center justify-content-center text-decoration-none rounded-3">
                                <i class="fas fa-<?= $action['icon'] ?> fa-2x mb-2"></i>
                                <span class="fw-semibold"><?= $action['text'] ?></span>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Enhanced Charts with Gradient
    const applicationsCtx = document.getElementById('applicationsChart').getContext('2d');
    const gradient = applicationsCtx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(52, 152, 219, 0.3)');
    gradient.addColorStop(1, 'rgba(52, 152, 219, 0.05)');

    new Chart(applicationsCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
            datasets: [{
                label: 'Applications',
                data: [45, 62, 78, 85, 92, 105, 120, 135, 150],
                borderColor: '#3498db',
                backgroundColor: gradient,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#3498db',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(44, 62, 80, 0.9)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Doughnut Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Draft', 'Closed', 'Pending Review'],
            datasets: [{
                data: [45, 15, 25, 15],
                backgroundColor: ['#27ae60', '#3498db', '#e74c3c', '#f39c12'],
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                }
            }
        }
    });
</script>

<style>
    /* Enhanced Styles */
    .hover-lift {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15) !important;
    }

    .btn-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .card {
        border-radius: var(--border-radius);
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: var(--shadow) !important;
    }

    .bg-opacity-10 {
        background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
    }
</style>
<?= $this->endSection() ?>