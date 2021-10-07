<!-- MAIN PAGE -->
<section class="d-flex justify-content-center w-100 flex-column">
<!-- PAGE HEADER -->
<?php call_folder('public', 'header-page'); ?>
<!-- PAGE HEADER -->

<!-- CONTAINER TABLES -->
<div class="d-flex container-tables justify-content-between">

    <!-- CONTAINER BATUA -->
    <div class="container-batua">
    <?php call_folder('public', 'lista-batua'); ?>
    </div>
    <!-- CONTAINER BATUA -->

    <!-- CONTAINER HASEGAWA -->
    <div class="container-hasegawa">    
    <?php call_folder('public', 'lista-hasegawa'); ?>
    </div>
    <!-- CONTAINER HASEGAWA -->

</div>
<!-- CONTAINER TABLES -->
</section>
<!-- MAIN PAGE -->