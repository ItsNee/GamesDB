<!DOCTYPE html>
<html lang="en">
    <?php
    include "head.inc.php";
    ?>
    <script src="https://www.paypal.com/sdk/js?client-id=test&currency=USD"></script>
    <script src=”https://www.paypal.com/sdk/js?client-id=%CLIENT_ID%"></script>

    <style>
        .section{
            height:100%;
        }

        .card-header {
            padding: .5rem 1rem;
            margin-bottom: 0;
            background-color: rgba(0, 0, 0, .03);
        }

        .btn-light:focus {
            color: #212529;
            background-color: #e2e6ea;
            border-color: #dae0e5;
            box-shadow: 0 0 0 0.2rem rgba(216, 217, 219, .5)
        }

        .form-control {
            height: 50px;
            border: 2px solid #eee;
            border-radius: 6px;
            font-size: 14px
        }

        .form-control:focus {
            color: #495057;
            background-color: #fff;
            border-color: #039be5;
            outline: 0;
            box-shadow: none
        }

        .input {
            position: relative
        }

        .input i {
            position: absolute;
            top: 16px;
            left: 11px;
            color: #989898
        }

        .input input {
            text-indent: 25px
        }

        .card-text {
            font-size: 13px;
            margin-left: 6px
        }

        .certificate-text {
            font-size: 12px
        }

        .billing {
            font-size: 11px
        }

        .super-price {
            top: 0px;
            font-size: 22px
        }

        .super-month {
            font-size: 11px
        }

        .line {
            color: #bfbdbd
        }

        .free-button {
            background: #1565c0;
            height: 52px;
            font-size: 15px;
            border-radius: 8px
        }

        .payment-card-body {
            flex: 1 1 auto;
            padding: 24px 1rem !important
        }

        .paypal-logo {
            font-family: Verdana, Tahoma;
            font-weight: bold;
            font-size: 26px;

            i:first-child {
                color: #253b80;
            }

            i:last-child {
                color: #179bd7;
            }
        }
        .color1{
            color: #253b80;
        }
        .color2{
            color: #179bd7;
        }

        .paypal-button {
            padding: 15px 30px;
            border: 1px solid #FF9933;
            border-radius: 5px;
            background-image: linear-gradient(#FFF0A8, #F9B421);
            margin: 0 auto;
            display: block;
            min-width: 138px;
            position: relative;
        }

        paypal-button-title {
            font-size: 14px;
            color: #505050;
            vertical-align: baseline;
            text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.6);
        }

        .paypal-logo {
            display: inline-block;
            text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.6);
            font-size: 20px;
        }

        .box {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            padding: 1rem 0 1rem 0;
        }

        .border-0{
            border: none;
        }
        .card-other-option{
            margin-bottom: 1rem;
        }




    </style>
    <body id="page-top">
        <?php
        include "navPostLogin.inc.php";
        ?>
        <section>
            <div class="container d-flex justify-content-center mt-5 mb-5">
                <div class="row g-3">
                    <div class="col-md-6"> 

                        <!--Paypal-->
                        <div class ="card card-other-option">
                            <div class="card-header">
                                Express Checkout
                            </div>

                            <div class="card">

                                <div class="box">
                                    <button class="paypal-button">
                                        <span class="paypal-button-title">
                                            Checkout with 
                                        </span>
                                        <span class="paypal-logo">
                                            <i class = "color1">Pay</i><i class = "color2">Pal</i>
                                        </span>
                                    </button>
                                </div>

                            </div>
                        </div>
                        <!--Paypal-->

                        <!--Credit Card-->
                        <div class ="card">
                            <div class="card-header">
                                Credit Card
                                <div class="icons"> <img src="https://i.imgur.com/2ISgYja.png" width="30"> <img src="https://i.imgur.com/W1vtnOV.png" width="30">  </div>
                            </div>
                            <div class="card">
                                <div class="card-body payment-card-body"> <span class="font-weight-normal card-text">Card Number</span>
                                    <div class="input"> <i class="fa fa-credit-card"></i> <input type="text" class="form-control" placeholder="0000 0000 0000 0000"> </div>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-6"> <span class="font-weight-normal card-text">Expiry Date</span>
                                            <div class="input"> <i class="fa fa-calendar"></i> <input type="text" class="form-control" placeholder="MM/YY"> </div>
                                        </div>
                                        <div class="col-md-6"> <span class="font-weight-normal card-text">CVC/CVV</span>
                                            <div class="input"> <i class="fa fa-lock"></i> <input type="text" class="form-control" placeholder="000"> </div>
                                        </div>
                                    </div> <span class="text-muted certificate-text"><i class="fa fa-lock"></i> Your transaction is secured with ssl certificate</span>
                                </div>
                            </div>
                        </div>  
                        <!--Credit Card-->

                    </div>
                    <div class="col-md-6"> 
                        <div class="card">
                            <div class="card-header">Summary</div>
                            <div class="d-flex justify-content-between p-3">
                                <div class="d-flex flex-column"> <span>Total :</span></div>
                                <div class="mt-1"> <sup class="super-price">$9.99</sup> </div>
                            </div>
                            <hr class="mt-0 line">
                            <div class="p-3">
                                <div class="d-flex justify-content-between"> <span>Vat <i class="fa fa-clock-o"></i></span> <span>-20%</span> </div>
                                <div class="d-flex justify-content-between"> <span>Vat <i class="fa fa-clock-o"></i></span> <span>-20%</span> </div>
                                <div class="d-flex justify-content-between"> <span>Vat <i class="fa fa-clock-o"></i></span> <span>-20%</span> </div>
                                <div class="d-flex justify-content-between"> <span>Vat <i class="fa fa-clock-o"></i></span> <span>-20%</span> </div>
                            </div>
                            <hr class="mt-0 line">
                            <div class="p-3 d-flex justify-content-between">
                                <div class="d-flex flex-column">  </div> 
                            </div>
                            <div class="p-3 text-center"> <button class="btn btn-primary btn-block free-button">Checkout</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </section>


        <!--        <header style ="height:100%;" class="masthead">
                    <div class="container px-5 text-center">
                        <div class="row gx-14 align-items-center">
                            <div class="col-lg-14">
                                <div class="mb-5 mb-lg-0 text-center text-lg-start">
                                    <h1 class="display-4 lh-1 mb-3 text-center">Your cart is empty!</h1>
                                    <p class="lead fw-normal text-muted mb-5 text-center"><a href="games.php"> Browse games here </a></p>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </header>-->
        <?php
        include "footer.inc.php";
        ?>



        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
