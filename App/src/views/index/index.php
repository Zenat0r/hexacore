<header id="top">

<!-- NAbar -->
<nav class="nav-fixed">
	<div class="nav-wrapper">
		<a href="#top" class="brand-logo hide-on-med-and-down">Les Ch'tis Gamers</a>
		<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
		<ul class="right hide-on-med-and-down">
			<li><a href="<?php echo base_url('play')?>" class="btn btn-floating pulse">Jeu du mois</a></li>
			<li><a href="#teamSlider">L'équipe</a></li>
			<li><a href="#competition">Compétition</a></li>
			<li><a href="#detente">Détente</a></li>
			<li><a href="#hungry">Domino's</a></li>			
		</ul>
		<ul class="side-nav" id="mobile-demo">
			<li><a href="<?php echo base_url('play')?>" class="btn btn-floating pulse">Jeu du mois</a></li>
			<li><a href="#teamSlider">L'équipe</a></li>
			<li><a href="#competition">Compétition</a></li>
			<li><a href="#detente">Détente</a></li>
			<li><a href="#hungry">Domino's</a></li>
		</ul>
	</div>
</nav>

<!--slider -->

<div class="slider">
	<!--<div class="slider-cover"></div>-->
	<ul class="slides">
	<?php foreach($sliders as $slider): ?>
		<li>
			<img src="<?php echo img_url($slider->sl_image); ?>">
			<div class="caption <?php echo $slider->sl_align?>">
				<h3><?php echo $slider->sl_title?></h3>
				<h5 class="light grey-text text-lighten-3"><?php echo $slider->sl_description?></h5>
			</div>
		</li>
	<?php endforeach; ?>
	</ul>
</div>
<!-- logo CG -->
<div id="logo">
	<img class="responsive-img" src="<?php echo img_url("chtisgamers_high.png"); ?>">
