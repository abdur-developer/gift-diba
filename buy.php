<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; 

    if(isset($_REQUEST['name'])){
        $_SESSION['name'] = $_REQUEST['name'];
        $_SESSION['number'] = $_REQUEST['number'];
        $_SESSION['type'] = $_REQUEST['type'];
        $_SESSION['payment'] = $_REQUEST['payment']; //payment options

        header("location: payment.php");
    }
?>


<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">

        <?php include 'includes/navbar.php'; ?>

        <div class="content-wrapper">
            <div class="container">

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-sm-9">
                            <!-- ============================================== -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><b>Order Confirm</b></h4>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" method="POST" action="">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-3 control-label">Full Name</label>

                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="<?= $user['firstname'] . ' ' . $user['lastname'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="number" class="col-sm-3 control-label">Phone number</label>

                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" id="number" name="number"
                                                    value="<?= $user['contact_info'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="address" class="col-sm-3 control-label">Address</label>

                                            <div class="col-sm-9">
                                            <textarea class="form-control" id="address" name="address"><?= $user['address'] ?></textarea>
                                            </div>
                                        </div>
                                        <!--
                                        <div class="form-group">
                                            <label for="frame" class="col-sm-3 control-label">Frame color</label>

                                            <div class="col-sm-9">
                                                <div class="col-sm-2">
                                                    <input type="radio" id="frame" name="frame" value="black" checked>
                                                    <label for="payment">Black</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="radio" id="frame" name="frame" value="white">
                                                    <label for="payment">White</label><br>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="radio" id="frame" name="frame" value="printed">
                                                    <label for="payment">Printed</label><br>
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="radio" id="frame" name="frame" value="wooden">
                                                    <label for="payment">Wooden</label><br>
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="radio" id="frame" name="frame" value="wall-board">
                                                    <label for="payment">Wall Board</label><br>
                                                </div>
                                            </div>
                                        </div>-->
                                        <div class="form-group">
                                            <label for="type" class="col-sm-3 control-label">Delivery Type</label>

                                            <div class="col-sm-9">
                                                <select class="form-control input-sm" id="type" name="type">
                                                    <option value="outsite">Outsite Dinajpur</option>
                                                    <option value="insite" selected>Inside Dinajpur</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="payment" class="col-sm-3 control-label">Payment Option</label>

                                            <div class="col-sm-9">
                                                <div class="col-sm-4">
                                                    <input type="radio" id="payment" name="payment" value="only_delivery" checked>
                                                    <label for="payment">Pay order confimation</label>
                                                </div>
                                                <div class="col-sm-5">
                                                    <input type="radio" id="payment" name="payment" value="full_paymentgit ">
                                                    <label for="payment">Pay Full Payment</label><br>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-9"></div>
                                            <input type="submit" class="btn btn-success btn-flat col-sm-2 mr-4" value="Pay with bkash">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- ============================================== -->
                        </div>
                        <div class="col-sm-3">
                            <?php include 'includes/sidebar.php'; ?>
                        </div>
                    </div>
                </section>

            </div>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>

    <?php include 'includes/scripts.php'; ?>
</body>

</html>