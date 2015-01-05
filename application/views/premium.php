<!DOCTYPE html>
<head>

    <title>Autopublicador Social</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8" />

<?php echo $this->load->view('includes2/head');?>




</head>

<body>
    <?php echo $this->load->view('includes2/header');
    ?>
    
<div class="content">
  <div class="container">

<!-- Pricing table -->
                     <!-- Price details. Note down the class name before you edit. -->
                     <div class="row">

                        <div class="col-md-6">

                           <!-- Pricing table #1. Class name "col-left" -->
                           <div class="pricel center">
                                 <div class="phead-top">
                                    <!-- Title -->
                                    <h4>Gratuito</h4>
                                 </div>
                                 <div class="phead-bottom">
                                    <!-- Price. Use the syntax correctly. -->
                                    <p>0 € </p>
                                 </div>
                                 <div class="arrow-down"></div>
                              <div class="plist">
                                 <!-- List -->
                                 <ul>
                                  <!-- List with tooltip. -->
                                    <li>Hasta 3 perfiles sociales de facebook y twiiter en una misma cuenta. </li>
                                    <li>Autopublicación de bases de datos internas.</li>
                                    <li>Más de 5 bases de datos de imágenes de todas las temáticas.</li>

                                 </ul>
                              </div>
                              <div class="pbutton button">
                                 <!-- button -->
                                 <a href="<?php echo base_url(); ?>panel/register_account/"><i class="fa fa-shopping-cart"></i> Contratar!</a>
                              </div>
                           </div>

                        </div>
                        <div class="col-md-6">

                           <!-- Pricing table #3. Class name "col-left" -->
                           <div class="pricel center">
                                 <div class="phead-top">
                                    <h4>Premium</h4>
                                 </div>
                                 <div class="phead-bottom">
                                    <p> 10 € </p>
                                 </div>
                                 <div class="arrow-down"></div>
                              <div class="plist">
                                 <ul>
                                    <li>Hasta 100 perfiles sociales de facebook y twiiter en una misma cuenta.</li>
                                    <li>Autopublicación de bases de datos propias o internas cada 10 minutos.</li>
                                    <li>Más de 5 bases de datos de imágenes de todas las temáticas.</li>
                                    <li>Tus propios albumes de imágenes con hasta 2 mil imágenes en cada albúm.</li>
                                    <li>Tus propias bases de datos de texto con hasta 5 mil frases por cada base de datos.</li>
                                    <li>Programa todas las imágenes, textos o enlaces que quieras, y a la hora que prefieras.</li>
                                    <li>Configurador de borrador automático con el tiempo que quieras.</li>
                                 </ul>
                              </div>
                              <div class="pbutton button">
                                 <!-- button -->
                                 <a href="<?php echo base_url(); ?>panel/register_account"><i class="fa fa-shopping-cart"></i> Contratar!</a>
                              </div>
                           </div>

                           <div class="clearfix"></div>

                        </div>
                     </div>

  </div>
</div>
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>

</body>
</html>