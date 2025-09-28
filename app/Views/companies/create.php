<!-- Add Company Button
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCompanyModal">
    <i class="fas fa-plus me-2"></i>Add New Company
</button> -->

<!-- Add Company Modal -->
<div class="modal fade" id="addCompanyModal" tabindex="-1" aria-labelledby="addCompanyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white border-0">
                <div class="d-flex align-items-center">
                    <div class="modal-icon bg-white bg-opacity-20 rounded-circle p-2 me-3">
                        <i class="fas fa-building"></i>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0" id="addCompanyModalLabel">Add New Company</h5>
                        <p class="mb-0 opacity-75 small">Create a new company profile</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4">
                <form id="addCompanyForm" action="<?= base_url('companies/store') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    
                    <div class="row g-3">
                        <!-- Company Name -->
                        <div class="col-12">
                            <label for="company_name" class="form-label fw-semibold">
                                Company Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="company_name" name="company_name" 
                                   placeholder="Enter company name" required>
                        </div>

                        <!-- Contact Information -->
                        <div class="col-12 col-md-6">
                            <label for="contact_name" class="form-label fw-semibold">
                                Contact Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="contact_name" name="contact_name" 
                                   placeholder="Full name of contact person" required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="contact_email" class="form-label fw-semibold">Contact Email</label>
                            <input type="email" class="form-control" id="contact_email" name="contact_email" 
                                   placeholder="contact@company.com">
                        </div>

                        <!-- Phone & Fax -->
                        <div class="col-12 col-md-6">
                            <label for="contact_phone" class="form-label fw-semibold">Phone Number</label>
                            <input type="tel" class="form-control" id="contact_phone" name="contact_phone" 
                                   placeholder="+255 XXX XXX XXX">
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="contact_fax" class="form-label fw-semibold">Fax Number</label>
                            <input type="text" class="form-control" id="contact_fax" name="contact_fax" 
                                   placeholder="Fax number">
                        </div>

                        <!-- Website & Founded Year -->
                        <div class="col-12 col-md-6">
                            <label for="url" class="form-label fw-semibold">Website URL</label>
                            <input type="url" class="form-control" id="url" name="url" 
                                   placeholder="https://company.com">
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="since" class="form-label fw-semibold">Founded Year</label>
                            <input type="number" class="form-control" id="since" name="since" 
                                   placeholder="2020" min="1900" max="2030">
                        </div>

                        <!-- Company Size -->
                        <div class="col-12 col-md-6">
                            <label for="company_size" class="form-label fw-semibold">Company Size</label>
                            <select class="form-select" id="company_size" name="company_size">
                                <option value="">Select company size</option>
                                <option value="1-10 employees">1-10 employees</option>
                                <option value="11-50 employees">11-50 employees</option>
                                <option value="51-200 employees">51-200 employees</option>
                                <option value="201-500 employees">201-500 employees</option>
                                <option value="501-1000 employees">501-1000 employees</option>
                                <option value="1000+ employees">1000+ employees</option>
                            </select>
                        </div>

                        <!-- Logo Upload -->
                        <div class="col-12 col-md-6">
                            <label for="logo" class="form-label fw-semibold">Company Logo</label>
                            <input type="file" class="form-control" id="logo" name="logo" 
                                   accept="image/*">
                            <div class="form-text">Recommended size: 300x300 pixels</div>
                        </div>

                        <!-- Address Line 1 -->
                        <div class="col-12">
                            <label for="address1" class="form-label fw-semibold">Address Line 1</label>
                            <textarea class="form-control" id="address1" name="address1" 
                                      rows="2" placeholder="Street address, P.O. Box"></textarea>
                        </div>

                        <!-- Address Line 2 -->
                        <div class="col-12">
                            <label for="address2" class="form-label fw-semibold">Address Line 2</label>
                            <textarea class="form-control" id="address2" name="address2" 
                                      rows="2" placeholder="Apartment, suite, unit, building, floor, etc."></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="submit" form="addCompanyForm" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Create Company
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Company Modal -->
<div class="modal fade" id="editCompanyModal" tabindex="-1" aria-labelledby="editCompanyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <!-- Modal Header -->
            <div class="modal-header bg-warning text-dark border-0">
                <div class="d-flex align-items-center">
                    <div class="modal-icon bg-dark bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0" id="editCompanyModalLabel">Edit Company</h5>
                        <p class="mb-0 opacity-75 small">Update company information</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4">
                <form id="editCompanyForm" action="<?= base_url('companies/update') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" id="edit_company_id" name="id">
                    
                    <div class="row g-3">
                        <!-- Company Name -->
                        <div class="col-12">
                            <label for="edit_company_name" class="form-label fw-semibold">
                                Company Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="edit_company_name" name="company_name" required>
                        </div>

                        <!-- Contact Information -->
                        <div class="col-12 col-md-6">
                            <label for="edit_contact_name" class="form-label fw-semibold">
                                Contact Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="edit_contact_name" name="contact_name" required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="edit_contact_email" class="form-label fw-semibold">Contact Email</label>
                            <input type="email" class="form-control" id="edit_contact_email" name="contact_email">
                        </div>

                        <!-- Phone & Fax -->
                        <div class="col-12 col-md-6">
                            <label for="edit_contact_phone" class="form-label fw-semibold">Phone Number</label>
                            <input type="tel" class="form-control" id="edit_contact_phone" name="contact_phone">
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="edit_contact_fax" class="form-label fw-semibold">Fax Number</label>
                            <input type="text" class="form-control" id="edit_contact_fax" name="contact_fax">
                        </div>

                        <!-- Website & Founded Year -->
                        <div class="col-12 col-md-6">
                            <label for="edit_url" class="form-label fw-semibold">Website URL</label>
                            <input type="url" class="form-control" id="edit_url" name="url">
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="edit_since" class="form-label fw-semibold">Founded Year</label>
                            <input type="number" class="form-control" id="edit_since" name="since" min="1900" max="2030">
                        </div>

                        <!-- Company Size -->
                        <div class="col-12 col-md-6">
                            <label for="edit_company_size" class="form-label fw-semibold">Company Size</label>
                            <select class="form-select" id="edit_company_size" name="company_size">
                                <option value="">Select company size</option>
                                <option value="1-10 employees">1-10 employees</option>
                                <option value="11-50 employees">11-50 employees</option>
                                <option value="51-200 employees">51-200 employees</option>
                                <option value="201-500 employees">201-500 employees</option>
                                <option value="501-1000 employees">501-1000 employees</option>
                                <option value="1000+ employees">1000+ employees</option>
                            </select>
                        </div>

                        <!-- Logo Upload -->
                        <div class="col-12 col-md-6">
                            <label for="edit_logo" class="form-label fw-semibold">Company Logo</label>
                            <input type="file" class="form-control" id="edit_logo" name="logo" accept="image/*">
                            <div class="form-text">Leave empty to keep current logo</div>
                            <div id="currentLogo" class="mt-2"></div>
                        </div>

                        <!-- Address Line 1 -->
                        <div class="col-12">
                            <label for="edit_address1" class="form-label fw-semibold">Address Line 1</label>
                            <textarea class="form-control" id="edit_address1" name="address1" rows="2"></textarea>
                        </div>

                        <!-- Address Line 2 -->
                        <div class="col-12">
                            <label for="edit_address2" class="form-label fw-semibold">Address Line 2</label>
                            <textarea class="form-control" id="edit_address2" name="address2" rows="2"></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="submit" form="editCompanyForm" class="btn btn-warning">
                    <i class="fas fa-save me-2"></i>Update Company
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-content {
        border-radius: 12px;
        overflow: hidden;
    }

    .modal-header {
        padding: 1.5rem;
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-footer {
        padding: 1.5rem;
        border-radius: 0 0 12px 12px;
    }

    .modal-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-control:focus, .form-select:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }

    /* Smooth transitions */
    .modal.fade .modal-dialog {
        transform: translateY(-50px);
        transition: transform 0.3s ease-out;
    }

    .modal.show .modal-dialog {
        transform: translateY(0);
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        .modal-dialog {
            margin: 0.5rem;
        }
        
        .modal-body {
            padding: 1.5rem;
        }
    }
