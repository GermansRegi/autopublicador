<!DOCTYPE html>
<head>

    <title>Socialsuites</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8" />
    <?php echo $this->load->view('includes2/head');?>




</head>

<body>
    <?php echo $this->load->view('includes2/header');

?>
    <div class="page">
    <div class="page">
  <!--========================================================
                            HEADER
  =========================================================-->
  <header>
    <div class="container">
      <h1 class="brand">
        <a href="./">Business Consultant</a>
      </h1>
      
      <h2>The best landing page you are looking for.</h2>
         
      <form id="bookingForm" class="booking-form">
        <div class="tmInput">
        <input name="Name" placeholder="Full name" type="text" data-constraints="@NotEmpty @Required @AlphaSpecial">
        </div>
        <div class="tmInput">
        <input name="E-mail" placeholder="Your E-mail" type="text" data-constraints="@NotEmpty @Required @Email">
        </div>
        <div class="tmInput">
        <input name="Phone" placeholder="Phone" type="text" data-constraints="@NotEmpty @Required @JustNumbers">
        </div>
        <a href="#" class="btn" data-type="submit">Get Started Now!</a>
        <p><small>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </small></p>
      </form>
       
    </div>
  </header>
  <!--========================================================
                            CONTENT
  =========================================================-->
  <main>
    <section class="well bg-primary">
      <div class="container">
        <h3 class="center mobile-left">
          Feature-rich landing page template designed<br>to showcase your product or service
        </h3>
        <div class="row">
          <div class="grid_3 wow fadeInRight">
            <div class="img1 fl-bigmug-line-circular228"></div>
            <h4>
              Lorem ipsum dolor
            </h4>
            <p>
              Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco labori.
            </p>
          </div>
          <div class="grid_3 wow fadeInRight" data-wow-delay="0.2s">
            <div class="img1 fl-bigmug-line-weekly14"></div>
            <h4>
              Conse ctetur
            </h4>
            <p>
              Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco labori.
            </p>
          </div>
          <div class="grid_3 wow fadeInRight" data-wow-delay="0.4s">
            <div class="img1 fl-bigmug-line-copy23"></div>
            <h4>
              Elit sed do eiusmod
            </h4>
            <p>
              Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco labori.
            </p>
          </div>
          <div class="grid_3 wow fadeInRight" data-wow-delay="0.6s">
            <div class="img1 fl-bigmug-line-portfolio23"></div>
            <h4>
              Incididunt ut labore
            </h4>
            <p>
              Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco labori.
            </p>
          </div>
        </div>
      </div>
    </section>

    <section class="well2">
      <div class="container">
        <div class="row">
          <div class="grid_7">
            <h3>
              Conversion optimized design. Perfect for any startup.
            </h3>
            <div class="row off1">
              <div class="grid_6">
                <p>
                  Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
              </div>
            </div>
            
          </div>
          <ul class="grid_5 product-list mg-add1">
            <li class="fl-bigmug-line-monitor74 wow fadeInUp">
              <h4>Lorem ipsum dolor</h4>
              <p>
                Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.
              </p>
            </li>
            <li class="fl-bigmug-line-wallet26 wow fadeInUp" data-wow-delay="0.2s">
              <h4>Conse ctetur adipisicing</h4>
              <p>
                Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.
              </p>
            </li>
            <li class="fl-bigmug-line-shopping202 wow fadeInUp" data-wow-delay="0.4s">
              <h4>Elit sed do eiusmod</h4>
              <p>
                Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.
              </p>
            </li>
          </ul>
        </div>
      </div>
    </section>

    <section class="well3 bg-secondary2">
      <div class="container">
        <div class="row">
          <div class="grid_6">
            <div class="video mg-add2">
              <iframe src="//player.vimeo.com/video/37582125?wmode=transparent" allowfullscreen=""></iframe>
            </div>
          </div>
          <div class="preffix_1 grid_5 wow fadeInRight">
            <h3>Description with video</h3>
            <p class="primary txt1">
              Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
            </p>
          </div>
        </div>
      </div>
    </section>

    <section class="well4">
      <div class="container">
        <h3 class="center">Get to know more about business</h3>
        <div class="row off2">
          <article class="grid_4 wow fadeInRight">
            <img src="images/page-1_img01.jpg" alt="">
            <h4 class="primary"><a href="#">Lorem ipsum dolor</a></h4>
            <p>
              Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolo.
            </p>
          </article>
          <article class="grid_4 wow fadeInRight" data-wow-delay="0.2s">
            <img src="images/page-1_img02.jpg" alt="">
            <h4 class="primary"><a href="#">Conse ctetur adipisicing</a></h4>
            <p>
              Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolo.
            </p>
          </article>
          <article class="grid_4 wow fadeInRight" data-wow-delay="0.4s">
            <img src="images/page-1_img03.jpg" alt="">
            <h4 class="primary"><a href="#">Elit sed do eiusmod</a></h4>
            <p>
              Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolo.
            </p>
          </article>
        </div>
      </div>
    </section>

<?php
    echo $this->load->view('premium');
      echo $this->load->view('Faq');
      
