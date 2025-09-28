
<!-- Add Company Modal -->
<div class="modal fade" id="addCompanyModal" tabindex="-1" aria-labelledby="addCompanyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white border-0">
                <div class="d-flex align-items-center w-100">
                    <div class="modal-icon bg-white bg-opacity-20 rounded-circle p-2 me-3">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="modal-title mb-0" id="addCompanyModalLabel">Add New Company</h5>
                        <p class="mb-0 opacity-75 small">Create a new company profile</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4">
                <form id="addCompanyForm">
                    <?= csrf_field() ?>
                    
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="modal_company_name" class="form-label fw-semibold">
                                Company Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="modal_company_name" name="company_name" required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="modal_contact_name" class="form-label fw-semibold">
                                Contact Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="modal_contact_name" name="contact_name" required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="modal_contact_email" class="form-label fw-semibold">Contact Email</label>
                            <input type="email" class="form-control" id="modal_contact_email" name="contact_email">
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="modal_contact_phone" class="form-label fw-semibold">Phone Number</label>
                            <input type="tel" class="form-control" id="modal_contact_phone" name="contact_phone">
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="modal_company_size" class="form-label fw-semibold">Company Size</label>
                            <select class="form-select" id="modal_company_size" name="company_size">
                                <option value="">Select size</option>
                                <option value="1-10 employees">1-10 employees</option>
                                <option value="11-50 employees">11-50 employees</option>
                                <option value="51-200 employees">51-200 employees</option>
                                <option value="201-500 employees">201-500 employees</option>
                                <option value="501-1000 employees">501-1000 employees</option>
                                <option value="1000+ employees">1000+ employees</option>
                            </select>
                        </div>
                        
                        <div class="col-12">
                            <label for="modal_logo" class="form-label fw-semibold">
                                Logo Link </span>
                            </label>
                            <input type="text" class="form-control" id="modal_logo" name="logo" required>
                        </div>

                        <div class="col-12">
                            <label for="modal_address1" class="form-label fw-semibold">Address</label>
                            <textarea class="form-control" id="modal_address1" name="address1" rows="2"></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary" onclick="saveCompany()">
                    <i class="fas fa-save me-2"></i>Save Company
                </button>
            </div>
        </div>
    </div>
</div>
<script>
// Global variable to store companies list
let companiesList = {};

// Load companies via AJAX
function loadCompanies() {
    fetch('<?= base_url('companies/ajax-list') ?>', {
        method: 'GET', // Explicitly set to GET
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            companiesList = data.companies;
            
            // console.log(companiesList)
            updateCompanyDatalist();
            console.log('Companies loaded successfully:', Object.keys(companiesList).length, 'companies');
        } else {
            throw new Error(data.message || 'Failed to load companies');
        }
    })
    .catch(error => {
        console.error('Error loading companies:', error);
        showToast('Error loading companies list: ' + error.message, 'error');
    });
}

// Save company via AJAX - MAKE SURE THIS IS POST
function saveCompany() {
    const form = document.getElementById('addCompanyForm');
    const formData = new FormData(form);
    const submitBtn = document.querySelector('#addCompanyModal .btn-primary');
    
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
    submitBtn.disabled = true;

    // AJAX request to save company - POST method
    fetch('<?= base_url('companies/ajax-store') ?>', {
        method: 'POST', // This should be POST
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(async response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.status);
        }

        const data = await response.json();
        
        // console.log(data)

        if (data.success) {
            // Show success toast FIRST
            showToast(data.message || 'Company saved successfully!', 'success');

            // Update list and form
            companiesList[data.company.id] = data.company.company_name;
            updateCompanyDatalist();

            document.getElementById('company_name').value = data.company.company_name;
            document.getElementById('company_id').value = data.company.id;

            checkCompanyExists(data.company.company_name);

            // Close modal AFTER toast is triggered
            bootstrap.Modal.getInstance(document.getElementById('addCompanyModal')).hide();
        } else {
            // Show validation errors or general error
            if (data.errors) {
                Object.values(data.errors).forEach(msg => showToast(msg, 'error'));
            } else {
                showToast(data.message || 'Failed - Validation Errors', 'error');
            }
        }
    })
    .catch(error => {
        console.log(error);
        showToast('Error saving company: ' + error.message, 'error');
    })
    .finally(() => {
        submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Save Company';
        submitBtn.disabled = false;
    });


}

// Update datalist with companies
function updateCompanyDatalist() {
    const datalist = document.getElementById('companySuggestions');
    datalist.innerHTML = '';
    
    Object.values(companiesList).forEach(companyName => {
        const option = document.createElement('option');
        option.value = companyName;
        datalist.appendChild(option);
    });
}

