<?php
namespace App\Models;
use \PDO;
class Comment {
    protected $conn;
    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }
    
    public function all(int $postid)
    {
        $result = [];
         $sql ='select p.*, u.email as user_email from postscomments as p  LEFT JOIN users as u ';
         $sql .= ' on p.user_id = u.id where post_id=:postid ORDER BY datecreated DESC';
          
         $stm = $this->conn->prepare($sql);
       
          $stm->bindParam(':postid', $postid, PDO::PARAM_INT);
          
          $stm->execute();
          return $stm->fetchAll();
       
    
    }
  
    
    public function save(array $data = [])
    {
        $sql = 'INSERT INTO postscomments (email, comment,datecreated, post_id, user_id)';
        $sql .= 'values (:email, :comment,:datecreated, :post_id, :user_id)';
        
        $stm = $this->conn->prepare($sql);
        
        $stm->execute([
            'user_id' => $data['user_id'],
            'email' => $data['email'],
            'comment'=>  $data['comment'],
             'post_id'=>  $data['post_id'],
             'datecreated' =>date('Y-m-d H:i:s')
            
        ]);
        
        return $stm->rowCount();
    }
    

     public function delete(int $id)
    {
          //   
   
    
        $sql = 'DELETE FROM  POSTS  WHERE id = :id';
        
        $stm = $this->conn->prepare($sql);
         $stm->bindParam(':id',$id, PDO::PARAM_INT);
        $stm->execute();
        
              return $stm->rowCount();
         
        
        
       
    }
}
