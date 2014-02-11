<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>伊爾特系統 - 應用程式授權</title>

    <style type="text/css">
        #block {
            border-radius: 30px;
            background-color: white;
            padding-left: 50px;
            padding-right: 50px;
            padding-bottom: 30px;
            max-width: 430px;
            position: relative;
            margin-top: 30px;
        }

        .title {
            padding-top: 30px;
            padding-left: 12px;
            margin-bottom: 16px;

            font-size: 18px;
            font-weight: bold;
            color: #262626;
            cursor: pointer;
        }

        .need {

            font-size: 16px;
            padding-left: 12px;
            padding-top: 22px;
            padding-bottom: 14px;

        }

        .need-list {
            border-top: 1px solid #ebebeb;
            padding-left: 12px;
            padding-top: 22px;
            padding-bottom: 14px;
        }

        .confirm {
            border-top: 1px solid #ebebeb;
            padding-left: 12px;
            padding-top: 22px;
            padding-bottom: 14px;

        }

        .btn {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <h1 class="text-center">伊爾特系統</h1>

    <div id="block" class="container">

        <div class="row title">
            <span>應用程式辨識錯誤</span>
        </div>
        <div class="clear">
        </div>
        <div class="row need">
            <span>你所使用的應用程式可能發生以下錯誤：</span>
        </div>

        <div class="row need-list">
            <p><span class="glyphicon glyphicon-remove"></span> 尚未註冊API</p>
            <p><span class="glyphicon glyphicon-remove"></span> 辨識代碼錯誤</p>
            <p><span class="glyphicon glyphicon-remove"></span> 來源網址錯誤</p>
        </div>

        <div class="row confirm">
            <a href="#">
                <button type="submit" class="btn btn-default pull-right">回到學生會網站</button>
            </a>
        </div>
    </div>


    <script type="text/javascript" src="http://res.nchusg.org/nav/nav.js"></script>
    <script type="text/javascript">
        rs_nav.load({
            complete:function(){}, //此 function 將在 jQuery,Bootstrap,NavBarHTML,[bs.css] 讀取完畢之後執行
            afterfadeIn:function(){}, //此 function 將在 complete 之後 進行淡入完畢後執行 (若 fadeIn:true)
            autoHideReady:function(){}, //此 function 將在 autoHide 的整套套用動作準備完畢之後執行
            bsCss:true, //若為 true, 將會套用興大學生會主題的CSS，不過這個CSS目前只有藍天白雲的背景
            fadeIn:true, //若為 true, 從 rs_nav.load 被呼叫開始將會把 body 設為 display:none; 在 complete 之後再淡入
            autoHide:true, //若為 true, 將會讓網頁可以自動隱藏導覽列(往下捲的時候)
            message:false, //若為 true, 可以在瀏覽器的 console 看到載入的訊息
        });
    </script>
</body>
</html>