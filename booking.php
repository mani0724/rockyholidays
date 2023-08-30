<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
        $name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $number = trim($_POST["number"]);
        $sdest = trim($_POST["s-destination"]);
        $edest = trim($_POST["e-destination"]);
        $passenger = trim($_POST["passenger"]);
        $date = trim($_POST["date"]);
        $time = trim($_POST["time"]);
        $vehicle = trim($_POST["vehicle"]);
        $message = trim($_POST["message"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($message) OR empty($number) OR empty($sdest) OR empty($edest) OR empty($passenger) OR empty($date) OR empty($time) OR empty($vehicle) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "th@gmail.com";

        // Set the email subject.
        $subject = "New Message for Booking";

        // Build the email content.
        $email_content = "Name: $name\n";
        $email_content .= "Subject: $subject\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Number: $number\n";
        $email_content .= "Start Destination: $sdest\n";
        $email_content .= "End Destination: $edest\n";
        $email_content .= "Passenger: $passenger\n";
        $email_content .= "Date: $date\n";
        $email_content .= "Time: $time\n";
        $email_content .= "Vehicle: $vehicle\n";
        $email_content .= "Message: \n$message\n";

        // Build the email headers.
        $email_headers = "From: $name <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You! Your message has been sent.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>
