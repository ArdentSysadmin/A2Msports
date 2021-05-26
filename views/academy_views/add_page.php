<?php
$data = './static_pages/test.php';
$urls = file_get_contents($data);
echo $urls;
//if($this->is_club_admin){
?>

<script src="https://cdn.ckeditor.com/ckeditor5/27.0.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create( document.querySelector( '#txt-editor' ) )
    .then( editor => {
        console.log( editor );
    } )
    .catch( error => {
        console.error( error );
    } );

	//ClassicEditor.replace( 'extraAllowedContent', { customConfig: 'true' } );
</script>
<?php
//}
?>