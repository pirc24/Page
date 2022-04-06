<header class="p-3 mb-3 border-bottom sticky-top barvaGlave">
	<div class="container">
		<div class="d-flex flex-wrap align-items-center justify-content-center
            justify-content-lg-start">

			<!-- LOGO IN IME -->
			<a href="index" class="nav-link px-2 link-secondary">
				<h2 class="ps-2 float-end naslov">MOJ LAJF</h2>
			</a>
			<!-- SEZNAM V GLAVI -->
			<ul class="nav col-12 col-lg-auto me-lg-auto mb-2
                justify-content-center mb-md-1 ps-5">
				<li><button type="button" class="nav btn btn-light btn-outline-dark btn-sm w-auto text-center" id="myBtn"> USTVARI BLOG</button></li>
			</ul>

			<!-- The Modal -->
			<div id="myModal" class="modal">

				<!-- Modal content -->
				<div class="modal-content">
					<span class="close">&times;</span>
					<form class="formblog" id="posts" method="POST" name="posts">
						<?php blog(); ?>
						<div class="form-group blogspot">
							<textarea class="form-control" id="mytextarea" name="blog"></textarea>
						
                        <input class="form-check-input" type="checkbox" name="private" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">Privatni blog</label>
						<input class="btn btn-light btn-outline-dark btn-sm col-2" type=submit name="Submit" value="POST">
                        </div>
					</form>

				</div>

			</div>
            
            <!-- Modal 2 content -->
            <div id="myModal2" class="modal">

				<!-- Modal content -->
				<div class="modal-content">
					<span class="close2">&times;</span>
					<p id="NASLOVOBJAVE">UREDI OBJAVO</p>
						<div class="form-group blogspot">
                            <textarea class="form-control edittext1" id="mytextareaedit" name="">TEST ZA EDIT NE DELA</textarea>
						
                        <button id="objaviedit" class="btn btn-light btn-outline-dark btn-sm"> OBJAVI SPREMEMBE </button>
					   </div>

				</div>

			</div>


			<!-- ISKANJE -->
			<form class="input-group mb-3 w-auto" method="get" action="search">
                
				<input id="iskanje" type="search" class="form-control" placeholder="Search..." aria-label="Search" name="isci">
                <button class="btn" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg></button>
            </form>
            

					<div>
						<?php 
                
                $check = (isset($_SESSION) && isset($_SESSION['Login'])) ? true : false; //preverim če uporabnik je že prijavljen.
                if(!$check){ ?>

						<button class="btn btn-primary" id="log-in">LOGIN</button>
						<button class="btn btn-primary" id="reg-in">REGISTER</button>

						<?php }
                else { 
                        $steviloProsenj = mysqli_num_rows(vstaviProsnje());
                    
                        ?>

						<!-- USER DROPDOWN -->
						<div class="dropdown text-end w-auto">
							<a href="#" class="d-block link-dark text-decoration-none
                    dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
								<img src="<?php zamProf() ?>" alt="mdo" width="60" height="60" class="rounded-circle">
							</a>
							<ul class="dropdown-menu text-small w-auto" aria-labelledby="dropdownUser1">
								<li><a class="dropdown-item " href="UserProfile">MOJ PROFIL  <?php if($steviloProsenj > 0){  ?> <p class="stprosn"><?php echo $steviloProsenj;?></p><?php } ?></a></li>
								<li>
									<hr class="dropdown-divider">
								</li>
								<li><a class="dropdown-item" href="logout">Sign out</a></li>
							</ul>
						</div>
						<div class="pe-2"> <b> HELLO <?php echo $_SESSION['user'];  ?> </b></div>
						<?php } ?>
					</div>

				</div>
			</div>
</header>
