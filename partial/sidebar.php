<?php
// Include the configuration file
include_once $_SERVER['DOCUMENT_ROOT'] . '/Volcano/vnd-admin-user/base.php';
?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="font-size: 14px;">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class=""></i>
        </div>
        <div class="sidebar-brand-text mx-3">
            VMIMS
        </div>

    </a>
    <!--
      <div class="sidebar-brand-text mx-3">
          <img src="img/logo4.png" alt="Your Image Description">
        </div> -->
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?php echo BASE_URL; ?>navigation.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Deployment Equipment Archives
    </div>

    <li class="nav-item">
        <a class="nav-link" href="<?php echo BASE_URL; ?>transaction/table.php">
            <i class="fas fa-fw fa-solid fa-table"></i>
            <span>Original PAR/ICS Document
            </span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo BASE_URL; ?>transaction/old/table.php">
            <i class="fas fa-fw fa-solid fa-table"></i>
            <span>Old PAR/ICS Transaction Records
            </span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Volcano Network Development
    </div>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo BASE_URL; ?>equipment inventory/table.php">
            <i class="fas fa-fw fa-solid fa-table"></i>
            <span>Equipment Inventory</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages2" aria-expanded="true" aria-controls="collapsePages3">
            <i class="fas fa-fw fa-regular fa-flag"></i>
            <span>Monitoring Station</span>
        </a>
        <div id="collapsePages2" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Select</h6>
                <a class="collapse-item" href="<?php echo BASE_URL; ?>volcano/Deployed/table.php">Deployed
                    Equipment</a>

                <a class="collapse-item" href="<?php echo BASE_URL; ?>volcano/Station Coordinates/table.php">Station Coordinates</a>
            </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages3" aria-expanded="true" aria-controls="collapsePages3">
            <i class="fas fa-fw fa-regular fa-flag"></i>
            <span>Volcano Monitoring Networks</span>
        </a>

        <div id="collapsePages3" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Select</h6>
                <a class="collapse-item" href="<?php echo BASE_URL; ?>volcano/Diagram/NetworkDiagram.php">Network
                    Diagram</a>
                <a class="collapse-item" href="<?php echo BASE_URL; ?>volcano/Network/Map.php">Network Map</a>
                <a class="collapse-item" href="<?php echo BASE_URL; ?>volcano/Observatory/Observatory.php">Observatory
                    Photo</a>
                <a class="collapse-item" href="<?php echo BASE_URL; ?>volcano/Acquisition/Data.php">Data Acquisition
                    System</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Volcano Observatory
    </div>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo BASE_URL; ?>inventory manager/inventory.php">
            <i class="fas fa-fw fa-solid fa-table"></i>
            <span>Hardware Inventory</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo BASE_URL; ?>maintenance/maintenance.php">
            <i class="fas fa-fw fa-solid fa-table"></i>
            <span>Maintenance Log</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Utilities
    </div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePagesUtil" aria-expanded="true" aria-controls="collapsePagesUtil">
            <i class="fas fa-fw fa-solid fa-toolbox"></i>
            <span>Categories/Station</span>
        </a>

        <div id="collapsePagesUtil" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Select</h6>
                <a class="collapse-item" href="<?php echo BASE_URL; ?>utilities/inventory/condition.php">
                    <span>Equipment Condition</span></a>
                <a class="collapse-item" href="<?php echo BASE_URL; ?>utilities/equipment.php">
                    <span>Equipment Categories</span></a>

                <a class="collapse-item" href="<?php echo BASE_URL; ?>utilities/volcano-remote-station/category.php">
                    <span>Remote Station Type <br> Categories</span></a>

                <a class="collapse-item" href="<?php echo BASE_URL; ?>utilities/stations/station.php">
                    <span>Remote Station Code</span></a>
            </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo BASE_URL; ?>utilities/user/vnd-user.php">
            <i class="fas fa-fw fa-solid fa-unlock-alt"></i>
            <span>User Access Rights</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-solid fa-table"></i>
            <span>Activity Log</span></a>
    </li>
    <hr class="sidebar-divider">

</ul>