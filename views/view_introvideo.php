  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="padding: 9px; border-bottom: 0px solid #e5e5e5;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding: 7px;">
		<video class="video-js vjs-default-skin vjs-paused vjs-controls-enabled vjs-user-inactive" controls width="100%" poster="<?=base_url();?>images/video.jpg" data-setup="{}">
		<source src="<?=base_url();?>images/a2m1.mp4" type="video/mp4" />
		<source src="<?=base_url();?>images/a2m1.ogg" type="video/ogg" />
		<source src="<?=base_url();?>images/a2m1.webm" type="video/webm" />

		<track kind="captions" src="demo.captions.html" srclang="en" label="English"></track>
		<!-- Tracks need an ending tag thanks to IE9 -->
		<track kind="subtitles" src="demo.captions.html" srclang="en" label="English"></track>
		<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
		</video>
      </div>
     
    </div>
  </div>