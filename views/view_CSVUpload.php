<?php if($this->session->flashdata('message')){?>
          <div align="center" class="alert alert-success">      
            <?php echo $this->session->flashdata('message')?>
          </div>
        <?php } ?>

<br><br>

<div align="center">
<form action="<?=base_url(); ?>usatt_ratings/csv_import" 
method="post" name="upload_excel" enctype="multipart/form-data">
<input type="file" name="file" id="file">
<button type="submit" id="submit" name="import">Import</button>
</form>
<br>
<br>

</div>