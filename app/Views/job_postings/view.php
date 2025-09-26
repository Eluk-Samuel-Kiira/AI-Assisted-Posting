<?= $this->extend('layouts/dashboard_layout') ?>

<?= $this->section('title') ?><?= $title ?? 'Job Details - LaFab AI Posting' ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Mobile Header -->
<div class="d-lg-none bg-primary text-white p-3">
    <div class="d-flex align-items-center">
        <a href="<?= base_url('job-postings') ?>" class="btn btn-light me-3">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h5 class="mb-0">Job Details</h5>
            <small><?= esc($job['job_title'] ?? 'Job Details') ?></small>
        </div>
    </div>
</div>

<!-- Desktop Header -->
<div class="content-header bg-white shadow-sm d-none d-lg-block">
    <div class="container-fluid py-4">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('job-postings') ?>">Job Postings</a></li>
                        <li class="breadcrumb-item active">Job Details</li>
                    </ol>
                </nav>
                <h1 class="h2 mb-1 text-primary"><?= esc($job['job_title'] ?? 'Job Details') ?></h1>
                <p class="text-muted mb-0">
                    <?= esc($job['company'] ?? 'Company not specified') ?> 
                    • <?= esc($job['location'] ?? 'Location not specified') ?>
                    • <?= esc($job['employment_type'] ?? 'Employment type not specified') ?>
                </p>
            </div>
            <div class="col-auto">
                <div class="d-flex gap-2">
                    <a href="<?= base_url('job-postings') ?>" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
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
    <div class="row">
        <!-- Main Job Content -->
        <div class="col-lg-8">
            <!-- Job Overview -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Job Overview</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($job['job_description'])): ?>
                        <h6 class="text-muted mb-3">Job Description</h6>
                        <p class="mb-4"><?= nl2br(esc($job['job_description'])) ?></p>
                    <?php endif; ?>

                    <?php if (!empty($job['responsibilities']) && is_array($job['responsibilities'])): ?>
                        <h6 class="text-muted mb-3">Key Responsibilities</h6>
                        <ul class="list-group list-group-flush mb-4">
                            <?php foreach ($job['responsibilities'] as $responsibility): ?>
                                <li class="list-group-item border-0 px-0 py-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <?= esc($responsibility) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <?php if (!empty($job['requirements']) && is_array($job['requirements'])): ?>
                        <h6 class="text-muted mb-3">Requirements</h6>
                        <ul class="list-group list-group-flush mb-4">
                            <?php foreach ($job['requirements'] as $requirement): ?>
                                <li class="list-group-item border-0 px-0 py-2">
                                    <i class="fas fa-requirement text-primary me-2"></i>
                                    <?= esc($requirement) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <?php if (!empty($job['preferred_qualifications']) && is_array($job['preferred_qualifications'])): ?>
                        <h6 class="text-muted mb-3">Preferred Qualifications</h6>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($job['preferred_qualifications'] as $qualification): ?>
                                <li class="list-group-item border-0 px-0 py-2">
                                    <i class="fas fa-star text-warning me-2"></i>
                                    <?= esc($qualification) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Job Details Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-building me-2"></i>Job Details</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($job['company'])): ?>
                        <div class="mb-3">
                            <strong>Company:</strong><br>
                            <?= esc($job['company']) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($job['location'])): ?>
                        <div class="mb-3">
                            <strong>Location:</strong><br>
                            <?= esc($job['location']) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($job['employment_type'])): ?>
                        <div class="mb-3">
                            <strong>Employment Type:</strong><br>
                            <?= esc($job['employment_type']) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($job['work_arrangement'])): ?>
                        <div class="mb-3">
                            <strong>Work Arrangement:</strong><br>
                            <?= esc($job['work_arrangement']) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($job['experience_level'])): ?>
                        <div class="mb-3">
                            <strong>Experience Level:</strong><br>
                            <?= esc($job['experience_level']) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($job['salary_range'])): ?>
                        <div class="mb-3">
                            <strong>Salary Range:</strong><br>
                            <span class="text-success fw-bold"><?= esc($job['salary_range']) ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($job['application_deadline'])): ?>
                        <div class="mb-3">
                            <strong>Application Deadline:</strong><br>
                            <?= esc($job['application_deadline']) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($job['education_requirements'])): ?>
                        <div class="mb-3">
                            <strong>Education Requirements:</strong><br>
                            <?= esc($job['education_requirements']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Skills Card -->
            <?php if (!empty($job['skills']) && is_array($job['skills'])): ?>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Required Skills</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2">
                            <?php foreach ($job['skills'] as $skill): ?>
                                <span class="badge bg-primary"><?= esc($skill) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Benefits Card -->
            <?php if (!empty($job['benefits']) && is_array($job['benefits'])): ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-gift me-2"></i>Benefits</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <?php foreach ($job['benefits'] as $benefit): ?>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    <?= esc($benefit) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Contact Information -->
    <?php if (!empty($job['contact_info'])): ?>
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-envelope me-2"></i>How to Apply</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0"><?= nl2br(esc($job['contact_info'])) ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Job Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="d-flex justify-content-center gap-3">
                        <a href="<?= base_url('job-postings') ?>" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Job List
                        </a>
                        <a href="<?= base_url('job-postings/delete/' . $job['id']) ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this job?')">
                            <i class="fas fa-trash me-2"></i>Delete This Job
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>