<?php $this->load->view('includes/head');  ?>
<div id="content">
  <div class="container"> 
        
        <div class="row">
          <article class="span12">
            <h2><?php 
            echo 'Welcome to Admin Page';
            //echo $title; ?></h2>
	
           <div class="block-room">
              <div class="extra-wrap">
                <div class="motto">
                   <?php if(isset($message)){ echo $message; } ?>
                  <!-- show the admin functions -->
                </div>
              </div>
            </div>

          </article> 
        </div>
		

          </article>
        </div>
  </div>
</div>
<?php $this->load->view('includes/foot');  ?>