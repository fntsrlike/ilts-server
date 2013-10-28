CodeIgniter環境初始化專案
==========================

## 說明


這是敝人在用codeigniter建構專案時，希望已經將常用的環境預設建置好，不用再重複設置所建立的REPO。

本REPO已安裝工具或以執行步驟：

1. 安裝 Spark
2. 安裝 Composer
3. 設置 url可省略index.php
4. 設置 .htaccess
5. 設置 databse除了default外，另外設置三種環境類型參數。
6. 設置 git-flow

## Spark
* 網站： [http://getsparks.org](http://getsparks.org)
* 安裝：
* 安裝方式：（已完成）
    * 到專案根目錄
    * `php -r "$(curl -fsSL http://getsparks.org/go-sparks)"`
* 使用方式：
    * CLI
        * `php tools/spark install -v1.0.0 example-spark`
    * Code
        * `$this->load->spark('example-spark/1.0.0');`
        * `$this->example_spark->printHello(); `


## Composer
* Website: [http://getcomposer.org/](http://getcomposer.org/)
* 安裝方式：（已完成）
    * [http://philsturgeon.co.uk/blog/2012/05/composer-with-codeigniter](Reference article)
    * 本專案沒有在專案底下建立，是使用系統的方式使用composer
* 使用方式：
    * 編輯 composer.json，加入想安裝的
    * `$ composer install`

## Git
* `git init` （已完成）

## Git Flow
* 安裝方式（已完成）
    * `brew install git-flow`
    * `git flow init`
* 主要分支
    * Develop: 
        * 最新的下次發佈開發狀態
    * Master: 
        * 永遠處在 production-ready 狀態
* 支援性分支
    * Feature branches: 
        * 開發新功能都從 develop 分支出來，完成後 merge 回 develop
    * Release branches: 
        * 準備要 release 的版本，只修 bugs。從 develop 分支出來，完成後 merge 回 master 和 develop
    * Hotfix branches: 
        * 等不及 release 版本就必須馬上修 master 趕上線的情況。會從 master 分支出來，完成後 merge 回 master 和 develop
