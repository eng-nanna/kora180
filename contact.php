<?php
require_once('includes/initialize.php');
include ("includes/public_header.php");
?>

<?php
if (isset($_POST['submit'])){
    $email_to = "support@kora180.com";

    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }

    $user_name = $_POST['name']; // required
    $email_from = $_POST['email']; // required
    $email_subject = $_POST['title']; // not required
    $msg = $_POST['message']; // required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if(!preg_match($email_exp,$email_from)) {
        $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";
    if(!preg_match($string_exp,$user_name)) {
        $error_message .= 'The First Name you entered does not appear to be valid.<br />';
    }

    if(strlen($msg) < 2) {
        $error_message .= 'The Comments you entered do not appear to be valid.<br />';
    }

    if(strlen($error_message) > 0) {
        died($error_message);
    }

    $email_message = "Form details below.\n\n";


    function clean_string($string) {
        $bad = array("content-type","bcc:","to:","cc:","href");
        return str_replace($bad,"",$string);
    }

    $email_message .= "User Name: ".clean_string($user_name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Message: ".clean_string($msg)."\n";

    // create email headers
    $headers = 'From: '.$email_from."\r\n".
        'Reply-To: '.$email_from."\r\n" .
        'X-Mailer: PHP/' . phpversion();
    @mail($email_to, $email_subject, $email_message, $headers);
    ?>
    Thank you for contacting us. We will be in touch with you very soon.
    <?php
}
?>
    <!-- Button trigger modal -->
    <main class="mt-5">
      <div class="container">

        <div class="row bg-white">
          <!-- MAIN AREA -->
          <div class="col-md-8">
            
            <section class="bg-white p-3 min-height">
              <h2 class="mb-3">تواصل معنا</h2>
              <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea neque, recusandae id inventore non, eos, pariatur et reiciendis optio impedit quaerat ipsam sint voluptas. Excepturi aliquam dolorum veritatis dolor molestias.
              </p>      
              <form class="form-style" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">الاسم</label>
                      <input type="text" class="form-control" id="name" aria-describedby="name" name="name" placeholder="الاسم">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">الايميل</label>
                      <input type="email" class="form-control text-left" id="email" aria-describedby="email" name="email" placeholder="example@domain.com">
                    </div>
                  </div>

                    <div class="col-12">
                        <div class="form-group">
                        <label for="title">عنوان الرسالة</label>
                        <input type="text" class="form-control text-left" id="title" aria-describedby="title" name="title">
                        </div>
                    </div>

                  <div class="col-12">
                    <textarea class="d-block w-100 mb-3" name="message" id="message" rows="10" placeholder="الرسالة"></textarea>
                  </div>
                  <div class="col-12 d-flex justify-content-end">
                    <input class="btn btn-primary btn-lg" type="submit" value="ارسال" name="submit">
                  </div>
                </div>
              </form>
            </section>

          </div> <!-- col-8 -->

          <!-- SIDEBAR -->
          <div class="col-md-4">
            
          </div> <!-- col-4 -->
        </div> <!-- .row -->

      </div>
      <!-- container -->
    </main>

<?php
include ("includes/public_footer.php");