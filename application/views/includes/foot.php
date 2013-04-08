<footer>
  <div class="container">
	     <div class="row">
            <article class="span6 fright">
             <ul class="menu-footer">
			 <?php foreach($nav as $key=>$value){  ?>
               <li><a href="<?php echo base_url().'get/'.$value['link']; ?>"><?php echo $value['title']; ?></a></li>
			   <?php } ?> 
             </ul>
           </article>
	         <article class="span6 fleft">
                 <span>Webmak.in &copy; <?php echo date('Y'); ?> All rights reserved</span> | <span style="text-transform: lowercase; font-family: Arial serif"><?php echo $copyright; ?> </span><br>
           </article>
           
       </div>
  </div>
</footer>
<script type="text/javascript" src="js/bootstrap.js"></script>

</body>
</html>