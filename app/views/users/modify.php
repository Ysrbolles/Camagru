<?php require APPROOT.'/views/inc/header.php'; ?>
<a href="<?php echo URLROOT; ?>/users/profile" class="btn btn-light"><i class="fa fa-backward"></i> Back</a><br>
  <div class="row">
    <div class="col-md-6 mx-auto">
      <div class="card card-body bg-light mt-5">
          <?php echo flash("modify_success"); ?>
        <h2>Modify An Account</h2>
        <p>Please fill out this form to modify your compte</p>
        <form action="<?php echo URLROOT; ?>/users/modify" method="post">
          <div class="form-group">
            <label for="uname">New User Name: </label>
            <input type="text" name="username" class="form-control form-control-lg <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['username']; ?>"  placeholder="<?php echo $_SESSION['username'];?>">
            <span class="invalid-feedback"><?php echo $data['username_err']; ?></span>
          </div>
          <div class="form-group">
            <label for="email">New Email: </label>
            <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>"  placeholder="<?php echo $_SESSION['email'];?>">
            <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
          </div>
          <div class="form-group">
            <label for="password">New Password:</label>
            <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
            <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
          </div>
          <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['confirm_password']; ?>">
            <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
          </div>
          <div class="row">
            <div class="col">
               <p>Send Email Notification :</p>
            </div>
              <div class="col">
            <?php if($_SESSION['notification'] == 1): ?>
              <input type="checkbox" checked data-toggle="toggle" name="notif">
            <?php else: ?>
                <input type="checkbox" data-toggle="toggle" name="notif">
            <?php endif;?>
            </div>
            </div> 
          <div class="row">
            <div class="col">
              <input type="submit" value="Modify" class="btn btn-info btn-block">
            </div>
            </div>
            
        </form>
        <form method="post">
              
        </form>
      </div>
    </div>
  </div>
<?php require APPROOT.'/views/inc/footer.php'; ?>