</div>
<!--//////// -->
</header>
<!-- text de presentation -->
<main>
	<section id="presentation" class="container pageH valign-wrapper">
		<div>
			<p class="flow-text center-align"><?php echo $main->main_description?></p>
			<hr class="both">
			<div class="row">
				<div class="col s12 l4">
					<a href="">
					<div class="showCard z-depth-4">
						<div class="cardIcon-container">
							<img
							 src="<?php echo img_url($main->main_frame1_image)?>" 
							 alt="placeholder+image"
							 class="responsive-img">
						</div>
						<div class="card-description">
							<div class="description-container"><h4 class="center-align"><?php echo $main->main_frame1_title; ?></h4></div>
							<hr class="blue">
							<div class="description-content"><p class="center-align content-text"><?php echo $main->main_frame1_descritpion; ?></p></div>
						</div>
					</div>
					</a>
				</div>
				<div class="col s12 l4">
					<a href="">
					<div class="showCard z-depth-4">
						<div class="cardIcon-container">
							<img
							 src="<?php echo img_url($main->main_frame2_image)?>" 
							 alt="placeholder+image"
							 class="responsive-img">
						</div>
						<div class="card-description">
							<div class="description-container"><h4 class="center-align"><?php echo $main->main_frame2_title; ?></h4></div>
							<hr class="both">
							<div class="description-content"><p class="center-align content-text"><?php echo $main->main_frame2_description; ?></p></div>
						</div>
					</div>
					</a>
				</div>
				<div class="col s12 l4">
					<a href="">
					<div class="showCard z-depth-4">
						<div class="cardIcon-container">
							<img
							 src="<?php echo img_url($main->main_frame3_image)?>" 
							 alt="placeholder+image"
							 class="responsive-img">
						</div>
						<div class="card-description">
							<div class="description-container"><h4 class="center-align"><?php echo $main->main_frame3_title; ?></h4></div>
							<hr class="red">
							<div class="description-content"><p class="center-align content-text"><?php echo $main->main_frame3_description; ?></p></div>
						</div>
					</div>
					</a>
				</div>
			</div>
		</div>
	</section>

  	<!--////////-->


  	<!--Parallax de l'équipe-->

	<div class="parallax-container">
      <div class="parallax">
      	<div id="parallax-team" class="parallax-title valign-wrapper">
			<div class="background"></div>
      		<div class="text">Présentation de l'équipe</div>
      	</div>
      	<img
      	 src="<?php echo img_url("background/Logo_full_round.jpg");?>">
      </div>
    </div>


    <!-- Equipe slider -->
    <section id="teamSlider" class="pageH">
    <!-- calais -->
    	<h3 class="center-align">Site de Calais</h3>
    	<div class="carousel">
    	<?php foreach($members["calais"] as $member): ?>
			<a class="carousel-item" href="#car_<?php echo $member["us_id"] ?>">
		    	<div class="memberContainer">
	    			<div class="memberImage">
	    				<img
	    				src="<?php echo img_url($member["us_member_img"]) ?>"
	    				alt="<?php echo $member["us_firstname"] . " " . $member["us_lastname"] ?>"
	    				class="responsive-img circle">
	    			</div>
	    			<div class="memberName"><h5><?php echo $member["us_firstname"] . " " .$member["us_lastname"] ?></h5></div>
	    			<div class="memberRole"><h6><?php echo $member["us_role"] ?></h6></div>
	    		</div>
		    </a>
    	<?php endforeach; ?>
		</div>
    	<!-- longuenesse -->
    	<h3 class="center-align">Site de Longuenesse</h3>
    	<div class="carousel">
		<?php foreach($members["longuenesse"] as $member): ?>
			<a class="carousel-item" href="#car_<?php echo $member["us_id"] ?>">
		    	<div class="memberContainer">
	    			<div class="memberImage">
	    				<img
	    				src="<?php echo img_url($member["us_member_img"]) ?>"
	    				alt="<?php echo $member["us_firstname"] . " " .$member["us_lastname"] ?>"
	    				class="responsive-img circle">
	    			</div>
	    			<div class="memberName"><h5><?php echo $member["us_firstname"] . " " .$member["us_lastname"] ?></h5></div>
	    			<div class="memberRole"><h6><?php echo $member["us_role"] ?></h6></div>
	    		</div>
		    </a>
    	<?php endforeach; ?>    
		</div>
    </section>

    <!--Parallax de compétition-->

	<div class="parallax-container">
      <div class="parallax">
      	<div id="parallax-comp" class="parallax-title valign-wrapper">
			<div class="background"></div>
      		<div class="text">Ch'tis Gamers compétitif</div>
      	</div>
      	<img 
      	src="<?php echo img_url("cover.jpg");?>">
      </div>
    </div>


    <!-- competition section -->
    <section id="competition" class="container">
    	<p class="flow-text center-align"><?php echo $main->competition_desciption; ?></p>
		<hr class="both">
    	<div class="row">
    		<div class="col l4 push-l8">
				<div class="imageFrame z-depth-4">
    				<img src="<?php echo img_url($main->competition_image1); ?>" alt="ch'tis gamers tournament" class="responsive-img">
				</div>
    		</div>
    		<div class="col l8 pull-l4 right-align no-align-m">
    			<h4><?php echo $main->competition_title1; ?></h4>
    			<p><?php echo $main->competition_description1; ?></p>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col l4">
				<div class="imageFrame z-depth-4">
    				<img src="<?php echo img_url($main->competition_image2); ?>" alt="ch'tis gamers tournament" class="responsive-img">
				</div>
    		</div>		
    		<div class="col l8 left-align no-align-m">
    			<h4><?php echo $main->competition_title2; ?></h4>
    			<p><?php echo $main->competition_description2; ?></p>
    		</div>    		
    	</div>
    </section>

    <!--Parallax de Detente-->

	<div class="parallax-container">
      <div class="parallax">
	  <div id="parallax-chill" class="parallax-title valign-wrapper">
			<div class="background"></div>
      		<div class="text">Ch'tis Gamers Détente</div>
      	</div>
      <img src="<?php echo img_url('maincontent/full_detente.jpg');?>"></div>
    </div>

    <!-- Détente -->
    <section id="detente" class="container">
    	<div class="row">
    		<div class="col s12 l4">
    			<div class="showCard z-depth-4">
					<div class="cardIcon-container">
						<img src="<?php echo img_url($main->detent_image1) ;?>"
						class="responsive-img"
						alt="Mario kart">
					</div>
					<div class="card-description">
						<div class="description-container"><h4 class="center-align"><?php echo $main->detent_title1 ;?></h4></div>
						<hr class="blue">
						<div class="description-content"><p class="center-align content-text"><?php echo $main->detent_description1 ;?></p></div>
					</div>
				</div>
    		</div>
    		<div class="col s12 l4">
    			<div class="showCard z-depth-4">
					<div class="cardIcon-container">
						<img src="<?php echo img_url($main->detent_image2) ;?>"
						class="responsive-img"
						alt="Mario kart">
					</div>
					<div class="card-description">
						<div class="description-container"><h4 class="center-align"><?php echo $main->detent_title2 ;?></h4></div>
						<hr class="both">
						<div class="description-content"><p class="center-align content-text"><?php echo $main->detent_description2 ;?></p></div>
					</div>
				</div>
    		</div>
    		<div class="col s12 l4">
    			<div class="showCard z-depth-4">
					<div class="cardIcon-container">
						<img src="<?php echo img_url($main->detent_image3) ;?>"
						class="responsive-img"
						alt="Mario kart">
					</div>
					<div class="card-description">
						<div class="description-container"><h4 class="center-align"><?php echo $main->detent_title3 ;?></h4></div>
						<hr class="red">
						<div class="description-content"><p class="center-align content-text"><?php echo $main->detent_description3 ;?></p></div>
					</div>
				</div>
    		</div>
    	</div>
    	<hr class="both">
    	<p class="flow-text center-align"><?php echo $main->detent_description; ?></p>
    </section>

    <!-- parallax dominos -->

	<div class="parallax-container">
      	<div class="parallax">
      		<div id="parallax-hungry" class="parallax-title valign-wrapper">
				<div class="background"></div>
	      		<div class="text">Hungry Gamers</div>
	      	</div>
      		<img src="<?php echo img_url("maincontent/domi.jpg");?>">
      	</div>
    </div>

    <!-- Dominos -->
    <section id="hungry" class="pageH">
    	<div class="center-align">
    		<img
    		src="<?php echo $main->hungry_main_image;?>"
    		alt="Domino's pizza"
    		class="responsive-img">
    	</div>
    	<div class="row">
    		<div class="col s12">
    			<p class="flow-text"><?php echo $main->hungry_desciprtion;?>!</p>
    		</div>
    		<div class="col s12">
    			<div class="row">
    				<div class="col s12 m12 l6">
    					<div class="imageFrame z-depth-4">
	    					<img
	    					src="<?php echo img_url($main->hungry_image); ?>"
	    					alt="Midi Domino's"
	    					class="responsive-img">
						</div>
    				</div>
    				<div class="col s12 m12 l6">
					<div class="imageFrame z-depth-4">
	    					<img
	    					src="<?php echo img_url($main->hungry_image2); ?>"
	    					alt="Midi Domino's"
	    					class="responsive-img">
						</div>
    				</div>
				</div>
    			</div>
			<div class="col s12">
				<p><?php echo $main->hungry_desciprtion1 ; ?></p>
			</div>
    		</div>		
    	</div>   	
    </section>
</main>
<footer class="page-footer">
	<div class="container">
		<div class="row">
			<div class="col l6 s12">
				<h5 class="white-text">Ch'tis Gamers</h5>
				<p class="grey-text text-lighten-4">Ch'tis Gamers est un club de l'école d'ingénieurs du littoral côte d'opale.</p>
			</div>			
		</div>
	</div>
	<div class="footer-copyright">
		<div class="container">
			© 2017 Copyright Ch'tis Gamers
			<a class="grey-text text-lighten-4 right"
			href="http://christophe-sieradzki.fr">Développeur</a>
		</div>
	</div>
</footer>