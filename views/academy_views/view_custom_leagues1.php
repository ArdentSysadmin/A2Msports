<?php
$data = './static_pages/gpa_leagues.php';
$urls = file_get_contents($data);

echo $urls;
?>

<br /><br /><br />

<!-- 
<script src="https://cdn.tiny.cloud/1/3rqnmdvu381c19sxzm18kwcxtcea11r4oamscv35xqm7trcd/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<form name='frm_page' action='https://a2msports.com/testclub9/events/add_league' method='POST'>
<div style="margin-top:10px;">
<input type="submit" class="btn-success" name="post_page" id="post_page" value=" Submit Page" />
</div>
<br />
<textarea name='txt-editor' rows='40'>
<?php //echo $urls; ?>
</textarea>
</form> -->

  <script>
   /* tinymce.init({
      selector: 'textarea',
      plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
      toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
      toolbar_mode: 'floating',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
	  content_css: ['/css/bootstrap.css', '/assets/club_pages/css/style.css'],

    });*/
     // tinymce.DOM.setOuterHTML('adc', '<div>some html</div>');

  </script>