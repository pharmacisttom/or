<?php
include('config.php');
?> 

<!DOCTYPE html>
<html lang="en">
<?php include('head1.php');?>
<body class="skin-blue">


    <div class="wrapper">

        <!-- Main Header -->
<?php include('header.php');?>  

<?php include('side.php');?>
      
        <!-- Content Wrapper. Contains page content -->
<?php include('wrappernurse.php');?>
        <!-- /.content-wrapper -->
      
        <!-- Main Footer -->
<?php include('footer.php');?>
      
    <!-- <?php include('considebar.php');?> -->
        <!-- Add the sidebar's background. This div must be placed
        immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
      </div>
      <!-- ./wrapper -->
      
    

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/adminlte.min.js"></script>
        <!-- jQuery Version 1.11.1 -->
        <script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

  <script>
        $('#myBox').boxWidget({
            animationSpeed: 500,
            collapseTrigger: '#boxBtn',
            removeTrigger: '#my-remove-button-trigger',
            collapseIcon: 'fa-minus',
            expandIcon: 'fa-plus',
            removeIcon: 'fa-times'
        })
  </script>

  <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script src="script.js"></script>

    
    
</body>
</html>