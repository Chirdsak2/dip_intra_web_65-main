<div class="container-fluid pl-0 pr-0 fixed-top">

    <nav class="navbar navbar-expand-lg navbar-light bg-white ">
        <div class="container">
            <a class="navbar-brand pb-2" href="index.php"> <img src="http://203.151.166.134/PRD_INTRA_WEB/ewt/prd_intra_web/<?php echo $logo['site_logo'];?>" title="logo"
                    alt="logo" class="max-width-logo"> </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <?php echo $menu_view3; ?>
            </div>
        </div>
    </nav>

    <div id="search">
        <button type="button" class="close">×</button>
        <form>
            <input type="search" value="" placeholder="ใส่คำค้นหาที่นี่..." class="mb-3" />
            <button type="submit" class="btn btn-success btn-lg border-ra-15"> ค้นหา </button>
        </form>
    </div>

</div>

<?php include 'popup-contact.php';?>