<?php $this->load->view('includes/head');  ?>
<div id="content">
  <div class="container"> 
        
        <div class="row">
          <article class="span12">
            <h2><?php echo $title; ?></h2>
		<?php 
		foreach($the_data as $key=>$value){ ?>
            <div class="block-room">
              <figure class="img-polaroid <?php if(($key==0)||($key%2==0)){ echo 'fright'; } else{ echo 'fleft'; } ?>">
				<a href="<?php echo base_url(); ?>img/<?php if(isset($value['image'])){ echo $value['image']; } else{ echo $value['thumbnail']; } ?>" class="magnifier">
				 <img src="<?php echo base_url(); ?>img/<?php echo $value['thumbnail']; ?>" alt="">
				</a>
			  </figure>
              <div class="extra-wrap">
                <div>
                  <h3><a <?php if(isset($value['image'])){ echo 'name="'.$value['id'].'"'; } else{ echo 'href="'.base_url().'page/'.$value['id'].'"'; } ?> ><?php echo $value['title']; ?></a></h3>
                  <div class="motto"><?php echo $value['article']; ?></div>
                </div>
              </div>
            </div>
		<?php } ?>
          		
          </article> 
        </div>
		
        <!-- similar pages -->

          </article>
        </div>
  </div>
</div>
<?php $this->load->view('includes/foot');  ?>