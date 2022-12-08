<?php 
  include('inc/header.php');
  include('../classes/category.php');
  include('../classes/brand.php');
  include('../classes/product.php');
?>
<?php 
    $pd = new product();
    if(!isset($_GET['productid']) || $_GET['productid']==NULL){
        echo "<script>window.location='productlist.php' </script>";    //script trả về lại trang 
     }else{
         $id = $_GET['productid'];
     } 
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){

      $updateProduct = $pd->update_product($_POST,$_FILES,$id);
    }

?>
   <div class="panel-header">
      <div class="header text-center">
        <h2 class="title">Sản phẩm</h2>
      </div>
    </div>
    <div class="content">
      <div class="row">
        <div class="col-md-10">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Chỉnh sửa sản phẩm</h4>
                <form action="" method="POST" enctype="multipart/form-data">            
                  <table class="table">
                        <tr>
                          <td colspan="2">
                              <?php
                                  if(isset($updateProduct)){
                                    echo $updateProduct;
                                  }
                              ?>
                              <?php 
                                $get_product_by_id = $pd->getproductbyId($id);
                                if($get_product_by_id){
                                    while($result_product = $get_product_by_id->fetch_assoc()){
                              ?>
                          </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Tên sản phẩm</label>
                            </td>
                            <td>
                                <input type="text" name="productName" value="<?php echo $result_product['productName']; ?>" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Số lượng</label>
                            </td>
                            <td>
                                <input type="number" name="amount" value="<?php echo $result_product['amount']; ?>" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Danh mục sản phẩm</label>
                            </td>
                            <td>
                                <select id="select" name="category" class="form-control">
                                        <option>-----Danh mục sản phẩm-----</option>
                                    <?php
                                      $cat = new category();
                                      $catlist = $cat->show_category();
                                      if($catlist){
                                        while($result = $catlist->fetch_assoc()){                                        
                                    ?>
                                        <option
                                            <?php if($result['catId']==$result_product['catId']){  echo 'selected';   } ?>
                                            value="<?php echo $result['catId'] ?>"><?php echo $result['catName'] ?></option>
                                    <?php 
                                        }
                                      }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Thương hiệu sản phẩm</label>
                            </td>
                            <td>
                                <select id="select" name="brand" class="form-control">
                                      <option>-----Thương hiệu sản phẩm-----</option>
                                    <?php
                                      $brand = new brand();
                                      $brandlist = $brand->show_brand();
                                      if($brandlist){
                                        while($result = $brandlist->fetch_assoc()){                              
                                    ?>
                                      <option
                                        <?php if($result['brandId']==$result_product['brandId']){ echo 'selected'; } ?>      
                                        value="<?php echo $result['brandId'] ?>"><?php echo $result['brandName']; ?></option>
                                    <?php
                                        }
                                      }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Mô tả ngắn</label>
                            </td>
                            <td>
                              <textarea class="form-control" rows="5" name="short_desc">
                                <?php echo $result_product['short_desc']; ?>
                              </textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Mô tả sản phẩm</label>
                            </td>
                            <td>
                                <textarea id="editor1" name="product_desc">
                                      <?php echo $result_product['product_desc']; ?>
                                </textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Thông số sản phẩm</label>
                            </td>
                            <td>
                                <textarea id="editor2" name="parameter">
                                    <?php echo $result_product['parameter']; ?>
                                </textarea>
                            </td>
                        </tr>
                        <tr>
                          <td>
                            <label>Loại sản phẩm </label>
                          </td>
                          <td>
                             <select id="select" name="type" class="form-control">
                                <option>Loại sản phẩm</option>
                                <?php
                                    if($result_product['type']==0){
                                ?>
                                <option selected value="0">Không nổi bật</option>
                                <option value="1">Nổi bật</option>
                                <option value="2">Sản phẩm mới</option>
                                <?php
                                    }elseif($result_product['type']==1){
                                ?>
                                <option value="0">Không nổi bật</option>
                                <option selected value="1">Nổi bật</option>
                                <option value="2">Sản phẩm mới</option>
                                <?php 
                                    }else{ 
                                ?>                               
                                <option value="0">Không nổi bật</option>
                                <option value="1">Nổi bật</option>
                                <option selected value="2">Sản phẩm mới</option>
                                <?php 
                                    }
                                ?>                                    
                              </select>
                          </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Giá tiền</label>
                            </td>
                            <td>
                                <input type="text" value="<?php echo $result_product['price']; ?>" name="price" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Giá khuyến mãi</label>
                            </td>
                            <td>
                                <input type="text" value="<?php echo $result_product['priceSale']; ?>" name="priceSale" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td>
                              <label>Hình ảnh sản phẩm</label>
                            </td>
                            <td>
                                <img src="uploads/<?php   echo $result_product['image'];?>" width="150"><br><br>
                                <input type="file" name="image">
                            </td>
                        </tr>
                        <tr>
                            <td>
                              <label>Hình ảnh sản phẩm 1</label>
                            </td>
                            <td>
                              <img src="uploads/<?php   echo $result_product['image1'];?>" width="150"><br><br>
                              <input type="file" name="image1">
                            </td>
                        </tr> 
                        <tr>
                            <td>
                              <label>Hình ảnh sản phẩm 2</label>
                            </td>
                            <td>
                              <img src="uploads/<?php   echo $result_product['image2'];?>" width="150"><br><br>
                              <input type="file" name="image2">
                            </td>
                        </tr>                                                       
                  </table>
                  <div style="text-align: center;">
                      <button type="submit" name="submit" class="btn btn-primary">Chỉnh sửa sản phẩm</button>
                  </div>                    
              </form>
                <?php 
                        } 
                    }            
                ?>  
            </div>
          </div>
        </div>
      </div>
    </div>   
<?php include('inc/footer.php'); ?>