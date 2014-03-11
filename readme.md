伊爾特系統
---
## CH1: 關於
### 簡述
伊爾特系統（Ilt System），是透過使用者清單（List of User）、群組關係樹（Tree of Group Relationship）、辨識標籤（Identity Tag）組成的會員管理系統，取這三元素的頭字母為I-L-T，所以稱為伊爾特（Ilt）。
### 特色
- 整合OAuth登入與Provider的會員系統。
- 將使用者、群組、權限整合在一起的會員系統。
- 低耦合性，以伊爾特為中心，用OAuth Provider整合各項程式。

## CH2: 安裝
#### 步驟
- 執行終端指令 `git clone <本專案git位址>` 本專案到指定資料夾
- 將網路伺服器設定根目錄到本專案的public資料夾，或是指定到本專案根目錄的server資料夾。_（註1）_
- 執行終端指令 `composer update` ，更新vendor。_（註1）_
- 編輯 `app/config/app.php` ，將 `url` 參數修改為本專案的根目錄，並且更新 `key` 參數的值。_（註1）_
- 編輯 `app/config/database.php` ，修改資料庫連線參數。_（註1）_
- 編輯 `app/config/hybridauth.php` ，修改 `base_url` 參數，以及providers的 `id` 與 `secret` 。_（註2）_
- 編輯 `app/config/mail.php` ，修改Email Sever的相關參數。_（註1）_
- 執行終端指令 `php artisan migrate` ，建立資料表。
- 連線到網站，測試是否正常：
    - 是否能正常看到頁面。
    - 各項OAuth登入（Ex. Google, Facebook）是否都正常。
    - 到處丟測資，看會不會出現系統錯誤訊息，若有，請檢查是否為伺服器環境的問題。若認為是程式問題，請到本專案的頁面提報Issue。
- 清除各項測資。
- 編輯 `app/config/app.php` ，將 `debug` 參數改為 `false` 。
- 開始運作本網站囉！

#### 備註
1. 詳細請參照 [Laravel Framework][1] 的說明文件。
2. 詳細請參照 [Hybridauth][2] 官方文件或是 [此說明頁面][3]。

## CH3: 架構
### OAuth Login
本專案是使用hybridauth模組作為OAuth登入的後端程序，只要編輯 `app/config/hybridauth.php` 的參數，就可以實現多種OAuth的登入方式，至於有支援哪些OAuth Provider，可到 [Hybridauth][4] 官網查詢，本文就不多在這邊贅述。

在前端部分，本專案是使用基於 [Bootstrap][5] 和 [Font Awesome][6] 的 [Social Buttons for Bootstrap][7] ，作為前端社交按鈕的框架。若要新增首頁OAuth登入的按鈕，請參照該框架的說明文件，編輯 `app/views/portal/login.blade.php` 檔案，新增相對應的按鈕即可。

### OAuth Provider

### Ilt


  [1]: http://laravel.com/
  [2]: http://hybridauth.sourceforge.net/
  [3]: http://www.mrcasual.com/on/coding/laravel4-package-management-with-composer/
  [4]: http://hybridauth.sourceforge.net/
  [5]: http://getbootstrap.com/
  [6]: http://fortawesome.github.io/Font-Awesome/
  [7]: http://lipis.github.io/bootstrap-social/