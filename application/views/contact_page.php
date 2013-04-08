<?php $this->load->view('includes/head');  ?>

<div id="content">
  <div class="container">     
        <div class="row"> 
		<?php //echo '<pre>'; var_dump($address); ?>
          <article class="span4">
            <h2><?php echo $title ?></h2>
            <div class="div-adress">
              <address class="adress">
                <strong class="title1">
                  Address:
                </strong>
                <em>
                  <?php foreach($address as $addr){ ?>
				  <span>
						<?php echo $addr; ?>
                  </span>
				  <?php } ?>
                </em>
                <em>
                  <strong class="title1">Telephone: </strong>
				  <?php foreach($phone as $ph){ ?>
				  <span>
						<?php echo $ph; ?>
                  </span>
				  <?php } ?>
				</em>
				
				<em>
                  <strong class="title1">Email: </strong>
                  <?php foreach($email as $ema){ ?>
				  <span>
						<?php echo $ema; ?>
                  </span>
				  <?php } ?>
                </em>
                
              </address>
            </div>

          </article>
          <article class="span8">
		  <h2 id="error"></h2>	
            <h2>Quote or Feedback</h2>
            <form id="contact-form" action="<?php echo base_url(); ?>home/save" method="post">
              <fieldset>
                <div>
                  <div class="coll-1">
                    <div class="txt-form">Name*</div>
                    <label class="name">
                      <input type="text" name="name" value="<?php echo set_value('name'); ?>">
                      <br>
                       </label>
                  </div>
                  <div class="coll-2">
                    <div class="txt-form">E-mail*</div>
                    <label class="email">
                      <input type="email" name="email" value="<?php echo set_value('email'); ?>">
                      <br>
                      </label>
                  </div>
                  <div class="coll-3">
                    <div class="txt-form">Phone</div>
                    <label class="phone notRequired">
                      <input type="text" name="phone" value="<?php echo set_value('phone'); ?>">
                      <br>
                      </label>
                  </div>
                </div>
                
                <div class="div-message">
                  <div class="txt-form">Message*</div>
                  <label class="message">
                    <textarea name="message"><?php echo set_value('message'); ?></textarea>
                    <br>
                   
                  </label>
                </div>
                <div class="buttons-wrapper">
				<!-- <a class="link" data-type="submit">Submit</a> -->
				<input type="submit" name="submit" value="Submit">
				</div>
              </fieldset>
            </form>

          </article>
        </div>
  </div>
</div>
<?php $this->load->view('includes/foot');  ?>