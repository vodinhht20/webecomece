<?php
  include('inc/header.php');
  include_once('../helpers/format.php');
?>
<?php
  $fm = new Format();

  if(isset($_GET['id'])){
    $id = $_GET['id'];
    $del_contact = $cs->del_contact($id);
  }
?>
  <div class="panel-header">
    <div class="header text-center">
      <h2 class="title">Phản hồi từ khách hàng</h2>
    </div>
  </div>
  <div class="content">
          <div class="col-md-12">
            <div class="card">         
              <div class="card-body">
                <div class="table-responsive">
                <?php 
                    if(isset($del_contact)){
                        echo $del_contact;
                    }
                ?>
                  <table class="table">
                    <thead class=" text-primary">
                        <th>STT</th>
                        <th></th>
                        <th>Tên</th>
                        <th>Nội dung phản hồi</th>
                        <th>Email</th> 
                        <th>Thao tác</th>            
                    </thead>
                    <tbody>
                        <?php 
                            $contact_list = $cs->get_contact();
                            if($contact_list){
                                $i = 0;
                                while($result = $contact_list->fetch_assoc()){
                                    $i++;                          
                        ?> 
                          <tr>
                            <td><?php   echo $i; ?></td>
                            <td>
                                <img src="uploads/<?php   echo $result['image'];?>" width="60" style="border-radius: 50%;">
                            </td>
                            <td>
                                <?php   echo $result['name'];?>
                            </td>
                            <td><?php   echo $result['message'];?></td>
                            <td><?php   echo $result['email'];?></td>                                                     
                            <td>
                                <a onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')" 
                                    href="?id=<?php echo $result['id']; ?>"><i class="fas fa-trash" style="color: red;"></i>
                                </a>                               
                            </td>
                          </tr>
                        <?php 
                                }
                            }
                        ?> 
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
<?php include('inc/footer.php'); ?>