<?= $this->extend('layouts/dashboard_layout') ?>

<?= $this->section('title') ?>Companies Management - LaFab AI Posting<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Mobile Header -->
<div class="d-lg-none bg-primary text-white p-3">
    <div class="d-flex align-items-center">
        <button class="btn btn-light me-3" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <div>
            <h5 class="mb-0">Comapanies</h5>
            <small>Welcome back, <?= session()->get('username') ?? 'User' ?></small>
        </div>
    </div>
</div>

<!-- Desktop Header -->
<div class="content-header bg-white shadow-sm d-none d-lg-block">
    <div class="container-fluid py-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h2 mb-1 text-primary">Dashboard Overview</h1>
                <p class="text-muted mb-0">Welcome back, <?= session()->get('username') ?? 'User' ?>! Here's your AI-powered hiring insights.</p>
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
    <!-- Alert Messages -->
    <?php if (session()->has('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= session('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Companies Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0 text-dark">
                    <i class="fas fa-building me-2"></i>
                    All Companies
                </h6>
                <div class="d-flex align-items-center gap-2">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search companies..." id="searchCompanies">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <!-- Desktop Table View -->
            <div class="d-none d-lg-block">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="companiesTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 ps-4" style="width: 25%">Company</th>
                                <th class="border-0" style="width: 20%">Contact</th>
                                <th class="border-0" style="width: 15%">Phone</th>
                                <th class="border-0" style="width: 15%">Size</th>
                                <th class="border-0" style="width: 10%">Since</th>
                                <th class="border-0 text-end pe-4" style="width: 15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($companies)): ?>
                                <?php foreach ($companies as $company): ?>
                                    <tr class="company-row">
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-building text-primary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold text-dark"><?= esc($company['company_name']) ?></div>
                                                    <?php if ($company['url']): ?>
                                                        <small class="text-muted"><?= esc($company['url']) ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-dark"><?= esc($company['contact_name']) ?></div>
                                            <?php if ($company['contact_email']): ?>
                                                <small class="text-muted"><?= esc($company['contact_email']) ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($company['contact_phone']): ?>
                                                <span class="text-dark"><?= esc($company['contact_phone']) ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($company['company_size']): ?>
                                                <span class="badge bg-primary bg-opacity-10 text-primary"><?= esc($company['company_size']) ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($company['since']): ?>
                                                <span class="text-dark"><?= esc($company['since']) ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('companies/edit/' . $company['id']) ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete(<?= $company['id'] ?>, '<?= esc($company['company_name']) ?>')" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-building fa-3x mb-3 opacity-25"></i>
                                        <p class="mb-2">No companies found.</p>
                                        <a href="<?= base_url('companies/create') ?>" class="btn btn-primary btn-sm">Add Your First Company</a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile Card View -->
            <div class="d-lg-none">
                <div class="row g-3 p-3">
                    <?php if (!empty($companies)): ?>
                        <?php foreach ($companies as $company): ?>
                            <div class="col-12">
                                <div class="card border-0 shadow-sm company-card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                                    <i class="fas fa-building text-primary fa-lg"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 text-dark"><?= esc($company['company_name']) ?></h6>
                                                    <?php if ($company['url']): ?>
                                                        <small class="text-muted"><?= esc($company['url']) ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <?php if ($company['company_size']): ?>
                                                <span class="badge bg-primary bg-opacity-10 text-primary"><?= esc($company['company_size']) ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="row g-3 mb-3">
                                            <div class="col-6">
                                                <small class="text-muted d-block">Contact</small>
                                                <span class="text-dark"><?= esc($company['contact_name']) ?></span>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted d-block">Phone</small>
                                                <span class="text-dark"><?= $company['contact_phone'] ? esc($company['contact_phone']) : '-' ?></span>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted d-block">Email</small>
                                                <span class="text-dark small"><?= $company['contact_email'] ? esc($company['contact_email']) : '-' ?></span>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted d-block">Since</small>
                                                <span class="text-dark"><?= $company['since'] ? esc($company['since']) : '-' ?></span>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                Created <?= date('M j, Y', strtotime($company['created_at'])) ?>
                                            </small>
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('companies/edit/' . $company['id']) ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete(<?= $company['id'] ?>, '<?= esc($company['company_name']) ?>')" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-building fa-3x mb-3 opacity-25"></i>
                                <p class="mb-2">No companies found.</p>
                                <a href="<?= base_url('companies/create') ?>" class="btn btn-primary btn-sm">Add Your First Company</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Pagination (if needed) -->
        <?php if (!empty($companies) && count($companies) > 10): ?>
            <div class="card-footer bg-light border-0">
                <nav aria-label="Companies pagination">
                    <ul class="pagination justify-content-center mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="companyName"></strong>? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="deleteButton" class="btn btn-danger">Delete Company</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function confirmDelete(companyId, companyName) {
    document.getElementById('companyName').textContent = companyName;
    document.getElementById('deleteButton').href = '<?= base_url('companies/delete/') ?>' + companyId;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// Enhanced interactivity
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchCompanies');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            filterCompanies(searchTerm);
        });
    }

    // Add hover effects to desktop rows
    const companyRows = document.querySelectorAll('.company-row');
    companyRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'rgba(52, 152, 219, 0.05)';
            this.style.transform = 'translateY(-1px)';
            this.style.transition = 'all 0.2s ease';
        });
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
            this.style.transform = '';
        });
    });

    // Add hover effects to mobile cards
    const companyCards = document.querySelectorAll('.company-card');
    companyCards.forEach(card => {
        card.addEventListener('touchstart', function() {
            this.style.transform = 'scale(0.98)';
            this.style.transition = 'transform 0.2s ease';
        });
        card.addEventListener('touchend', function() {
            this.style.transform = '';
        });
    });
});

function filterCompanies(searchTerm) {
    const rows = document.querySelectorAll('.company-row');
    const cards = document.querySelectorAll('.company-card');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
    
    cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        card.closest('.col-12').style.display = text.includes(searchTerm) ? '' : 'none';
    });
}
</script>

<style>
.company-card {
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
}

.company-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.company-row {
    transition: all 0.3s ease;
}

@media (max-width: 991.98px) {
    .company-card {
        margin-bottom: 1rem;
    }
    
    .btn-group .btn {
        padding: 0.375rem 0.75rem;
    }
}
</style>
<?= $this->endSection() ?>