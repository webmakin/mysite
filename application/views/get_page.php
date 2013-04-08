<?php $this->load->view('includes/head');  ?>
<div id="content">
  <div class="container"> 
        
        <div class="row">
          <article class="span12">
            <h2><?php echo $title; //echo '<pre>'; var_dump($similar); ?></h2>
	
           <div class="block-room">
              <figure class="img-polaroid fright"><a href="<?php echo base_url(); ?>img/<?php echo $the_data['thumbnail']; ?>" class="magnifier"><img src="<?php echo base_url(); ?>img/<?php echo $the_data['thumbnail']; ?>" alt=""></a></figure>
              <div class="extra-wrap">
                <div class="motto">
                 <?php echo $the_data['article']; ?>
                </div>
              </div>
            </div>

          </article> 
        </div>
		
        <!-- similar pages -->
		<?php $this->load->view('includes/similar_pages'); ?>

          </article>
        </div>
  </div>
</div>
<?php $this->load->view('includes/foot');  ?>