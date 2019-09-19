<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
  <div class="container">
  <a class="navbar-brand" href="<?php echo URLROOT;?>/Posts/index"><i class="fa fa-instagram" aria-hidden="true"></i> <?php echo SITENAME; ?></a>
  <button class="navbar-toggler" type="button" id="btn" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="<?php echo URLROOT;?>/Posts/index">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo URLROOT;?>/pages/about">About</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
    <?php if(isset($_SESSION['id'])): ?>
         <li class="nav-item">
        <a class="nav-link" href="<?php echo URLROOT;?>/users/profile"><?php echo $_SESSION['username'];?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo URLROOT;?>/users/logout">logout</a>
      </li>
      
    <?php else: ?>
       <li class="nav-item">
        <a class="nav-link" href="<?php echo URLROOT;?>/users/register">Register</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo URLROOT;?>/users/login">Login</a>
      </li>
        <?php endif;?>
    </ul>
    </div>
  </div>
</nav>
