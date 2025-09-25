<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Register</h3>
                    </div>
                    <div class="card-body">
                        <?php if (session()->has('errors')): ?>
                            <div class="alert alert-danger">
                                <?php foreach (session('errors') as $error): ?>
                                    <p><?= $error ?></p>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                        
                        <?php if (session()->has('error')): ?>
                            <div class="alert alert-danger">
                                <?= session('error') ?>
                            </div>
                        <?php endif ?>
                        
                        <form method="post">
                            <?= csrf_field() ?>
                            
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" 
                                       value="<?= old('username') ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" 
                                       value="<?= old('full_name') ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?= old('email') ?>" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">Register with Magic Link</button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <a href="<?= base_url('auth/login') ?>">Already have an account? Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>