</style>

<script>
    // Function to open edit modal with company data
    function openEditCompanyModal(companyId) {
        // Fetch company data (you'll need to implement this endpoint)
        fetch(`/companies/get/${companyId}`)
            .then(response => response.json())
            .then(company => {
                // Populate form fields
                document.getElementById('edit_company_id').value = company.id;
                document.getElementById('edit_company_name').value = company.company_name || '';
                document.getElementById('edit_contact_name').value = company.contact_name || '';
                document.getElementById('edit_contact_email').value = company.contact_email || '';
                document.getElementById('edit_contact_phone').value = company.contact_phone || '';
                document.getElementById('edit_contact_fax').value = company.contact_fax || '';
                document.getElementById('edit_url').value = company.url || '';
                document.getElementById('edit_since').value = company.since || '';
                document.getElementById('edit_company_size').value = company.company_size || '';
                document.getElementById('edit_address1').value = company.address1 || '';
                document.getElementById('edit_address2').value = company.address2 || '';
                
                // Show current logo if exists
                if (company.logo) {
                    document.getElementById('currentLogo').innerHTML = `
                        <small class="text-muted">Current logo:</small>
                        <img src="/uploads/logos/${company.logo}" alt="Current logo" style="max-width: 50px; height: auto;" class="ms-2">
                    `;
                }
                
                // Show modal
                new bootstrap.Modal(document.getElementById('editCompanyModal')).show();
            })
            .catch(error => {
                console.error('Error fetching company data:', error);
                alert('Error loading company data');
            });
    }

    // Form submission handling
    document.addEventListener('DOMContentLoaded', function() {
        // Add loading state to submit buttons
        const forms = ['addCompanyForm', 'editCompanyForm'];
        forms.forEach(formId => {
            const form = document.getElementById(formId);
            if (form) {
                form.addEventListener('submit', function(e) {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
                        submitBtn.disabled = true;
                    }
                });
            }
        });

        // Auto-focus first input when modal opens
        document.addEventListener('show.bs.modal', function (e) {
            const modal = e.target;
            const firstInput = modal.querySelector('input, select, textarea');
            if (firstInput) {
                setTimeout(() => firstInput.focus(), 300);
            }
        });

        // Clear form when add modal hides
        document.getElementById('addCompanyModal').addEventListener('hidden.bs.modal', function () {
            document.getElementById('addCompanyForm').reset();
        });
    });
</script>