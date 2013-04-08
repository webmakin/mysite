 <?php //echo '<pre>'; var_dump($nav); ?>
 <div class="navbar navbar_ clearfix">
            <div class="navbar-inner">      
                  <div class="clearfix">
                  	<h1 class="brand">
					<a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>img/<?php echo $logo; ?>" alt=""></a>
					<span></span></h1> 
                  	<div class="nav-collapse nav-collapse_ collapse">	
                    <a href="#"></a>
                  	    <ul class="nav sf-menu clearfix sf-js-enabled">
						<?php foreach($nav as $key=>$value){  ?>
						  	<li <?php 
								echo 'class="';
								if(isset($nav[$key]['subs'])){ echo 'sub-menu'; }
								echo ' ';	
								if($this->uri->segment(1)===strtolower($value['title'])){ echo 'active'; }
								if(($value['title']==='home')&&($this->uri->segment(1)=='')){
									echo 'active';
								}
								echo '"';
							?>><a href="<?php echo base_url().'get/'.$value['link']; ?>"><?php echo $value['title']; ?><span>...<?php echo $value['subtitle']; ?></span></a>
							<?php if(isset($nav[$key]['subs'])){
								//show the subnav
								echo '<ul class="sub-menu" style="display: none;">';
								foreach($nav[$key]['subs'] as $newk => $newv){ ?>
									 <li class="sub-menu-1"><a href="<?php echo base_url(); ?>page/<?php echo $newv['page_id']; ?>"><?php echo $newv['title']; ?></a>
									 	<?php if(isset($nav[$key][$newk]['super_subs'])){ ?>
										<ul class="sub-menu" style="display: none;">
										<?php foreach($nav[$key][$newk]['super_subs'] as $keyy => $vvalue){ ?>	
										  <li><a href="<?php echo base_url(); ?>page/<?php echo $vvalue['page_id']; ?>"><?php echo $vvalue['title']; ?></a></li>
										 <?php } ?>
										</ul>															 
										<?php } ?>
									 <li>
								<?php	 
								}	
								echo '</ul>';
							} ?>
							
							</li>
						<?php	} ?>
                  	      
                  	    </ul>
						<select style="display: inline-block;" class="select-menu">
						<option value="#">Navigate to...</option>
						<?php foreach($nav as $key=>$value){  ?>
						 <option value="<?php echo base_url().'get/'.$value['link']; ?>"><?php echo $value['title']; ?> ...<?php echo $value['subtitle']; ?></option>
						 <?php if(isset($nav[$key]['subs'])){
									foreach($nav[$key]['subs'] as $newk => $newv){
						 ?>
							<option value="<?php echo base_url(); ?>page/<?php echo $newv['page_id']; ?>">––<?php echo $newv['title']; ?></option>
								<?php if(isset($nav[$key][$newk]['super_subs'])){ 
											foreach($nav[$key][$newk]['super_subs'] as $keyy => $vvalue){
								?>
										<option value="<?php echo base_url(); ?>page/<?php echo $vvalue['page_id']; ?>">–––<?php echo $vvalue['title']; ?></option>
						<?php	
										}
									}
								}
							}
						} ?>
						</select>
                  	
                  	</div>
                  </div>
             </div>  
         </div>