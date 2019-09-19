<?php require APPROOT .'/views/inc/header.php'; ?>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <?php flash('register_success'); ?>
                <h2>Login !</h2>
                <p>Please fill in your credentials to Login!</p>
                <form action="<?php echo URLROOT;?>/users/login" method="POST">
                    <div class="form-group">
                        <label for="username">Username: <sup>*</sup></label>
                        <input type="text" name="username" class="form-control form-control-lg <?php echo (!empty($data['username_err']))? 'is-invalid' : ''; ?>" 
                        value="<?php echo $data['username']; ?>">
                        <span class="invalid-feedback"><?php echo $data['username_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password: <sup>*</sup></label>
                        <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err']))? 'is-invalid' : ''; ?>" 
                        value="<?php echo $data['password']; ?>">
                        <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Login" class="btn btn-success btn-block">
                        </div>
                        <div class="col">
                            <div class="row"><a href="<?php echo URLROOT;?>/users/register" class="btn btn-light btn-block"> No account? Register</a></div>
                            <div class="row"><a href="<?php echo URLROOT;?>/users/fgpass" class="btn btn-light btn-block"> Forgotten Password? Recover</a></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php require APPROOT .'/views/inc/footer.php'; ?>