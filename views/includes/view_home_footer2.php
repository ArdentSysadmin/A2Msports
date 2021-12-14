 <?php
$source = base_url().'assets_new/';
?>
	 <div class="bg_fotter pt-5 pb-5">
       <div class="container-fluid">
         <div class="row">
           <div class="col-lg-6">
             <div class="heading pb-3 text-center">
               <h1>Comments / Feedback</h1>
             </div>
             <div class="row">
               <div class="col-lg-8 offset-lg-2">
                 
                     <form class="row g-3" method="POST" action="<?=base_url();?>/contact/submit">
				<?php
					if($this->session->flashdata('contact_status')){
				?>
				<script>
				var st = "<?php echo $this->session->flashdata('contact_status'); ?>";
				alert(st);
				</script>
				<?php
					}
				 ?>
                    <div class="col-md-12">
                      <input type="text" name="contact_name" class="form-control" id="inputl4" placeholder="Full Name" required>
                    </div>
                    <div class="col-md-12">
                      <input type="email" name="contact_email"class="form-control" id="inputEmail4" placeholder="Email Address" required>
                    </div>
                    <div class="col-12">
                      <textarea name="contact_message" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Add Your Message (optional)" required></textarea>
                    </div>
                    
                      <div class="form-group">
							<div class="g-recaptcha" data-sitekey="6LcmImgdAAAAAB70ZsDd9SBMA5JXNlFGwcttZv76"></div>
                            <!-- <input name='recaptcha' class="form-control d-none" data-recaptcha="true" required data-error="Please complete the Captcha">
                            <div class="help-block with-errors"></div> -->
                        </div>
                    <div class="col-12">
                      <input name="contact_submit" type="submit" class="btn btn_orange w-100 pt-2 pb-2" value="Submit" />
                    </div>

                  </form>


               </div>
             </div>
           </div>
           <div class="col-lg-6">
             <div class="heading pb-3 text-center" style="padding-top: 10px;">
               <h1>Contact Us</h1>
             </div>
             <div class="row">
               <div class="col-lg-8 offset-lg-2">
                 <div class="contact d-flex justify-content-center align-items-center">
                   <p><a href="tel: 1678654 3778" style="text-decoration: none;"><img src="<?=base_url()."assets_new/";?>images/phone.png" >
                   +1 (678) 654 3778</a></p>
                 </div>
                 <div class="socil text-center">
                   <a href="https://www.facebook.com/a2msports" target="_blank">
					<img src="<?=base_url()."assets_new/";?>images/Facebook.png"></a>
                   <a href="https://twitter.com/a2m_sports" target="_blank">
					<img src="<?=base_url()."assets_new/";?>images/TwitterLogo.png"></a>
                   <a href="https://www.instagram.com/a2msports" target="_blank">
					<img src="<?=base_url()."assets_new/";?>images/InstagramLogo.png"></a>
                 </div>
                 


               </div>
             </div>
           </div>
         </div>
       </div>
     </div>
     <div class="copyright pt-4 pb-4">
       <div class="container-fluid">
         <div class="row">
           <div class="col-lg-12">
             <p class="text-center text-light mb-0">Copyright � 2021 A2M Sports. All Rights Reserved.</p>
           </div>
         </div>
       </div>
     </div>

      <!-- popup start -->
     <div id="popup1" class="overlay">
  <div class="popup">
    <h2>Contact Us</h2>
    <a class="close" href="#">&times;</a>
    <div class="content">
                     <form class="row g-3" method="POST" action="<?=base_url();?>/contact/submit">
				<?php
					if($this->session->flashdata('contact_status')){
				?>
				<script>
				var st = "<?php echo $this->session->flashdata('contact_status'); ?>";
				alert(st);
				</script>
				<?php
					}
				 ?>
                    <div class="col-md-12">
                      <input type="text" name="contact_name" class="form-control" id="inputl4" placeholder="Full Name" required>
                    </div>
                    <div class="col-md-12">
                      <input type="email" name="contact_email"class="form-control" id="inputEmail4" placeholder="Email Address" required>
                    </div>
                    <div class="col-12">
                      <textarea name="contact_message" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Add Your Message (optional)" required></textarea>
                    </div>
                    
                      <div class="form-group">
							<div class="g-recaptcha" data-sitekey="6LcmImgdAAAAAB70ZsDd9SBMA5JXNlFGwcttZv76"></div>
                            <!-- <input name='recaptcha' class="form-control d-none" data-recaptcha="true" required data-error="Please complete the Captcha">
                            <div class="help-block with-errors"></div> -->
                        </div>
                    <div class="col-12">
                      <input name="contact_submit" type="submit" class="btn btn_orange w-100 pt-2 pb-2" value="Submit" />
                    </div>

                  </form>

    </div>
  </div>
