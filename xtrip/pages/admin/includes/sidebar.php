 <aside id="sidebar" class="sidebar">

     <ul class="sidebar-nav" id="sidebar-nav">

         <li class="nav-item">
             <a class="nav-link <?php echo htmlspecialchars($page_name === "dashboard" ? "" : "collapsed"); ?>" href="home.php?page=dashboard">
                 <i class="bi bi-grid"></i>
                 <span> Home </span>
             </a>
         </li>

         <li class="nav-item">
             <a class="nav-link <?php echo htmlspecialchars($page_name === "user-accounts" ? "" : "collapsed"); ?>" href="home.php?page=user-accounts">
                 <i class="bi bi-people"></i>
                 <span> User Accounts </span>
             </a>
         </li>

         <li class="nav-item position-relative">
             <a class="nav-link <?php echo htmlspecialchars($page_name === "inquiries" ? "" : "collapsed"); ?>" href="home.php?page=inquiries">
                 <i class="bi bi-envelope-check"></i>
                 <span> Email Inquiries </span>

                 <?php if($inquiry_count > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                        <?php echo htmlspecialchars($inquiry_count); ?>
                        <span class="visually-hidden"> Incomplete Inquiries </span>
                    </span>
                <?php endif; ?>
             </a>
         </li>

         <li class="nav-item">
             <a class="nav-link <?php echo htmlspecialchars($page_name === "laser-tripwire" ? "" : "collapsed"); ?>" href="home.php?page=laser-tripwire">
                 <i class="bi bi-box-seam"></i>
                 <span> Laser Tripwire Products </span>
             </a>
         </li>


         <li class="nav-heading"> Profile </li>

         <li class="nav-item">
             <a class="nav-link <?php echo htmlspecialchars($page_name === "user-profile" ? "" : "collapsed"); ?>" href="home.php?page=user-profile">
                 <i class="bi bi-person"></i>
                 <span> My Profile </span>
             </a>
         </li>

         <li class="nav-item">
             <a class="nav-link collapsed" href="logout.php">
                 <i class="bi bi-box-arrow-left"></i>
                 <span> Logout </span>
             </a>
         </li>

     </ul>

 </aside>