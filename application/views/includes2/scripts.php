<script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
                                           <?php if(isset($section_app))
                                    {?>
                                      <!-- Include JS files -->
    <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="<?php echo base_url();?>includes/js/plupload.full.min.js"></script>
    <script src="<?php echo base_url();?>includes/js/moxie.min.js"></script>
   <script  src="<?php echo base_url();?>includes/js/jquery.plupload.queue.min.js"></script>
   <script  src="<?php echo base_url();?>includes/js/jquery.plupload.es.js"></script>
    <script src="<?php echo base_url(); ?>includes/js/bootstrap.min.js"></script>
   <script  src="<?php echo base_url(); ?>includes/js/bootstrap-filestyle.min.js"></script>
    <script src="<?php echo base_url(); ?>includes/js/jquery.noty.packaged.min.js"></script>
        <script src="<?php echo base_url(); ?>includes/js/jquery.cookie.js"></script>
        <script src="<?php echo base_url(); ?>includes/js/bootstrap-datepicker.min.js"></script>
        <script src="<?php echo base_url(); ?>includes/js/bootstrap-datepicker.es.min.js"></script>
  <script  src="<?php echo base_url(); ?>includes/js/jquery.jeditable.mini.js"></script> 
    <script src="<?php echo base_url(); ?>includes/js/script.js"></script>
   <script  src="<?php echo base_url(); ?>includes/js/basesdedatos.js"></script>


      <script  src="<?php echo base_url(); ?>includes/js/bootstrap-timepicker.min.js"></script>
 <script  src="<?php echo base_url(); ?>includes/js/jquery-ui.min.js"></script>
 
 <script  src="<?php echo base_url(); ?>includes/js/handlebars-v3.0.3.js"></script>
  <script  src="<?php echo base_url(); ?>includes/js/moment-with-locales.min.js"></script>
 <script  src="<?php echo base_url(); ?>includes/js/moment-duration-format.js"></script>

 <script  src="<?php echo base_url(); ?>includes/js/social.js"></script>
 <script  src="<?php echo base_url(); ?>includes/js/app.js"></script>
 <script  src="<?php echo base_url(); ?>includes/js/magnificpopup.min.js"></script>


   
   
<?php }else{
    ?>
<script src="<?php echo base_url(); ?>includes/js/Landing_v1/script.js"></script>
<!-- coded by Kirk -->
</body>
        <?php
}
