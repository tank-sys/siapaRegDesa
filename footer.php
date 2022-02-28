<?php defined('web') or die ("Gak intuk akses langsung");?>

</div>
</main>
<footer class="footer mt-auto py-2 pb-0 mb-0 bg-light">
  <div class="container d-flex justify-content-between" style="width: 100%;">
        <div class="mr-auto p-2"><small class="fst-italic">Update Hari 
        <?php
        $r = explode(" ", $ident['last_kons']);
        $h = date('w', strtotime($r[0]));
        echo $hari[$h]. ", ";

        echo bulan($r[0]). " Pukul ".$r[1];?>
</small>        </div>  
<div class="p-2" >
    <?php echo uckata($ident['nama_kel']);?> &#169; <a href="#" class="text-dark"><?php echo date("Y", strtotime($ident['last_kons']));?></a>
</div>

  </div>
</footer>

<?php
echo $jsawal;
?>

  </body>
</html>