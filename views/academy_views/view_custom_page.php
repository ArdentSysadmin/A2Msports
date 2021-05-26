<?php
if($this->logged_user == $this->academy_admin){
?>
  <script src="<?php echo base_url(); ?>ckeditor/ckeditor.js"></script>
<form name='custom_frm' action='custom_page' method='POST'>
  <textarea cols="80" id="editor1" name="editor1" rows="10" data-sample-short>
  <?php echo $page['Page_Content']; ?>
  </textarea>
  <input type='submit' name='save_page' class='form-control' value= " Save " />
  </form>
  <script>
    CKEDITOR.config.devtools_styles =
      '#cke_tooltip { line-height: 20px; font-size: 12px; padding: 5px; border: 2px solid #333; background: #ffffff }' +
      '#cke_tooltip h2 { font-size: 14px; border-bottom: 1px solid; margin: 0; padding: 1px; }' +
      '#cke_tooltip ul { padding: 0pt; list-style-type: none; }';

    CKEDITOR.replace('editor1', {
      height: 450,
      //extraPlugins: 'devtools'
    });
  </script>
  <?php
}
  else{
	  echo "<div style='margin-bottom:20px;'>";
		echo $page['Page_Content'];
	  echo "</div>";
  }
  ?>
