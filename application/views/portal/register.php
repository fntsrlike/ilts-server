<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>register</title>
</head>
<body>
    <form action="<?php echo $form_action;?>" method="post">
        name: 
        <input type="text" name="username" />
        <input type="hidden" name="value" value="<?php echo $provider_value;?>" />
        <input type="submit" name="submit" value="submit" />
    </form>
</body>
</html>