<?php include "header.php"; 




?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12">
                  <table class="content-table">   
                  
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>

                      <?php

                            $limit = 5;

                            if(isset($_GET['page'])){
                                $page = $_GET['page'];
                            }
                            else{
                                $page= 1;
                            }

                            $offset = ($page -1) * $limit;

                      if($_SESSION["user_role"]== 1){
                        
                        
                            include "config.php";
                            $sql = "SELECT * FROM  post 
                            LEFT JOIN category ON post.category = category.category_id 
                            LEFT JOIN user ON post.author = user.user_id
                            
                            ORDER BY post.post_id DESC LIMIT {$offset},{$limit} ";
                            $result = mysqli_query($conn , $sql) or die("failed");
                            

                        }if ($_SESSION["user_role"] == 0) {
                            include "config.php";
                            $sql = "SELECT * FROM  post 
                            LEFT JOIN category ON post.category = category.category_id 
                            LEFT JOIN user ON post.author = user.user_id
                            WHERE post.author = {$_SESSION['user_id']}
                            ORDER BY post.post_id DESC ";
                            $result = mysqli_query($conn , $sql) or die("failed");
                        } 
                        if(mysqli_num_rows($result)>0){
                            $serial = $offset +1; 
                            while ($row = mysqli_fetch_assoc($result)){
                         ?>
                      <tbody>
                    
                          <tr>
                              <td class='id'><?php echo $serial; ?></td>
                              <td><?php echo $row['title']; ?></td>
                              <td><?php echo $row['category_name']; ?></td>
                              <td><?php echo $row['post_date']; ?></td>
                              <td><?php echo $row['username']; ?></td>
                              <td class='edit'><a href='update-post.php?id=<?php echo $row['post_id'] ?> '><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-post.php?id=<?php echo $row['post_id'] ?>&catid=<?php echo $row['category_id']?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                         <?php
                            $serial++;
                          }
                          
                         }
                        ?>  
                      </tbody>
                  </table>
                  <?php

                $sql1 = "SELECT * FROM  post";
                $result1 = mysqli_query( $conn , $sql1) or die ("query failed");
                if(mysqli_num_rows($result1)>0){
                    $total_record= mysqli_num_rows($result1);
                    $total_page = ceil($total_record / $limit);


           


            ?>

                  <ul class='pagination admin-pagination'>
                <?php
                
                
                if($page>1){

                
                echo '<li><a href="post.php?page='.($page - 1 ).'">Prev</a></li>';
                  }
 
                for($i = 1 ; $i <= $total_page; $i++  ){

                    if($i==$page){
                        $active = "active";
                    }
                    else{
                        $active = "";
                    }
                        echo '<li class="'.$active.'"><a href="post.php?page='.$i.'"> '.$i.'</a></li> ';
                }

                if($total_page > $page){

                
                    echo '<li><a  href="post.php?page='.($page + 1 ).'" >Next</a></li>';
                      }
                ?>
                  
                </ul>


<?php }?>
                
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
