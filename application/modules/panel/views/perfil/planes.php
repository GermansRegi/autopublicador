<!DOCTYPE html>
<head>

    <title>Autopublicador Social</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8" />
    <?php echo $this->load->view('includes2/head');?>




</head>

<body>
<?php $socialNamesAr=array('face'=>"Facebook","twt"=>"Twitter");$tradArray=array('sentence'=>"Texto",'image'=>'Imágenes','link'=>'Enlaces');
?>
    <?php echo $this->load->view('includes2/header');

	?>


	<div class="col-md-6 col-md-offset-3 box-plan" >

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
					<li>Tus propios albumes de imágenes con hasta 2 mil imágenes en cada álbum.</li>
					<li>Tus propias bases de datos de texto con hasta 5 mil frases por cada base de datos.</li>
					<li>Programa todas las imágenes, textos o enlaces que quieras, y a la hora que prefieras.</li>
					<li>Configurador de borrador automático con el tiempo que quieras.</li>
				</ul>
			</div>
			<div class="pbutton button">  
				<!-- button -->
				<a id="premiumnormal">Contratar ahora!</a>
			</div>
		</div>

		<div class="clearfix"></div>                        

	</div>
	<div style="display:none;" id="pagoplanp">
		<div class="content features-two">
			<div class="container">
				<div class="row">
					<p class="text-center">
						Elija el tipo de facturación

					</p>
					<div class="col-md-4">
						<div class="text-center">
							<!-- Font awesome icon -->
							
							<!-- Title -->
							<h4>Mensual 10€ (30 días)</h4>
							<!-- Para -->
							
							<!-- Button -->
							<div class="button">

								<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
									<input type="hidden" name="cmd" value="_xclick" />
									<input type="hidden" name="business" value="eugeniregiprove@gmail.com" />
									<input type="hidden" name="quantity" value="1" />
									<input type="hidden" name="item_name" value="pago menusal autopublicador social" />

									<input type="hidden" name="amount" value="10.00" />
									<input type="hidden" name="custom" value="mensual-<?php echo $this->flexi_auth->get_user_id(); ?>"/>
									<input type="hidden" name="currency_code" value="EUR">

									<input type="hidden" name="rm" value="2"/>


									<input type="hidden" name="cancel_return" value="<?php echo base_url(); ?>pagar/errordepago">

									<input type="submit" value="Pagar" class="btn btn-primary"/>

								</form>

							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="text-center">
							
							<h4>Trimestral 25 € (90 días)</h4>
							
							<div class="button">

								<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
									<input type="hidden" name="cmd" value="_xclick" />
									<input type="hidden" name="business" value="eugeniregiprove@gmail.com" />
									<input type="hidden" name="quantity" value="1" />
									<input type="hidden" name="item_name" value="pago trimestral autopublicador social" />

									<input type="hidden" name="amount" value="25.00" />
									<input type="hidden" name="currency_code" value="EUR"/>
									<input type="hidden" name="custom" value="trimestral-<?php echo $this->flexi_auth->get_user_id(); ?>"/>


									<input type="hidden" name="cancel_return" value="<?php echo base_url(); ?>pagar/errordepago"/>

									<input type="submit" value="Pagar" class="btn btn-primary"/>
								</form>

							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="text-center">
							
							<h4>Anual 90 €  (365 días)</h4>
							
							<div class="button">
								<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
									<input type="hidden" name="cmd" value="_xclick" />
									<input type="hidden" name="business" value="eugeniregiprove@gmail.com" />
									<input type="hidden" name="quantity" value="1" />
									<input type="hidden" name="item_name" value="pago anual autopublicador social" />

									<input type="hidden" name="amount" value="90.00" />

									<input type="hidden" name="custom" value="anual-<?php echo $this->flexi_auth->get_user_id();    ?>"/>
									<input type="hidden" name="currency_code" value="EUR"/>




									<input type="hidden" name="cancel_return" value="<?php echo base_url(); ?>pagar/errordepago"/>
									<input type="submit" value="Pagar" class="btn btn-primary"/>
								</form>

							</div>
						</div>
					</div>  

					<div class="col-lg-12 text-center">
						<p>
							<a class="closeplan btn btn-danger">Cancelar</a>
						</p>
					</div>
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