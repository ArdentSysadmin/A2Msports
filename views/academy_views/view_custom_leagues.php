<?php
$data = './static_pages/gpa_leagues.php';
$urls = file_get_contents($data);

//if($this->is_club_admin){
?>
<!-- <form name='frm_page' action='https://a2msports.com/testclub9/events/add_league' method='POST'> -->
<div style="margin-top:10px;">
<input type="submit" class="btn-success" name="post_page" id="post_page" value=" Submit Page" />
</div>
<!-- <textarea name="txt-editor" id="txt-editor"> -->
<?php
//echo $urls;
?>
<!-- </textarea> -->
<!-- </form> -->


<div id='txt-editor'>
<section class="inner-page-wrapper course-list-wrapper tournaments-bg1">
<div class='col-md-12' align='center' style="margin-bottom:20px;"><h2> GPA Leaguess</h2></div>
  <div id='gpaevents' class="container">
    <div class="row">

	<div class="col-md-3 col-sm-6">
		<div class="course-item">
			<div class="course-img">
			<a href="#">
			<img src="https://a2msports.com/tour_pictures/default_pickleball.jpg" alt="" style="width:261px; height:157px;" />
			</a>
			</div>
			<div class="course-body">
				<div class="course-desc">
				<h4 class="course-title" style='font-size:15px;'><a href="#"><?php echo "Testing Tourny";?></a></h4>
				<p>Test description Test description Test description Test description Test description Test description Test description Test description.</p>
				</div>
			</div>
		</div><!-- Tournaments-item -->
	</div><!-- col-md-4 -->

    </div><!-- row -->
  </div>

</section>
</div>


<script src="https://cdn.ckeditor.com/ckeditor5/27.0.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create( document.querySelector( '#txt-editor' ) )
    .then( neweditor => {
		editor = neweditor;
        console.log( editor );
    } )
    .catch( error => {
        console.error( error );
    } );

document.querySelector( '#post_page' ).addEventListener( 'click', () => {
    const editorData = editor.getData();

   console.log(editorData);
} );

	//ClassicEditor.replace( 'extraAllowedContent', { customConfig: 'true' } );
</script>
<?php
//}
?>