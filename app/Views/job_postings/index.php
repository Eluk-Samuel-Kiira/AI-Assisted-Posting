<?= $this->extend('layouts/dashboard_layout') ?>

<?= $this->section('title') ?><?= $title ?? 'Job Postings - LaFab AI Posting' ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Mobile Header -->
<div class="d-lg-none bg-primary text-white p-3">
    <div class="d-flex align-items-center">
        <button class="btn btn-light me-3" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <div>
            <h5 class="mb-0">Job Postings</h5>
            <small>Manage your AI-generated job listings</small>
        </div>
    </div>
</div>

<!-- Desktop Header -->
<div class="content-header bg-white shadow-sm d-none d-lg-block">
    <div class="container-fluid py-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h2 mb-1 text-primary">Job Postings</h1>
                <p class="text-muted mb-0">Manage and view your AI-generated job listings</p>
            </div>
            <div class="col-auto">
                <div class="d-flex gap-2">
                    <span class="badge bg-primary fs-6"><?= count($jobs) ?> Jobs</span>
                    <a href="<?= base_url('job-postings') ?>" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-sync-alt me-1"></i>Refresh
                    </a>
                    <button class="btn btn-primary sidebar-toggle" onclick="toggleSidebar()">
                        <i class="fas fa-bars me-2"></i>
                        <span>Menu</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container-fluid py-4">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (empty($jobs)): ?>
        <div class="text-center py-5">
            <div class="empty-state">
                <i class="fas fa-briefcase fa-4x text-muted mb-3"></i>
                <h3 class="text-muted">No Job Postings Yet</h3>
                <p class="text-muted">You haven't created any job postings yet.</p>
                <a href="<?= base_url('job-analyzer') ?>" class="btn btn-primary">
                    <i class="fas fa-robot me-2"></i>Analyze Your First Job
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <?php foreach ($jobs as $job): ?>
                                <li class="list-group-item p-4 border-0 border-bottom">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <div class="d-flex align-items-start mb-2">
                                                <div class="job-icon bg-primary rounded-circle p-3 me-3">
                                                    <i class="fas fa-briefcase text-white"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h4 class="job-title mb-1">
                                                        <a href="<?= base_url('job-postings/view/' . $job['id']) ?>" class="text-decoration-none text-dark">
                                                            <?= esc($job['job_title'] ?? 'Untitled Job') ?>
                                                        </a>
                                                    </h4>
                                                    <div class="job-meta text-muted mb-2">
                                                        <?php if (!empty($job['company'])): ?>
                                                            <span class="me-3">
                                                                <i class="fas fa-building me-1"></i>
                                                                <?= esc($job['company']) ?>
                                                            </span>
                                                        <?php endif; ?>
                                                        <?php if (!empty($job['location'])): ?>
                                                            <span class="me-3">
                                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                                <?= esc($job['location']) ?>
                                                            </span>
                                                        <?php endif; ?>
                                                        <?php if (!empty($job['employment_type'])): ?>
                                                            <span>
                                                                <i class="fas fa-clock me-1"></i>
                                                                <?= esc($job['employment_type']) ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                    
                                                    <?php if (!empty($job['skills']) && is_array($job['skills'])): ?>
                                                        <div class="job-tags mb-2">
                                                            <?php foreach (array_slice($job['skills'], 0, 5) as $skill): ?>
                                                                <span class="badge bg-light text-dark border me-1"><?= esc($skill) ?></span>
                                                            <?php endforeach; ?>
                                                            <?php if (count($job['skills']) > 5): ?>
                                                                <span class="badge bg-light text-dark border">+<?= count($job['skills']) - 5 ?> more</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <?php if (!empty($job['job_description'])): ?>
                                                        <p class="job-excerpt text-muted mb-0">
                                                            <?= esc(substr($job['job_description'], 0, 150)) ?>...
                                                        </p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex flex-column align-items-end">
                                                <?php if (!empty($job['salary_range'])): ?>
                                                    <div class="job-salary mb-2">
                                                        <strong class="text-success"><?= esc($job['salary_range']) ?></strong>
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <div class="job-status mb-3">
                                                    <span class="badge bg-<?= ($job['status'] ?? 'draft') === 'active' ? 'success' : 'secondary' ?>">
                                                        <?= ucfirst($job['status'] ?? 'draft') ?>
                                                    </span>
                                                </div>
                                                
                                                <div class="job-actions d-flex gap-2">
                                                    <a href="<?= base_url('job-postings/view/' . $job['id']) ?>" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-eye me-1"></i>View
                                                    </a>
                                                    <a href="<?= base_url('job-postings/delete/' . $job['id']) ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this job?')">
                                                        <i class="fas fa-trash me-1"></i>Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="job-footer text-muted small">
                                                <span class="me-3">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    Posted: <?= date('M j, Y', strtotime($job['created_at'])) ?>
                                                </span>
                                                <?php if (!empty($job['application_deadline'])): ?>
                                                    <span class="me-3">
                                                        <i class="fas fa-hourglass-end me-1"></i>
                                                        Apply by: <?= esc($job['application_deadline']) ?>
                                                    </span>
                                                <?php endif; ?>
                                                <?php if (!empty($job['experience_level'])): ?>
                                                    <span>
                                                        <i class="fas fa-user me-1"></i>
                                                        <?= esc($job['experience_level']) ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

<style>
    .job-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .job-title {
        font-size: 1.25rem;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .job-title:hover {
        color: #3498db !important;
    }

    .job-meta {
        font-size: 0.9rem;
    }

    .job-excerpt {
        font-size: 0.95rem;
        line-height: 1.5;
    }

    .job-tags .badge {
        font-size: 0.8rem;
        padding: 0.35em 0.65em;
    }

    .list-group-item {
        transition: background-color 0.3s ease;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
    }

    .empty-state {
        padding: 3rem 1rem;
    }

    .job-footer {
        border-top: 1px solid #e9ecef;
        padding-top: 1rem;
        font-size: 0.85rem;
    }

    @media (max-width: 768px) {
        .job-icon {
            width: 50px;
            height: 50px;
        }

        .job-title {
            font-size: 1.1rem;
        }

        .job-meta span {
            display: block;
            margin-bottom: 0.25rem;
        }
        
        .job-actions {
            flex-direction: column;
            width: 100%;
        }
        
        .job-actions .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }
</style>