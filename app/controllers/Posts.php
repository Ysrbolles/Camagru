<?php
    class Posts extends Controller{
     
        private $page;
        public function __construct()
        {
            
            $this->postModel = $this->model('Post');
            $this->userModel = $this->model('User');
        }

        public function index(){
            if (!isset($_GET['page']))
            {
                $_GET['page'] = 0;

            }
            $posts = $this->pagination();
            $likes = $this->postModel->getlikes();
            $comments = $this->postModel->getComments();
            $data = [
                'title'=>'Hello '. $_SESSION['username'].'',
                'posts' => $posts['post'],
                'nbrPages' => $posts['nbrPages'],
                'likes' => $likes,
                'comments' => $comments
            ];
            
            $this->view('posts/index', $data);
            
        }
        
        public function pagination()
        {
            if(!is_numeric($_GET['page']))
                $_GET['page'] = 1;
            if($_GET['page'] == 0)
                $nbStart = 0;
            else
            {
                if($_GET['page'])
                    $nmbr = $_GET['page'];
               
                $nbStart = ($nmbr * 5) - 5;
            }
           
            $allposts = $this->postModel->getImage();
            $nbrposts = count($allposts);
            $nbrpages =  ceil($nbrposts / 5);
             $pics = ['post' =>  $this->postModel->imgpaginat($nbStart, 5),
                        'nbrPages' => $nbrpages
                        ];
                    
    
                return $pics;
           
        }
       
        
        public function image(){
           if(isset($_SESSION['id']))
           {
            $posts = $this->postModel->getImagesbyUsr($_SESSION['id']);
            $data = ['posts' => $posts];
                $this->view('posts/image', $data);
           }else
           {
                $this->view('pages/index');
           }
            
        }
        
        public function takeImage()
        {
            if(isset($_POST['imgBase64']) && isset($_POST['filtstick']))
            {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $upload_dir = "../public/imgs/";
                $img = $_POST['imgBase64'];
                $filter = $_POST['filtstick'];
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                $file = $upload_dir . mktime().'.png';
                file_put_contents($file, $data);
                $sourceImage = $filter;
                $destImage = $file;
                list($srcWidth, $srcHeight) = getimagesize($sourceImage);
                $src = imagecreatefrompng($sourceImage);
                $dest = imagecreatefrompng($destImage);
                imagecopyresized($dest, $src, 0, 0, 0, 0, 200, 200, $srcWidth, $srcHeight);
                imagepng($dest, $file, 9);
                move_uploaded_file($dest, $file);
                $dt = ['userid' => $_SESSION['id'],
                'imgurl' => $file          
                ];
                if (!empty($data)) {
                    if ($this->postModel->addImage($dt) == true) {
                        
                    }
                
                }
            }
         
        }
        public function addlikes()
        {
            if(isset($_POST['imgid']) && isset($_POST['userid']))
            {
                
                $userid = $_POST['userid'];
                $imgid = $_POST['imgid'];
                $data = ['imgid' => $imgid,
                        'userid' => $userid
                        ];
              
               if($this->postModel->addLikes($data) == true)
                   echo "liked";
               
            }
                  
        }
        
        public function dellikes()
        {
            if(isset($_POST['imgid']) && isset($_POST['userid']))
            {
                $userid = $_POST['userid'];
                $imgid = $_POST['imgid'];
                 $data = ['imgid' => $imgid,
                        'userid' => $userid
                        ];
                if($this->postModel->dellikes($data) == true)
                   echo "unliked";
            }
        }
        
        public function addComments()
        {
            if(isset($_POST['imgid']) && isset($_POST['userid']) && isset($_POST['comment']) && !empty($_POST['comment']))
                {   
                    $usr = $this->postModel->user_by_email($_POST['imgid']);
                    $to  = $usr->email;
                    $notif = $usr->notification;
                    $subject = 'Camagru notification';
                    $message = '<p>One of your photo was Commented </p>';
                    $headers = 'MIME-Version: 1.0'."\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
                    $headers .= 'To: ' . $to."\r\n";
                    if(!isset($_SESSION['id'])){
                        redirect("users/login");
                    }
                    $data = ['imgid' => $_POST['imgid'],
                        'userid' => $_POST['userid'],
                         'comment' => $_POST['comment']
                        ];
                 
                   if($this->postModel->addComments($data))
                   {
                        return true;
                       
                   }
                if($notif == 1){
                    mail($to, $subject, $message , $headers); 
                }
                 
                
               
            }
        }
        
        public function delComments()
        {
            if(isset($_POST['imgid']))
            {
                $imgid = $_POST['imgid'];
                if($this->postModel->delComment($imgid))
                {
                    return true;
                }
                else{
                    return false;
                }
            }
        }
        
        public function delImage()
        {
             if(isset($_POST['imgid']))
                  
            {  
                 $imgid = $_POST['imgid'];
              if($this->postModel->delImage($imgid, $_SESSION['id']))
                {   
                    $this->postModel->getImagesbyUsr($_SESSION['id']);
                }
                
            } 
        }
        
}
