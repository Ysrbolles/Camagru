<?php require APPROOT.'/views/inc/header.php'; ?>

<div class="jumbotron">
<h1 class="dis[play-3"><?php echo $data['title']; ?> <i class="fa fa-smile-o" aria-hidden="true"></i></h1>
   <dive>
       <p class="lead">Your account has been successfully verified. You my now login.</p>
       <hr class="my-4">
    </dive> 
    <a href="<?php echo URLROOT;?>/users/login"><button type="button" class="btn btn-success center-block">Log in</button></a>
</div>

<?php require APPROOT.'/views/inc/footer.php'; ?>