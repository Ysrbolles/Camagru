<?php
class Post{
    private $db;
    protected $limit;
    public function __construct()
    {
        $this->db = new Database;
        $this->limit = ' LIMIT '. $start.','.$per_page;
    }

    public function addImage($info){
      $userid = $info['userid'];
      $pic = $info['imgurl'];
    echo $pic;
      $this->db->query('INSERT INTO `Img`(`userid`, `imgedate`, `imgurl`) VALUES (:userid, NOW(), :imgurl)');
      $this->db->bind(':userid', $userid);
      $this->db->bind(':imgurl', $pic);
      
      if ($this->db->execute())
          return (true);
      else
          return (false);
  }
    
    public function delImage($imgid, $userid)
    {
        $this->db->query('SELECT * FROM Img WHERE imgid = :imgid AND userid = :userid');
        $this->db->query('DELETE FROM `Img` WHERE imgid= :imgid AND userid = :userid');
        $this->db->bind(':imgid', $imgid);
        $this->db->bind(':userid', $userid);
        $row = $this->db->single();
        unlink($row->imgurl);
        $this->db->bind(':imgid', $imgid);
        $this->db->bind(':userid', $userid);
        if($this->db->execute())
        {
            return true;
        }
        else 
        {
            return false;
        }
    }

    public function getImage(){
    $this->db->query('SELECT * FROM Img JOIN `user` ON `Img`.`userid` = `user`.`id` order by imgedate desc ');
    $row = $this->db->resultSet();
    return ($row);
}
    
    public function getImagesbyUsr($userid)
    {
        $this->db->query('SELECT * FROM Img JOIN `user` ON `Img`.`userid` = `user`.`id`  WHERE user.id=:userid order by imgedate desc');
        $this->db->bind(':userid', $userid);
        $row = $this->db->resultSet();
        return ($row);
    }

    public function addLikes($data)
    {
    $imgid = $data['imgid'];
    $userid = $data['userid'];
    $this->db->query('INSERT INTO `like`(`userid`, `imgid`, `like`) VALUES(:userid, :imgid, 1)');
    $this->db->bind(':userid', $userid);
    $this->db->bind(':imgid', $imgid);
    if($this->db->execute())
    {
        $this->db->query('SELECT * FROM Img WHERE imgid='.$imgid.'');
        $row = $this->db->single();
        $n = $row->likes + 1;
        $date = $row->imgedate;
        $this->db->query('UPDATE Img SET likes=:likes,imgedate=:imgedate WHERE imgid=:imgid');
        $this->db->bind(':likes', $n);
        $this->db->bind(':imgedate', $date);
        $this->db->bind(':imgid', $imgid);
        $this->db->execute();
    }
    
    echo $n;
}
    public function dellikes($data)
    {
        $imgid = $data['imgid'];
        $userid = $data['userid'];
      
        $this->db->query("DELETE FROM `like` WHERE userid=:userid AND imgid=:imgid");
        $this->db->bind(':userid', $userid);
        $this->db->bind(':imgid', $imgid);
        if($this->db->execute())
        {
            $this->db->query('SELECT * FROM Img WHERE imgid='.$imgid.'');
            $row = $this->db->single();
            $n = $row->likes - 1;
            $date = $row->imgedate;
            $this->db->query('UPDATE Img SET likes=:likes,imgedate=:imgedate WHERE imgid=:imgid');
            $this->db->bind(':likes', $n);
            $this->db->bind(':imgedate', $date);
            $this->db->bind(':imgid', $imgid);
            $this->db->execute();
        }
        
        echo $n;
    }

    public function getlikes(){
    $this->db->query('SELECT * FROM `like`');
    $row = $this->db->resultSet();
    return ($row);
    }
    
    public function addComments($data){
        $userid = $data['userid'];
        $imgid = $data['imgid'];
        $comment = $data['comment'];
        $this->db->query("INSERT INTO `comment`(`userid`, `imgid`, `comment`, `cmntdate`) VALUES(:userid, :imgid, :comment, NOW())");
        $this->db->bind(':userid', $userid);
        $this->db->bind(':imgid', $imgid);
        $this->db->bind(':comment', $comment);
        if($this->db->execute())
        {    
            $this->db->query('SELECT * FROM Img WHERE imgid= :imgid');
            $this->db->bind(':imgid', $imgid);
            $row = $this->db->single();
            $n = $row->comments + 1;
            $date = $row->imgedate;
            $this->db->query('UPDATE Img SET comments=:comments,imgedate=:imgedate WHERE imgid=:imgid');
            $this->db->bind(':comments', $n);
            $this->db->bind(':imgedate', $date);
            $this->db->bind(':imgid', $imgid);
            $this->db->execute();
        }
        
    }
    
    public function getComments()
    {
        $this->db->query("SELECT * FROM comment JOIN user on comment.userid = user.id order by cmntdate desc");
        $row = $this->db->resultSet();
        return ($row);
    }
    
    
    public function user_by_email($imgid){
        $this->db->query('SELECT * from user join Img on Img.userid = user.id where Img.imgid = :imgid and confirmed = 1');
        $this->db->bind(':imgid', $imgid);
        $row = $this->db->single();
        return ($row);
        }

    public function imgpaginat($limitstart, $limitnbr)
        {
            $this->db->query('SELECT * FROM Img join user on user.id = Img.userid order by imgedate desc LIMIT :limitstart,:limitnbr');
            $this->db->bind(':limitstart', $limitstart);
            $this->db->bind(':limitnbr', $limitnbr);
            $row = $this->db->resultSet();
            return ($row);
        }
       
}