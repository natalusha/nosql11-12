<header id="header"><!--header-->
    <div class="header-middle"><!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">

                            <li><a href="<?php echo FULL_PATH?>/"><i class="fa fa-lock"></i> Home</a></li>
                            <?php if (empty($_SESSION['login'])): ?>
                                <li><a href="<?php echo FULL_PATH?>/singin"><i class="fa fa-user"></i> Account</a></li>
                            <?php else: ?>
                                <li><a href="<?php echo FULL_PATH?>/admin"><i class="fa fa-user"></i><?php echo $_SESSION['login']; ?></a>
                                </li>
                            <?php endif ?>

                            <?php if (empty($_SESSION['login'])): ?>
                                <li><a href="<?php echo FULL_PATH?>/singin"><i class="fa fa-lock"></i> login</a></li>
                            <?php else: ?>
                                <li><a href="<?php echo FULL_PATH?>/logout"><i class="fa fa-lock"></i> logout</a></li>
                            <?php endif ?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header-middle-->

</header><!--/header-->

