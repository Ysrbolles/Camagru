<?php require APPROOT .'/views/inc/header.php'; ?>
    <a href="<?php echo URLROOT; ?>/pages/index" class="btn btn-light"><i class="fa fa-backward"></i> Back</a><br>
    <br>
    <!---->
    <div class="container jumbotron jumbotron-fuld text-center">
    <h2>Add Post</h2>
        <div class="row" class="img-fluid">
                <div class="col-md-6">
                    <div id="imagefilter" class="img-fluid">
                        <img id="img_filter" class="img-fluid">
                        <video id="video" width="400" height="300" ></video>
                    </div>
                </div>
            
        <div class="col-md-6">   
        <div class="container" data-spy="scroll"  style="overflow-x: auto; border:1px groove black; width: 200px; height: 300px; float: left; display: flex;">
              
            <div class="col" >
                <?php $d = '../public/imgs/PNGS/';
                    foreach(glob($d."*") as $file) : ?>    
                    <?php echo '<img class="card-img-top" src="'.$file.'" alt="Card image cap" id="'.$file.'" style="width: 100px; height: 100px;" >'; ?>
                    <input type="radio" value="<?php echo $file; ?>" name="stickers"> stickers
                <?php endforeach; ?>
              </div>
        </div>
        </div>
           
        </div>
        <div class="row">
        <div class="flex-md-equal w-100 my-md-3 pl-md-3"> 
            <button class="btn btn-primary btn-lg" href="#" id="capture" role="button" disabled>Take Photo</button>
            <input type="file" name="upFile" id="upFile" accept=".png,.gif,.jpg,.jpeg">
            <div class="flex-md-equal w-100 m-3 py-md-3">
        
         <div class="container">
        <div class="row">
             <div class="col-md-6">  
         <canvas id="canvas" width="400" height="300" class="img-fluid">
                 </canvas> </div>
        <div class="col-md-6"> 
          <div class="container">
        <div data-spy="scroll"  style="overflow-x: auto; border:1px groove black; width: 500px; height: 400px;" id="ba3" class="img-fluid">
            <div class="col" >
                <?php 
                    foreach($data['posts'] as $post): ?>    
                    <div><?php echo '<img class="card-img-top img-fluid" src="'.$post->imgurl.'" alt="Card image cap"style="width: 500px; height: 300px;" >'; ?></div><br>
                <?php endforeach; ?>
              </div>
        </div>
            </div></div></div><br>
            <div class="row" style="margin-left: 50px;">
         <form action="<?php echo URLROOT;?>/posts/image" method="POST">
             <button class="btn btn-primary btn-lg" href="#" id="up" role="button" disabled>Add Pic</button>
             <button class="btn btn-primary btn-lg" href="#" id="clear" role="button" disabled>Clear</button>
        </form>
                </div>
            
            </div>
      </div>
     </div>
<?php require APPROOT .'/views/inc/footer.php'; ?>