</div>
      <!-- popup start end-->


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
    <script>
            $(document).ready(function() {
              var owl = $('#feature');
              owl.owlCarousel({
                margin: 50,
                nav: true,
                loop: true,
                responsive: {
                  0: {
                    items: 1
                  },
                  600: {
                    items: 3
                  },
                  1000: {
                    items: 3
                  }
                }
              })
            })
          </script>




      <script>
            $(document).ready(function() {
              var owl = $('#Testimonials');
              owl.owlCarousel({
                margin: 50,
                nav: true,
                loop: true,
                responsive: {
                  0: {
                    items: 1
                  },
                  600: {
                    items: 3
                  },
                  1000: {
                    items: 3
                  }
                }
              })
            })
          </script>
          <script>
            $(document).ready(function() {
              var owl = $('#Testimonials1');
              owl.owlCarousel({
                margin: 50,
                nav: true,
                loop: true,
                responsive: {
                  0: {
                    items: 1
                  },
                  600: {
                    items: 3
                  },
                  1000: {
                    items: 3
                  }
                }
              })
            })
          </script>
<script>
            $(document).ready(function() {
              var owl = $('#company');
              owl.owlCarousel({
                margin: 50,
                nav: true,
                loop: true,
                responsive: {
                  0: {
                    items: 1
                  },
                  600: {
                    items: 3
                  },
                  1000: {
                    items: 5
                  }
                }
              })
            })
          </script>
    <script>
    
    $(document).ready(function(){
        $('.customer-logos').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 1500,
            arrows: false,
            dots: false,
            pauseOnHover:false,
            responsive: [{
                breakpoint: 768,
                setting: {
                    slidesToShow:4
                }
            }, {
                breakpoint: 520,
                setting: {
                    slidesToShow: 3
                }
            }]
        });
    });

    </script>
          <script src="<?=$source;?>js/highlight.js"></script>
    <script src="<?=$source;?>js/app.js"></script>
    <script src="https://kit.fontawesome.com/140af656c6.js" crossorigin="anonymous"></script>
  </body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src="<?=$source;?>validator.js"></script>
    <script src="<?=$source;?>contact.js"></script>

<script type="text/javascript">
   $(document).ready(function(){
    $('.customer-logos').slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1500,
        arrows: false,
        dots: false,
        pauseOnHover: false,
        responsive: [{
            breakpoint: 768,
            settings: {
                slidesToShow: 4
            }
        }, {
            breakpoint: 520,
            settings: {
                slidesToShow: 3
            }
        }]
    });
});
     var index = 0;
var slides = document.querySelectorAll(".slides");
var dot = document.querySelectorAll(".dot");

function changeSlide(){

  if(index<0){
    index = slides.length-1;
  }
  
  if(index>slides.length-1){
    index = 0;
  }
  
  for(let i=0;i<slides.length;i++){
    slides[i].style.display = "none";
    dot[i].classList.remove("active");
  }
  
  slides[index].style.display= "block";
  dot[index].classList.add("active");
  
  index++;
  
  setTimeout(changeSlide,3000);
  
}

changeSlide();

window.document.onkeydown = function(e) {
  if (!e) {
    e = event;
  }
  if (e.keyCode == 27) {
    lightbox_close();
  }
}

function lightbox_open() {
  var lightBoxVideo = document.getElementById("VisaChipCardVideo");
  window.scrollTo(0, 0);
  document.getElementById('light').style.display = 'block';
  document.getElementById('fadevedio').style.display = 'block';
  lightBoxVideo.play();
}

function lightbox_close() {
  var lightBoxVideo = document.getElementById("VisaChipCardVideo");
  document.getElementById('light').style.display = 'none';
  document.getElementById('fadevedio').style.display = 'none';
  lightBoxVideo.pause();
}
document.addEventListener("DOMContentLoaded", function(){
  // add padding top to show content behind navbar
  navbar_height = document.querySelector('.navbar').offsetHeight;
  document.body.style.paddingTop = navbar_height + 'px';
}); 
</script>