?>
    
    <section class="well5 ins2 parallax center" data-url="images/parallax1.jpg" data-mobile="true">
      <div class="container">
        <h3>Subscribe</h3>
        <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolo.</p>
        <form id="subscribe-form" class="subscribe-form">
          <label class="email">
              <input type="email" value="Your E-mail">
              <span class="error">*Invalid email.</span>
              <span class="success" style="display: none;">Subscription request sent!</span>
          </label>
          <a class="btn" data-type="submit" href="#">Subscribe</a>
        </form>
      </div>

      
    </section>

    <section class="well ins3">
      <div class="container">
        <div class="row">
          <div class="grid_6">
            <blockquote class="box wow fadeInUp">
              <div class="box_aside">
                <img src="images/page-1_img04.jpg" alt="">
              </div>
              <div class="box_cnt">
                <p>
                  <q>
                    Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore dunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor lorem.
                  </q>
                </p>
                <cite><a href="#">Lorem ipsum dolor sit amet</a></cite>
              </div>
            </blockquote>

            <blockquote class="box wow fadeInUp" data-wow-delay="0.2s">
              <div class="box_aside">
                <img src="images/page-1_img06.jpg" alt="">
              </div>
              <div class="box_cnt">
                <p>
                  <q>
                    Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididun.
                  </q>
                </p>
                <cite><a href="#">Lorem ipsum dolor sit amet</a></cite>
              </div>
            </blockquote>
          </div>
          <div class="grid_6">
            <blockquote class="box wow fadeInUp">
              <div class="box_aside">
                <img src="images/page-1_img05.jpg" alt="">
              </div>
              <div class="box_cnt">
                <p>
                  <q>
                    Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore dunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
                  </q>
                </p>
                <cite><a href="#">Lorem ipsum dolor sit amet</a></cite>
              </div>
            </blockquote>

            <blockquote class="box wow fadeInUp" data-wow-delay="0.2s">
              <div class="box_aside">
                <img src="images/page-1_img07.jpg" alt="">
              </div>
              <div class="box_cnt">
                <p>
                  <q>
                    Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore dunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
                  </q>
                </p>
                <cite><a href="#">Lorem ipsum dolor sit amet</a></cite>
              </div>
            </blockquote>
          </div>
        </div> 
      </div> 
    </section>

    <section class="well6 bg-secondary2">
      <div class="container">
        <h3 class="center">Our partners</h3>
        <ul class="flex-list">
          <li>
            <img src="images/page-1_img08.jpg" alt="">
          </li>
          <li>
            <img src="images/page-1_img09.jpg" alt="">
          </li>
          <li>
            <img src="images/page-1_img10.jpg" alt="">
          </li>
        </ul>
      </div>
    </section>
  </main>

  <!--========================================================
                            FOOTER
  =========================================================-->
  <footer>
    <section class="well2">
      <div class="container">
        <div class="row">
          <div class="grid_6">
            <h3>Contact us</h3>
            <ul class="contact-list off3">
              <li class="fl-bigmug-line-big104"><address>4578 Marmora Road,Glasgow D04 89GR</address></li>
              <li class="fl-bigmug-line-phone351"><a href="callto:#">800-2345-6789</a></li>
              <li class="fl-bigmug-line-opened25"><a href="mailto:#">info@demolink.org</a></li>
            </ul>
            <ul class="inline-list">
              <li><a href="#" class="fa-facebook"></a></li>
              <li><a href="#" class="fa-twitter"></a></li>
              <li><a href="#" class="fa-google-plus"></a></li>
              <li><a href="#" class="fa-youtube"></a></li>
            </ul>
            
          </div>
          <div class="grid_6">
            <h3>Get in touch</h3>

            <form id="contact-form" class="contact-form off3" method="POST" action="bat/MailHandler.php">
              <div class="contact-form-loader"></div>
              <fieldset>
                <label class="name">
                  <input type="text" name="name" value="" data-constraints="@NotEmpty @Required @AlphaSpecial" id="regula-generated-721694">
                  <span class="empty-message">*This field is required.</span>
                  <span class="error-message">*This is not a valid name.</span>
                <span class="_placeholder" style="left: 0px; top: 0px; width: 526px; height: 50px;">Full name</span></label>
            
                <label class="email">
                  <input type="text" name="email" value="" data-constraints="@Required @Email" id="regula-generated-908092">
                  
                  <span class="empty-message">*This field is required.</span>
                  <span class="error-message">*This is not a valid email.</span>
                <span class="_placeholder" style="left: 0px; top: 0px; width: 526px; height: 50px;">Your E-mail</span></label>
            
                <label class="phone">
                  <input type="text" name="phone" value="" data-constraints="@JustNumbers" id="regula-generated-899952">
            
                  <span class="empty-message">*This field is required.</span>
                  <span class="error-message">*This is not a valid phone.</span>
                <span class="_placeholder" style="left: 0px; top: 0px; width: 526px; height: 50px;">Phone</span></label>
            
                <label class="message">
                  <textarea name="message" data-constraints="@Required @Length(min=20,max=999999)" id="regula-generated-314436"></textarea>
            
                  <span class="empty-message">*This field is required.</span>
                  <span class="error-message">*The message is too short.</span>
                <span class="_placeholder" style="left: 0px; top: 0px; width: 526px; height: 137px;">Message</span></label>
            
                <div class="btn-wr">
                  <a class="btn" href="#" data-type="submit">Send</a>
                </div>
              </fieldset>
              <div class="modal fade response-message">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                      </button>
                      <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
                      You message has been sent! We will be in touch soon.
                    </div>
                  </div>
                </div>
              </div>
            <input type="hidden" name="stripHTML" value="true"></form>
          </div>
        </div>
        <div class="copyright">
          Business Consultant © <span id="copyright-year">2015</span> |
              <a href="index-5.html">. All Rights Reserved</a>
              <!-- {%FOOTER_LINK} -->
        </div>
    
      </div>
    </section>


    <section class="map">
      <div id="google-map" class="map_model" data-zoom="12"></div>
      <ul class="map_locations">
        <li data-x="-73.9874068" data-y="40.643180">
          <p> 9870 St Vincent Place, Glasgow, DC 45 Fr 45. <span>800 2345-6789</span></p>
        </li>
      </ul>
    </section>
  </footer>
</div>
        
        
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>   