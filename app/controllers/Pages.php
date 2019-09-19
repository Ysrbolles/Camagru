<?php
  class Pages extends Controller {
    public function __construct(){
     $this->postModel = $this->model('Post');
    }
    public function index()
    {
     $posts = $this->postModel->getImage();
    $likes = $this->postModel->getlikes();
            $comments = $this->postModel->getComments();
            $data = [
                'title'=>'Hello '. $_SESSION['username'].'',
              'posts' => $posts,
                'likes' => $likes,
                'comments' => $comments
            ];
     
      $this->view('pages/index', $data);
    }
    public function about(){
      $data = ['title'=>'Yassir Bolles'];
      $this->view('pages/about', $data);
    }
    
  }