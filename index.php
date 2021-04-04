<?php
    //koneksi db
    $server = "localhost:8081";
    $user   = "root";
    $pass   = "";
    $database ="fazztrack";
    

    $koneksi = mysqli_connect($server,$user,$pass, $database) or die (mysqli_error($koneksi));
    
    //// create
    if(isset($_POST['bsimpan']))
    {
     //// pengujian data akan disimpan baru atau di edit   
    if($_GET['hal'] == "edit")
    {
        //// data akan di edit
        $edit = mysqli_query($koneksi,"UPDATE  product set
                             nama_produk = '$_POST[tnama_produk]', 
                             keterangan =  '$_POST[tketerangan]',
                             harga      = '$_POST[tharga]',
                             jumlah    =  '$_POST[tjumlah]'
                             WHERE id = '$_GET[id]'
                              ");
    
    if ($edit)//edit sukses
    {
        echo 
             "<script> 
               alert('edit sukses');
               document.location='index.php';
             </script>";
    } else {
        echo "<script> 
              alert('edit gagal');
              document.location='index.php';
            </script>";
        }
    }
        
    } else {
        //data akan di simpan baru
        $simpan = mysqli_query($koneksi,"INSERT INTO product 
                              (nama_produk, keteraangan, harga,jumlah)
                                        VALUES ('$_POST[tnama_produk]', 
                                        ' $_POST[tketerangan]',
                                        ' $_POST[tharga]',
                                        ' $_POST[tjumlah]')
                                        ");
    
    if ($simpan)
    {
        echo 
             "<script> 
               alert('simpan sukses');
               document.location='index.php';
             </script>";
    } else {
        echo "<script> 
              alert('simpan gagal');
              document.location='index.php';
            </script>";
        }
    }


///pengujian edit dan hapus
    if(isset($_GET['hal']))
    {
        //pengujian data edit / simpan baru
    if ($_GET['hal'] =="edit")
        {  
            /// TAMPILAN akan EDIT DATA
            $tampil = mysqli_query($koneksi,"SELECT * FROM product WHERE id = '$_GET[id]'");
            $data = mysqli_fetch_array($tampil);
    if ($data)
       {
           $vnp = $data['nama_produk'];
           $vket = $data['keterangan'];
           $vharga = $data['harga'];
           $vjml = $data['jumlah'];
        }
    }else if($_GET['hal'] == "hapus")
    {
        $hapus = mysqli_query($koneksi,"DELETE FROM product WHERE id = '$_GET[id]'");
        if ($hapus){
            echo "<script> 
                  alert('hapus sukses');
                  document.location='index.php';
                  </script>";
        }
      }
    }
?>


<!DOCTYPE html>
<html>
  <head>
    <title> fazztrack</title>
    <link rel ="stylesheet" type="text/css" href ="css/bootstrap.min.css">

    <body>
    <div class="container">
    <h1 class = "text-center">CRUD PHP & MYSQL BOOTSTRAP 5</h1>
    <h4 class = "text-center">CRUD PHP & MYSQL BOOTSTRAP 5</h4>

    <!-- card -->
    <div class="card mt-3">
  <div class="card-header bg-primary text-white">
    Form data fazztrack
  </div>
  <div class="card-body">
  <form method="post" action="">
       <div class="form-group">
           <label> nama_produk</label>
            <input type ="text" name="tnama_produk" value="<?=$vnp?>"class="form-control" placeholder="input nama_produk" required>
        </div>
        <div class="form-group">
           <label> Keterangan</label>
            <input type ="text" name="tketerangan" value="<?=@$vket?>"class="form-control" placeholder="input keterangan" required>
        </div>
        <div class="form-group">
           <label> Harga</label>
            <input type ="text" name="tharga"value="<?=@$vharga?>" class="form-control" placeholder="input harga" required>
        </div>
        <div class="form-group">
           <label> jumlah</label>
            <input type ="text" name="tjumlah"value="<?=@$vjml?>" class="form-control" placeholder="input jumlah" required>
        </div>

        <button type="submit" class="btn btn-success" name = "bsimpan">Simpan</button>
        <button type="reset" class="btn btn-danger" name = "breset">kosongkan</button>
     </form>
   </div>
</div>
<!-- akhir card form -->

</div>

<!-- awal table -->
<div class="card mt-3">
  <div class="card-header bg-success text-white">
    Form data fazztrack
  </div>
  
  <div class="card-body">
  <table class="table table-bordered table stripes">
     <tr>
       <th>No.</th>
       <th>nama_produk</th>
       <th>keterangan</th>
       <th>harga</th>
       <th>jumlah</th>
     </tr>
       <?php 
           $no=1;
           $tampil = mysqli_query($koneksi, "SELECT * FROM product order by id desc");
           while($data = mysqli_fetch_array($tampil)):
        ?>
     <tr>
       <td><?=$no++;?></td>
       <td><?=$data['nama_produk']?></td>
       <td><?=$data['keterangan']?></th>
       <td><?=$data['harga']?></td>
       <td><?=$data['jumlah']?></td>   
       <td> <a href="index.php?hal=edit&id=<?=$data['id']?>"class = "btn btn-warning">edit</a></td>  
       <td> <a href="index.php?hal=hapus&id=<?=$data['id']?>" onclick="return confirm('anda akan menghapus?')"class = "btn btn-danger">Hapus</a></td>  
    </tr>
<?php endwhile; ?>
  </table>

   </div>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    </body>
  </head>
</html>