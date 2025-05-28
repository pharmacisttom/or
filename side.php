<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
      
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
  
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
        <div class="image-center">
        <img src="img/pdh.jpg" class="img-circle user-image" alt="Girl in a jacket" width="200" height="200">
        </div>
          <!-- <div class="pull-left info">
            <p>PDH Smart OR</p> -->
            <!-- Status -->
            <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
          <!-- </div> -->
        </div>
  
        <!-- search form (Optional) -->
        <!-- <form action="#" method="get" class="sidebar-form">
          <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
          </div>
        </form> -->
        <!-- /.search form -->
  
       
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header text-uppercase">เมนูหลัก</li>
            <!-- Menu Items -->
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                <a href="index.php"><i class="fas fa-home fa-fw mr-2"></i> <span>Home</span></a>
            </li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'pt.php' ? 'active' : ''; ?>">
                <a href="pt.php"><i class="fas fa-user-plus fa-fw mr-2"></i> <span>เพิ่มผู้ป่วย</span></a>
            </li>
            <li class="treeview <?php echo in_array(basename($_SERVER['PHP_SELF']), ['doctor.php', 'nurse.php', 'departs.php']) ? 'active' : ''; ?>">
                <a href="#">
                    <i class="fas fa-database fa-fw mr-2"></i> <span>ข้อมูลพื้นฐาน</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="doctor.php"><i class="fas fa-user-md fa-fw mr-2"></i> ข้อมูลแพทย์</a></li>
                    <li><a href="nurse.php"><i class="fas fa-user-nurse fa-fw mr-2"></i> ข้อมูลพยาบาล</a></li>
                    <li><a href="departs.php"><i class="fas fa-building fa-fw mr-2"></i> ข้อมูลแผนก</a></li>
                </ul>
            </li>
            <li class="treeview <?php echo basename($_SERVER['PHP_SELF']) == 'report_surgery_bookings.php' ? 'active' : ''; ?>">
                <a href="#">
                    <i class="fas fa-chart-bar fa-fw mr-2"></i> <span>ข้อมูลสถิติ</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="report_surgery_bookings.php"><i class="fas fa-file-medical fa-fw mr-2"></i> ข้อมูลผู้ป่วยที่รับบริการ</a></li>
                </ul>
            </li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'userdashboard.php' ? 'active' : ''; ?>">
                <a href="http://192.168.111.240/or/"><i class="fas fa-user fa-fw mr-2"></i> <span>User View</span></a>
            </li>
            <li>
                <a href="logout.php"><i class="fas fa-sign-out-alt fa-fw mr-2"></i> <span>Log Out</span></a>
            </li>
        </ul>
        <!-- /.sidebar-menu -->
      </section>
      <!-- /.sidebar -->
    </aside>