<script>
 $(document).ready(function (){
    $(".club_page").change(function () { //use change event
        if (this.value == "1") { //check value if it is domicilio
            $('#club').show(); //than show
        } else {
            $('#club').hide(); //else hide
        }
    });
});
</script>


<script type="text/javascript">
    $(document).ready(function(){
		var count = 0;
        $("#add_club").click(function(){
			count =count +1;
			//alert(count);
			if(count < 5){
          //  $("#club").append("<li>list item <a href='javascript:void(0);' class='remove'>×</a></li>"); 
			$("#club").append("<div class='col-md-6'><input name='club_name[]' class='' type='text'/></div> <div class='col-md-6'><input name='club_id[]' class='' type='text'/></div> ");
			
			}
			else
			{
			 alert("Can't add more");
			 return false;
			}
			
        });
        $(document).on("click", "a.remove" , function() {
            $(this).parent().remove();
        });
    });
</script>



	
<section id="single_player" class="container secondary-page">

<div class="top-score-title right-score col-md-9">

<!-- start main body -->
<div class="col-md-12 league-form-bg" style="margin-top:40px;">
<div class="fromtitle">Add Match Score</div>
<p style="line-height:20px; font-size:13px">You played a match without actually creating or registering it, you can still add it to your profile here.

</div>



<!-- ------------------------------------------------Upload Tournament Images----------------------------------------------------  -->   

<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px;" id="div5">
<div class="fromtitle">Upload Tournament Images</div>

<form method='post' enctype='multipart/form-data' action="<?php echo base_url(); ?>test/upload_new" role='form' >
<div class='file_upload' id='f1'><input name='userfile[]' type='file' multiple='multiple' onchange='readURL(this);'/></div>
<br />

<br />
<input type='hidden' name='tourn_id' value="">
<input type='submit' name='upload_image' value='Upload' class="league-form-submit1"/>
</form>

</div>

<!-- ----------------------------------------------------------------------------------------------------  --> 

</div>
</section>






