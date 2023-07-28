<?php

session_start();
if (isset($_SESSION["user-username"])) {

  require_once "Include/db.php";

  $currentuser = $_SESSION["user-username"];
  $subscribed = 1;

  $sql = "UPDATE user_accounts SET subscribed='$subscribed' WHERE username='$currentuser'";
      $Execute = $ConnectingDB->query($sql);
      if ($Execute) {
        echo '<script>window.open(confirmation.php?username=<?php echo $currentuser; ?>,"_self")</script>';
      } else {
        echo '<script>alert("Changes were not updated, please try again")</script>';
      }

?>




  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="Include/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous" async>
    </script>

  </head>

  <body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link" aria-current="page" href="index.php"><i class="fa fa-fw fa-home"></i> Home</a>
            <a class="nav-link" href="view-catalog.php"><i class="fa fa-fw fa-search"></i> Catalog</a>
            <a class="nav-link" href="user-profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
            <a class="nav-link" href="subscribe.php"><i class="fa fa-fw fa-check"></i> Subscribe</a>            
            <a class="nav-link" href="logout.php"><i class="fa fa-fw fa-lock"></i> Log out</a>
          </div>
        </div>
      </div>
    </nav>


    <div class="container mt-4 mb-4">
      <div class="row d-flex cart align-items-center justify-content-center">
        <div class="col-md-10">
          <div class="card">
            <div class="d-flex justify-content-center border-bottom">
              <div class="p-3">
                <div class="progresses">
                  <div class="steps"> <span><i class="fa fa-check"></i></span> </div> <span class="line"></span>
                  <div class="steps"> <span><i class="fa fa-check"></i></span> </div> <span class="line"></span>
                  <div class="steps"> <span class="font-weight-bold">3</span> </div>
                </div>
              </div>
            </div>
            <div class="row g-0">
              <div class="col-md-6 border-right p-5">
                <div class="text-center order-details">
                  <div class="d-flex justify-content-center mb-5 flex-column align-items-center"> <span class="check1"><i class="fa fa-check"></i></span> <span class="font-weight-bold">Order Confirmed</span> <small class="mt-2">Your subscription has been confirmed!</small>  </div> 
                </div>
              </div>
              <div class="col-md-6 background-muted">
                
                <div class="row g-0 border-bottom">
                  <div class="col-md-6 border-right">
                    <div class="p-3 d-flex justify-content-center align-items-center"> <span>Subscription</span> </div>
                  </div>
                  <div class="col-md-6">
                    <div class="p-3 d-flex justify-content-center align-items-center"> <span>x1</span> </div>
                  </div>
                </div>
                <div class="row g-0 border-bottom">
                  <div class="col-md-6">
                    <div class="p-3 d-flex justify-content-center align-items-center"> <span>Price</span> </div>
                  </div>
                  <div class="col-md-6">
                    <div class="p-3 d-flex justify-content-center align-items-center"> <span>$9.99</span> </div>
                  </div>
                </div>
                <div class="row g-0 border-bottom">
                  <div class="col-md-6">
                    <div class="p-3 d-flex justify-content-center align-items-center"> <span>Taxes</span> </div>
                  </div>
                  <div class="col-md-6">
                    <div class="p-3 d-flex justify-content-center align-items-center"> <span>$1.29</span> </div>
                  </div>
                </div>
                <div class="row g-0">
                  <div class="col-md-6">
                    <div class="p-3 d-flex justify-content-center align-items-center"> <span class="font-weight-bold">Total</span> </div>
                  </div>
                  <div class="col-md-6">
                    <div class="p-3 d-flex justify-content-center align-items-center"> <span class="font-weight-bold">$11.28</span> </div>
                  </div>
                </div>
              </div>
            </div>
            <div> </div>
          </div>
        </div>
      </div>
    </div>

    <style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap");

      body {
        background-color: #eee;        
      }

      .cart {
        height: 100vh
      }

      .progresses {
        display: flex;
        align-items: center
      }

      .line {
        width: 76px;
        height: 6px;
        background: #63d19e
      }

      .steps {
        display: flex;
        background-color: #63d19e;
        color: #fff;
        font-size: 12px;
        width: 30px;
        height: 30px;
        align-items: center;
        justify-content: center;
        border-radius: 50%
      }

      .check1 {
        display: flex;
        background-color: #63d19e;
        color: #fff;
        font-size: 17px;
        width: 60px;
        height: 60px;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-bottom: 10px
      }

      .invoice-link {
        font-size: 15px
      }

      .order-button {
        height: 50px
      }

      .background-muted {
        background-color: #fafafc
      }
    </style>


  </body>

  </html>


<?php

} else {
  header("Location: index.php");

  // EOF

}

?>