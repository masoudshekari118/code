<?php
$message_sent = false;
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!$name || !$subject || !$email || !$message) {
        $error = "لطفا تمام فیلدهای ستاره‌دار را پر کنید.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "ایمیل وارد شده معتبر نیست.";
    } else {
        $to = "mshekari95@gmail.com";
        $email_subject = "پیام جدید از فرم تماس: " . $subject;
        $email_body = "نام: $name\n";
        $email_body .= "ایمیل: $email\n";
        $email_body .= "شماره تماس: $phone\n\n";
        $email_body .= "متن پیام:\n$message\n";

        $headers = "From: $email\r\nReply-To: $email\r\n";

        if (mail($to, $email_subject, $email_body, $headers)) {
            $message_sent = true;
        } else {
            $error = "ارسال پیام با خطا مواجه شد، لطفا دوباره تلاش کنید.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>فرم تماس با من</title>
<style>
    /* ریست ساده */
    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Tahoma', sans-serif;
        background: #f0f2f5;
        margin: 0; padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
    }

    .contact-form {
        background: #fff;
        padding: 25px 30px;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        max-width: 480px;
        width: 100%;
    }

    .contact-form h2 {
        margin-bottom: 20px;
        color: #333;
        text-align: center;
        font-weight: 700;
    }

    label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #555;
        direction: rtl;
    }

    input[type="text"],
    input[type="email"],
    textarea {
        width: 100%;
        padding: 12px 15px;
        margin-bottom: 18px;
        border: 1.8px solid #ddd;
        border-radius: 8px;
        font-size: 16px;
        transition: border-color 0.3s ease;
        resize: vertical;
        direction: rtl;
        font-family: 'Tahoma', sans-serif;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    textarea:focus {
        outline: none;
        border-color: #4CAF50;
        box-shadow: 0 0 6px #4CAF50aa;
    }

    textarea {
        min-height: 100px;
    }

    .btn-submit {
        background: #4CAF50;
        color: white;
        border: none;
        padding: 14px;
        width: 100%;
        font-size: 18px;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 700;
        transition: background-color 0.3s ease;
    }

    .btn-submit:hover {
        background: #45a049;
    }

    .message {
        text-align: center;
        margin-bottom: 15px;
        font-weight: 600;
        font-size: 16px;
        color: #d32f2f;
        direction: rtl;
    }

    .message.success {
        color: #388e3c;
    }

    @media (max-width: 500px) {
        .contact-form {
            padding: 20px;
            border-radius: 8px;
        }
        input[type="text"],
        input[type="email"],
        textarea {
            font-size: 14px;
            padding: 10px 12px;
        }
        .btn-submit {
            font-size: 16px;
            padding: 12px;
        }
    }
</style>
</head>
<body>

<div class="contact-form">
    <h2>تماس با من</h2>

    <?php if ($message_sent): ?>
        <p class="message success">پیام شما با موفقیت ارسال شد. ممنون از تماس شما!</p>
    <?php else: ?>
        <?php if ($error): ?>
            <p class="message"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="post" action="">
            <label for="name">نام *</label>
            <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($_POST['name'] ?? '') ?>">

            <label for="subject">موضوع *</label>
            <input type="text" id="subject" name="subject" required value="<?php echo htmlspecialchars($_POST['subject'] ?? '') ?>">

            <label for="email">ایمیل *</label>
            <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? '') ?>">

            <label for="phone">شماره تماس</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? '') ?>">

            <label for="message">متن پیام *</label>
            <textarea id="message" name="message" required><?php echo htmlspecialchars($_POST['message'] ?? '') ?></textarea>

            <button type="submit" class="btn-submit">ارسال</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
