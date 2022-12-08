<?php 
    include('inc/header.php');
    include('../classes/blog.php');
?>
<?php
  $blog = new blog();

  if(isset($_GET['id'])){
    $id = $_GET['id'];
    $get_blog_by_id = $blog->getblogbyId($id);
  }
?>    
    <div class="panel-header">
      <div class="header text-center">
        <h2 class="title">Chi tiết tin tức</h2>
      </div>
    </div>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
            <?php 
                if($get_blog_by_id){
                    $result = mysqli_fetch_assoc($get_blog_by_id);
                }
            ?>
              <h4 class="card-title"><?php echo $result['title']; ?></h4>            
               <table>
                   <tr>
                       <td>Mô tả ngắn:</td>
                       <td><?php echo $result['description']; ?></td>
                   </tr>
                   <tr>
                       <td>Ngày đăng:</td>
                       <td><?php echo $result['date'].'-'.$result['year'] ; ?></td>
                   </tr>
                   <tr>
                       <td>Hình ảnh:</td>
                        <td style="text-align: center;">
                            <img src="uploads/<?php   echo $result['image'];?>" width="700">
                        </td>
                   </tr>
                   <tr>
                       <td>Nội dung:</td>
                       <td><?php echo $result['content']; ?></td>
                   </tr>
               </table>
            </div>
          </div>
        </div>
      </div>
    </div>   
    <?php include('inc/footer.php'); ?>