// Check if company exists in database
function checkCompanyExists(companyName) {
    const input = document.getElementById('company_name');
    const validation = document.getElementById('companyValidation');
    const hiddenId = document.getElementById('company_id');
    
    if (!companyName.trim()) {
        input.classList.remove('company-valid', 'company-invalid', 'company-checking');
        validation.innerHTML = '';
        hiddenId.value = ''; // reset hidden id
        return;
    }

    input.classList.add('company-checking');
    validation.innerHTML = '<span class="text-warning"><i class="fas fa-spinner fa-spin me-1"></i>Checking company...</span>';

    setTimeout(() => {
        // find company id by name (case-insensitive)
        const entry = Object.entries(companiesList).find(([id, name]) => 
            name.toLowerCase() === companyName.toLowerCase()
        );

        if (entry) {
            const [id, name] = entry;
            input.classList.remove('company-invalid', 'company-checking');
            input.classList.add('company-valid');
            validation.innerHTML = '<span class="text-success"><i class="fas fa-check-circle me-1"></i>Company found in database</span>';
            
            hiddenId.value = id; // ✅ set the hidden field
        } else {
            input.classList.remove('company-valid', 'company-checking');
            input.classList.add('company-invalid');
            validation.innerHTML = `<span class="text-danger">
                <i class="fas fa-exclamation-triangle me-1"></i>Company not found. 
                <a href="#" class="text-danger fw-semibold" onclick="openAddCompanyModal('${companyName}')">Click here to add it</a>
            </span>`;
            
            hiddenId.value = ''; // reset if not found
        }
    }, 500);
}


// Open modal with pre-filled company name
function openAddCompanyModal(prefillName = '') {
    // Method 1: Using the element ID string
    const modal = new bootstrap.Modal('#addCompanyModal');
    
    // Method 2: Or get the element first
    // const modalElement = document.getElementById('addCompanyModal');
    // const modal = new bootstrap.Modal(modalElement);
    
    const companyNameInput = document.getElementById('modal_company_name');
    
    if (prefillName) {
        companyNameInput.value = prefillName;
    } else {
        const mainCompanyInput = document.getElementById('company_name');
        companyNameInput.value = mainCompanyInput.value;
    }
    
    modal.show();
}

// // Save company via AJAX
// function saveCompany() {
//     const form = document.getElementById('addCompanyForm');
//     const formData = new FormData(form);
//     const submitBtn = document.querySelector('#addCompanyModal .btn-primary');
    
//     // Show loading state
//     submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
//     submitBtn.disabled = true;

//     // AJAX request to save company
//     fetch('<?= base_url('companies/ajax-store') ?>', {
//         method: 'POST',
//         body: formData,
//         headers: {
//             'X-Requested-With': 'XMLHttpRequest'
//         }
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.success) {
//             // Add new company to the list
//             companiesList[data.company.id] = data.company.company_name;
            
//             // Update datalist
//             updateCompanyDatalist();
            
//             // Set value in main form
//             document.getElementById('company_name').value = data.company.company_name;
//             document.getElementById('company_id').value = data.company.id;
    
            
//             // Validate the company
//             checkCompanyExists(data.company.company_name);
            
//             // Close modal
//             bootstrap.Modal.getInstance(document.getElementById('addCompanyModal')).hide();
            
//             // Show success message
//             showToast('Company added successfully!', 'success');
//         } else {
//             throw new Error(data.message || 'Failed to save company');
//         }
//     })
//     .catch(error => {
//         console.error('Error:', error);
//         showToast('Error saving company: ' + error.message, 'error');
//     })
//     .finally(() => {
//         // Reset button state
//         submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Save Company';
//         submitBtn.disabled = false;
//     });
// }

// Show toast notification
function showToast(message, type = 'info') {
    let toastContainer = document.getElementById('toastContainer');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toastContainer';
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }

    const toastId = 'toast-' + Date.now();
    const bgColor = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-info';
    
    const toastHTML = `
        <div id="${toastId}" class="toast align-items-center text-white ${bgColor} border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'exclamation-triangle' : 'info'}-circle me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;
    
    toastContainer.insertAdjacentHTML('beforeend', toastHTML);
    
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, { delay: 3000 });
    toast.show();
    
    toastElement.addEventListener('hidden.bs.toast', () => {
        toastElement.remove();
    });
}

// Initialize event listeners when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Load companies first
    loadCompanies();
    
    const companyInput = document.getElementById('company_name');
    
    // Check company on input change with debounce
    let debounceTimer;
    companyInput.addEventListener('input', function(e) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            checkCompanyExists(e.target.value);
        }, 500);
    });
    
    // Check company on blur
    companyInput.addEventListener('blur', function(e) {
        checkCompanyExists(e.target.value);
    });
    
    // Prevent form submission if company is invalid
    const form = companyInput.closest('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const companyName = companyInput.value.trim();
            const companyExists = Object.values(companiesList).some(name => 
                name.toLowerCase() === companyName.toLowerCase()
            );
            
            if (!companyExists) {
                e.preventDefault();
                showToast('Please select a valid company or add a new one', 'error');
                companyInput.focus();
            }
        });
    }
    
    // Clear modal form when hidden
    document.getElementById('addCompanyModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('addCompanyForm').reset();
    });
});
</script>