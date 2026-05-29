 <aside id="sidebar" class="sidebar">

     <ul class="sidebar-nav" id="sidebar-nav">

         <li class="nav-item">
             <a class="nav-link <?php echo htmlspecialchars($page_name === "dashboard" ? "" : "collapsed"); ?>" href="home.php?page=dashboard">
                 <i class="bi bi-grid"></i>
                 <span> Home </span>
             </a>
         </li>

         <li class="nav-item">
             <a class="nav-link <?php echo htmlspecialchars($page_name === "my-devices" ? "" : "collapsed"); ?>" href="home.php?page=my-devices">
                 <i class="bi bi-hdd-network"></i>
                 <span> My Devices </span>
             </a>
         </li>

         <li class="nav-item">
             <a class="nav-link <?php echo htmlspecialchars($page_name === "alerts" ? "" : "collapsed"); ?>" href="home.php?page=alerts">
                 <i class="bi bi-bell"></i>
                 <span> Alerts </span>
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