<div class="row row-tabs">
          <article class="span12">
            <h2>Similar</h2>
                <div class="list_carousel responsive"> 
                  <ul class="list-rooms" id="foo1">
                    <?php  foreach($similar as $key=>$value){ ?>
					<li>
                      <div class="other-room">
                        <figure class="img-polaroid"><img src="<?php echo base_url(); ?>img/<?php echo $value['thumbnail']; ?>" alt=""></figure>
                        <a href="<?php echo base_url(); ?>page/<?php echo $value['page_id']; ?>"><?php echo $value['title']; ?></a>
                      </div>
                    </li>
                    <?php } ?>
					
                  </ul>
                  <div class="clearfix"></div>
                  <div class="div-control">
                    <a href="#" id="prev2"></a>
                    <a href="#" id="next2"></a>
                  </div>
                </div>