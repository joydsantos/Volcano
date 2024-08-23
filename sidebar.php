<head>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.css" rel="stylesheet">

</head>
<style type="text/css">
    @import url('https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500');
</style>


<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar"
    style="font-size: 14px;">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class=""></i>
        </div>
        <div class="sidebar-brand-text mx-3">Administrator</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="navigation.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Stock
    </div>
    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="equipment inventory/table.php">
            <i class="fas fa-fw fa-solid fa-table"></i>
            <span>Equipment Inventory</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Transaction
    </div>
    <li class="nav-item">
        <a class="nav-link" href="transaction/old/table.php">
            <i class="fas fa-fw fa-solid fa-table"></i>
            <span>Old Record</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="transaction/table.php">
            <i class="fas fa-fw fa-solid fa-table"></i>
            <span>On Stock</span></a>
    </li>
    <!-- Nav Item - Pages Collapse Menu -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Utilities
    </div>
    <li class="nav-item">
        <a class="nav-link" href="utilities/equipment.php">
            <i class="fas fa-fw fa-solid fa-toolbox"></i>
            <span>Equipment Categories</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="utilities/volcano-remote-station/category.php">
            <i class="fas fa-fw fa-solid fa-toolbox"></i>
            <span>Remote Categories</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="utilities/stations/station.php">
            <i class="fas fa-fw fa-solid fa-warehouse"></i>
            <span>Stations</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="utilities/user/vnd-user.php">
            <i class="fas fa-fw  fa-user"></i>
            <span>Users</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Volcano
    </div>
    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages3" aria-expanded="true"
            aria-controls="collapsePages3">
            <i class="fas fa-fw fa-regular fa-flag"></i>
            <span>Volcano Monitoring Network Stations</span>
        </a>
        <div id="collapsePages3" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Select</h6>
                <a class="collapse-item" href="volcano/remote/table.php">View Remote Station</a>
                <a class="collapse-item" href="volcano/Diagram/NetworkDiagram.php">Network Diagram</a>
                <a class="collapse-item" href="volcano/Network/Map.php">Network Map</a>
                <a class="collapse-item" href="volcano/Observatory/Observatory.php">Observatory Photo</a>
                <a class="collapse-item" href="volcano/Acquisition/Data.php">Data Acquisition System</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <!-- Nav Item - Tables -->
    <!-- Divider -->
</ul>