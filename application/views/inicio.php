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
            <div class="sep"></div>
            <div class="page-head">
              <div class="container">
                <div class="row">
                  <div class="col-md-12">
                    <h2>Bienvenido al Autopublicador Social</h2>

                  </div>
                </div>
              </div>


            </div>
            <div class="content">
              <div class="container">
                <div class="row">
                <div class="col-md-12">
                <div class="slider">
                Slider
            </div>

            <div class="ultimos-articulos"></div>

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