<?php $this->load->view('includes/head');  ?>
<div id="content">
  <div class="container"> 
        
        <div class="row">
          <article class="span12">
            <h2><?php 
            echo 'Admin Login Page';
            //echo $title; ?></h2>
	
           <div class="block-room">
              <div class="extra-wrap">
                <div class="motto">
                  <?php if(isset($message)){ echo $message; } ?>
                 <form action="<?php echo base_url(); ?>admin/login" method="post">
                  <label>Username</label>
                  <input type="text" name="username" value="<?php echo set_value('username'); ?>"><br>
                  <label>Password</label>
                  <input type="password" name="password"><br>
                  <input type="submit" name="submit" value="Login">
                 </form>
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