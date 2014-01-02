<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>伊爾特系統Demo</title>
  <link rel="stylesheet" href="<?php echo base_url('/assets/bootstrap.min.css');?>">
  <script src="<?php echo base_url('/assets/jquery.js');?>"></script>
</head>
<body>
  <div class="container">

    <div class="text-center" style="margin-top:200px">
      <h1>伊爾特系統Demo</h1>
      <a href="<?php echo base_url('portal/oauth_process/google');?>" class="btn btn-primary btn-lg" style="margin:1em 0">使用Google登入</a>
      <p>
        您尚無權限使用本系統的特殊功能。<br/>
        本站利用oAuth2進行登入，歡迎註冊成為會員使用本服務。
      </p>
      <p class="text-info">
        本Demo由Fntsrlike（凌若虛）為了興大學生會網站所做會員系統理論的實例，<br />
        並且為其推甄國立中央大學軟體工程所之上傳的代表作品。
      </p>
    </div>
  </div>
  <script src="<?php echo base_url('/assests/bootstrap.min.js');?>"></script>
</body>
</html>