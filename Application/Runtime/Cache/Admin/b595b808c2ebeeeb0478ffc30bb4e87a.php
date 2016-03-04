<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<link href="/favicon.ico" rel="icon" type="image/x-icon" />
    <title><?php echo C('SYSTEM_NAME');?></title>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="author" content="度月飞天 490702087@qq.com"/>
    <!-- 主题样式 -->
    <link href="/Public/UI/Ext/lib/packages/ext-theme-crisp-touch/build/resources/ext-theme-crisp-touch-all.css" rel="stylesheet" type="text/css"/>
    <link href="/Public/UI/css/myclass.css" rel="stylesheet" type="text/css"/>
    <link href="/Public/UI/css/msgpanels.css" rel="stylesheet" type="text/css"/>
    <!-- ico图标样式 -->
    <!-- ExtJs入口文件 -->
    <script src="/Public/UI/jq/jquery-1.8.3.min1530d1.js" charset="UTF-8" type="text/javascript"></script>
    <script src="/Public/UI/Ext/lib/ext-all-debug.js" charset="UTF-8" type="text/javascript"></script>
    <script src="/Public/UI/Ext/lib/forEach.js" charset="UTF-8" type="text/javascript"></script>
    <script src="/Public/UI/app/mux/startToolBar.js" charset="UTF-8" type="text/javascript"></script>

    <!-- Chart引用文件 -->
    <script src="/Public/UI/Ext/lib/packages/sencha-charts/build/sencha-charts.js"></script>
    <!-- 简体中文语言包 -->
    <script src="/Public/UI/Ext/lib/packages/ext-locale/build/ext-locale-zh_CN.js"></script>
    <script src="/Public/UI/app/extend/jq/startModel.js" type="text/javascript"></script>
    <script src="/Public/UI/app/extend/jq/publicfn.js" type="text/javascript"></script>
    <!-- 脚本程序 -->
    <script src="/Public/UI/app.js"></script>

</head>

<body class="my-desktop-bodycls">
    <div id="window"></div>
    <!-- <div id="table-logo"></div> -->
    <div id="loading-mask">
    </div>
    <div id='startmenudiv' class="hiddenmenu">
        <dl class="clearfix">
            <dt>
            </dt>
        </dl>
    </div>
    <script type="text/javascript">
        (function(){
            var t = $("#main-message-box").mouseenter(function(e){
                t.find(".panel-hide-show-btn").show(150);
            });
            $("#main-message-box").mouseleave(function(e){
                $("#main-message-box").find(".panel-hide-show-btn").hide(50);
            });

        })();
    </script>
</body>
</html>