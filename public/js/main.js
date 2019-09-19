document.getElementById('btn').addEventListener('click', function(){
 if( document.getElementById('navbarsExampleDefault').style.display == "block")
   document.getElementById('navbarsExampleDefault').style.display = "none";
 else
   document.getElementById('navbarsExampleDefault').style.display = "block";
 });

 //----------------------------------------------------------------------------------------------------

document.addEventListener("DOMContentLoaded", function(){
    var likes = document.getElementsByName("liket");
    var show = document.getElementsByName("commentbtn");
    var comment = document.getElementsByName("cmntbtn");
   
    //like
    
    for (var i=0; i < likes.length; i++) {
        likes[i].onclick = function(event) 
        {
            if (event.target.className == "fa fa-heart-o")
                {
                    var imgid = (event.target && event.target.getAttribute('data-imgid'));
                    var nbr_cmt = document.querySelector('p[data-imgid="' + imgid + '"]');
                    var userid = (event.target && event.target.getAttribute('data-userid'));
                     if(userid == "")
                    {
                        window.location.href = "http://localhost/Camagru/users/login";
                    }
                    var xhttp = new XMLHttpRequest();
                    var params = "imgid="+imgid+"&userid="+userid;
                    xhttp.open('POST', 'http://localhost/Camagru/Posts/addlikes');
                    xhttp.withCredentials = true;
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.onreadystatechange = function(){
                        if (this.readyState == 4 && this.status == 200){
                            nbr_cmt.innerHTML = this.responseText;
                        }    
                    }
                    xhttp.send(params);
                    event.target.className = "fa fa-heart";
                }
                //unlike
            else if (event.target.className == "fa fa-heart")
                {
                    var imgid = (event.target && event.target.getAttribute('data-imgid'));
                    var nbr_cmt = document.querySelector('p[data-imgid="' + imgid + '"]');
                    var userid = (event.target && event.target.getAttribute('data-userid'));
                    
                    var xhttp = new XMLHttpRequest();
                    var params = "imgid="+imgid+"&userid="+userid;
                    xhttp.open('POST', 'http://localhost/Camagru/Posts/dellikes');
                    xhttp.withCredentials = true;
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.onreadystatechange = function(){
                        if (this.readyState == 4 && this.status == 200){
                            nbr_cmt.innerHTML = this.responseText;
                        }    
                    }
                    xhttp.send(params);
                    event.target.className = "fa fa-heart-o";
                }
       
        }
    }
    
    
    //comment
    for(var i=0; i < comment.length; i++){ 
            comment[i].onclick = function(event){
                 var imgid = (event.target && event.target.getAttribute('data-imgid'));
                    var userid = (event.target && event.target.getAttribute('data-userid'));
                    if(userid == "")
                    { window.location.replace("http://localhost/Camagru/users/login");
                    }
                    var test = (event.target && event.target.parentElement);
                    var val = test.firstElementChild;
                    var cmnt = document.querySelector('p[data-iid="' + imgid + '"]');
                    var xhttp = new XMLHttpRequest();
                        var params = "imgid="+imgid+"&userid="+userid+"&comment="+val.value;  
                    xhttp.open('POST', 'http://localhost/Camagru/Posts/addComments');
                    xhttp.withCredentials = true;
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.onreadystatechange = function(){
                        if (this.readyState == 4 && this.status == 200){
                            location.reload();
                            
                        }    
                    }
                    xhttp.send(params);
                 
        }
    }
    
    
});  

 //----------------------------------------------------------------------------------------------------


//----------------------------------------------------------------------------------------------------
(function(){
    var video = document.getElementById('video'),
        canvas = document.getElementById('canvas');
     if (canvas == null)
        return;
     var   w = canvas.width,
        h = canvas.height,
        context = canvas.getContext('2d'),
        imagefile = document.getElementById('upFile'),
        stick = 'none',
        width = window.innerWidth,
        height = window.innerHeight,
        vendorUrl = window.URL || window.webkitURL;
        context.strokeRect(0, 0, w, h);
 
 
    navigator.getMedia =    navigator.getUserMedia ||
                            navigator.webkitGetUserMedia ||
                            navigator.mozGetUserMedia ||
                            navigator.msGetUserMedia;
 
    navigator.getMedia({
        video: true,
        audio: false
    }, function(stream){
        video.srcObject = stream;
        if(video.play())
            document.getElementById('capture').disabled = false;
 
    }, function(error){
 
    });
    
    var imgfilter = document.getElementById("img_filter");
    var radio = document.getElementsByName('stickers');
    for (var i = 0, length = radio.length; i < length; i++)
    {
        radio[i].onclick = function() {
         imgfilter.style.display = 'block';
        imgfilter.src = this.value;
        stick = imgfilter.src.replace("http://localhost/Camagru", "..");
      
      
    }
 }
 
 
    window.addEventListener('DOMContentLoaded', initImageLoder);
    function initImageLoder(){
        imagefile.addEventListener('change', handleManualUploadedFiles);
 
        function handleManualUploadedFiles(ev){
            var file = ev.target.files[0];
            handleFile(file);
        }
    }
    function handleFile(file){
        var reader = new FileReader();
        reader.onloadend = function(e){
            var tempImageStore =  new Image();
 
            tempImageStore.onload = function(ev){
                h = ev.target.height;
                w = ev.target.width;
                context.clearRect(0, 0, w , h);
                context.drawImage(ev.target, 0, 0, 400, 300);
                document.getElementById('up').disabled = false;
                document.getElementById('clear').disabled = false;
            }
            tempImageStore.src = event.target.result;
        }
        reader.readAsDataURL(file);
    }
    
    
    document.getElementById('capture').addEventListener('click', function(){
    
             if (imgfilter.src != "")
             {
                 h = canvas.height;
                 w = canvas.width;  
                 context.drawImage(video, 0, 0, w , h);
                 document.getElementById('up').disabled = false;
                 document.getElementById('clear').disabled = false;
                 
     
             }
             else {
                 alert("Choose a sticker");
             }
     
 
 
    });
    document.getElementById('up').addEventListener('click', function(){
         if (imgfilter.src != "")
             {
                saveImage();
                 reloadDIV();
               
                h = canvas.height;
                w = canvas.width; 
                context.clearRect(0, 0, w , h);
                context.strokeRect(0, 0, w, h);
               

     
             }
             else {
                 alert("Choose a sticker");
                 document.getElementById('capture').disabled = true;
             }
        
    });
    document.getElementById('clear').addEventListener('click', function(){
     h = canvas.height;
     w = canvas.width;
     context.clearRect(0, 0, w , h);
     context.strokeRect(0, 0, w, h);
 });
     
 function saveImage(){
     
     var canvasData = canvas.toDataURL("image/png");
     var params = "imgBase64="+canvasData+"&filtstick="+stick;
     var xhttp = new XMLHttpRequest();
     xhttp.open('POST', 'http://localhost/Camagru/Posts/takeImage');
    
     xhttp.withCredentials = true;
     xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
     xhttp.onreadystatechange = function()
                 {
                    if (this.readyState == 4 && this.status == 200)
                    {
                             
  
                    }
                }
    xhttp.send(params);
     
 }
 function reloadDIV () {document.getElementById("ba3").innerHTML.reload}
 })();
 //----------------------------------------------------------------------------------------------------