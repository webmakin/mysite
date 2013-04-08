<?php $this->load->view('includes/head');  ?>

<div id="content">
  <div class="container"> 
        <div class="row">
             <article class="span12">
               <div class="main-slider">
                 <div id="slider" class="nivoSlider">
				 <!--data-thumb="img/slides/slide1.jpg"-->
					<?php foreach($slideshow as $slide){ ?>
                  <img src="<?php echo base_url(); ?>img/slides/<?php echo $slide['image']; ?>" alt="" width="940px" height="550px" />  
					<?php } ?>
                </div>
               </div>
             </article>
        
        </div>
        <div class="row row-img">
          <article class="span9">
            <h2>Recent Work</h2>
            <div class="row">
              <ul class="thumbnails">
			  <?php foreach($recent as $rec){ ?>
                <li class="thumbnail span3">
                  <div class="maxheight">
                    <figure class="img-polaroid spinner"><img src="<?php echo base_url(); ?>img/<?php echo $rec['thumbnail']; ?>" alt=""></figure>
                    <a href="<?php echo base_url(); ?>get/portfolio#<?php echo $rec['id']; ?>"><?php echo $rec['title']; ?> <img src="<?php echo base_url(); ?>img/thumbnails-img.png"  alt=""><span></span></a>
                  </div>
                </li>
				<?php } ?>
               
              </ul>
            </div>
          </article>
          <article class="span3">
            <h2>Our Motto</h2>
            <section class="comments">
              <div class="motto"><?php echo $motto; ?></div>
            <div>
              
              <!--<figure class="img-polaroid"><img src="img/page-img-6.jpg" alt=""></figure>-->
              <span class="name">
                <a href="<?php echo base_url(); ?>get/portfolio">Portfolio</a>
                <span>View our full portfolio</span>
              </span>
            </div>
            </section>
          </article>
        </div>
  </div>
</div>
<?php $this->load->view('includes/foot');  ?>