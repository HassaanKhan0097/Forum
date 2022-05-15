<header id="tt-header">
   <div class="container">
      <div class="row tt-row no-gutters">
         <div class="col-auto">
            <!-- toggle mobile menu -->
            <a class="toggle-mobile-menu" href="#">
               <svg class="tt-icon">
                  <use xlink:href="#icon-menu_icon"></use>
               </svg>
            </a>
            <!-- /toggle mobile menu -->
            <!-- logo -->
            <div class="tt-logo">
               <a href="index.html"><img src="<?php echo base_url(); ?>assets/images/logo22.png" alt=""></a>
            </div>
            <!-- /logo -->
            <!-- desctop menu -->
            <div class="tt-desktop-menu">
               <nav>
                  <ul>
                     <li class="<?php echo activate_menu('channels'); ?>" ><a href="<?php echo base_url(); ?>channels"><span>Channels</span></a></li>
                     <!-- <li class="<?php echo activate_menu('trending'); ?>" ><a href="<?php echo base_url(); ?>trending"><span>Trending</span></a></li> -->
                     <li class="<?php echo activate_menu('posts'); ?>" ><a href="<?php echo base_url(); ?>posts"><span>Posts</span></a></li>
                     <!-- <li><a href="page-create-topic.html"><span>New</span></a></li> -->
                     <!-- <li>
                        <a href="#"><span>Join</span></a>
                        <ul>
                           <li><a target="_blank" href="http://localhost/KeepAdding/">As Business</a></li>
                           <li><a target="_blank" href="http://localhost/KeepAdding/">As Contractor</a></li>
                        </ul>
                     </li> -->
                  </ul>
               </nav>
            </div>
            <!-- /desctop menu -->
            <!-- tt-search -->
            <div class="tt-search">
               <!-- toggle -->
               <button class="tt-search-toggle" data-toggle="modal" data-target="#modalAdvancedSearch">
                  <svg class="tt-icon">
                     <use xlink:href="#icon-search"></use>
                  </svg>
               </button>
               <!-- /toggle -->
               <form class="search-wrapper">
                  <div class="search-form">
                     <input type="text" class="tt-search__input" placeholder="Search">
                     <button class="tt-search__btn" type="submit">
                        <svg class="tt-icon">
                           <use xlink:href="#icon-search"></use>
                        </svg>
                     </button>
                     <button class="tt-search__close">
                        <svg class="tt-icon">
                           <use xlink:href="#cancel"></use>
                        </svg>
                     </button>
                  </div>
                  <div class="search-results">
                     <div class="tt-search-scroll">
                        <ul>
                           <li>
                              <a href="page-single-topic.html">
                                 <h6 class="tt-title">Rdr2 secret easter eggs</h6>
                                 <div class="tt-description">
                                    Here’s what I’ve found in Red Dead Redem..
                                 </div>
                              </a>
                           </li>
                           <li>
                              <a href="page-single-topic.html">
                                 <h6 class="tt-title">Top 10 easter eggs in Red Dead Rede..</h6>
                                 <div class="tt-description">
                                    You can find these easter eggs in Red Dea..
                                 </div>
                              </a>
                           </li>
                           <li>
                              <a href="page-single-topic.html">
                                 <h6 class="tt-title">Red Dead Redemtion: Arthur Morgan..</h6>
                                 <div class="tt-description">
                                    Here’s what I’ve found in Red Dead Redem..
                                 </div>
                              </a>
                           </li>
                           <li>
                              <a href="page-single-topic.html">
                                 <h6 class="tt-title">Rdr2 secret easter eggs</h6>
                                 <div class="tt-description">
                                    Here’s what I’ve found in Red Dead Redem..
                                 </div>
                              </a>
                           </li>
                           <li>
                              <a href="page-single-topic.html">
                                 <h6 class="tt-title">Top 10 easter eggs in Red Dead Rede..</h6>
                                 <div class="tt-description">
                                    You can find these easter eggs in Red Dea..
                                 </div>
                              </a>
                           </li>
                           <li>
                              <a href="page-single-topic.html">
                                 <h6 class="tt-title">Red Dead Redemtion: Arthur Morgan..</h6>
                                 <div class="tt-description">
                                    Here’s what I’ve found in Red Dead Redem..
                                 </div>
                              </a>
                           </li>
                        </ul>
                     </div>
                     <button type="button" class="tt-view-all" data-toggle="modal" data-target="#modalAdvancedSearch">Advanced Search</button>
                  </div>
               </form>
            </div>
            <!-- /tt-search -->
         </div>
         <!-- Auth Nav -->
         <?php
            if( $this->session->userdata('loggedUser') ) { 
              $loggedUser = $this->session->userdata('loggedUser');
              ?>

         <div class="col-auto ml-auto">
            <div class="tt-user-info d-flex justify-content-center">
               <a href="#" class="tt-btn-icon">
                  <i class="tt-icon">
                     <svg>
                        <use xlink:href="#icon-notification"></use>
                     </svg>
                  </i>
               </a>
               <div class="tt-avatar-icon tt-size-md">
                  <i class="tt-icon">
                     <svg>
                        <use xlink:href="#icon-ava-a"></use>
                     </svg>
                  </i>
               </div>
               <div class="custom-select-01">
                  <select onchange="location = this.value;">
                     <option value="Default Sorting"><?php echo $loggedUser['user_username']; ?></option>
                     <option value="<?php echo base_url(); ?>Profile">Profile</option>
                     <option value="<?php echo base_url(); ?>Forum/signout">Sign out</option>
                  </select>
               </div>
            </div>
         </div>

         <?php } else { ?>

         <div class="col-auto ml-auto">
            <div class="tt-account-btn">
               <a href="<?php echo base_url(); ?>signin" class="btn btn-primary">Log in</a>
               <a href="#" class="btn btn-secondary">Sign up</a>
            </div>
         </div>
         <?php }

            ?>
         <!-- Auth Nav -->
      </div>
   </div>
</header>



<a href="<?php echo base_url(); ?>posts/create_post_discussion" class="tt-btn-create-topic">
    <span class="tt-icon">
        <svg>
        <use xlink:href="#icon-create_new"></use>
        </svg>
    </span>
</a>