<h2>使用者：<?php echo $username;?></h2>

<h3>一般資訊</h3>
<ul>
    <li>使用者ID：<?php echo $id;?></li>
    <li>使用者名稱：<?php echo $username;?></li>
    <li>使用者狀態：<?php echo $status;?></li>
    <li>註冊日期：<?php echo $register;?></li>
    <li>登入提供者：<?php echo $provider;?></li>
</ul>

<h3>權限</h3>
<?php echo $table;?>