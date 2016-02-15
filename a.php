<body>
<div>
    <form action="b.php" enctype="multipart/form-data" method="post" target="iframeUpload">
        <iframe name="iframeUpload" width="400" height="400" frameborder='1'></iframe>
        <input type="hidden" name="UPLOAD_IDENTIFIER" value="1" />
        <input id="file1" name="file1" type="file"/>
        <input value="上传" type="submit" onclick="startProgress()"/>
    </form>
</div>
<div>
    <div class="barinner"></div>
</div>
<div id='showNum'></div>
<div class="prbar">
    <div class="prpos barinner"></div>
</div>
</body>



<style type="text/css">
    .prbar {
        margin:5px;
        width:500px;
        background-color:#dddddd;
        overflow:hidden;

        /* 边框效果 */
        border: 1px solid #bbbbbb;
        -moz-border-radius: 15px;
        border-radius: 15px;

        /* 为进度条增加阴影效果 */
        -webkit-box-shadow: 0px 2px 4px #555555;
        -moz-box-shadow: 0px 2px 4px #555555;
        box-shadow: 0px 2px 4px #555555;
    }
    /* No rounded corners for Opera, because the overflow:hidden dont work with rounded corners */
    doesnotexist:-o-prefocus, .prbar {
        border-radius:0px;
    }
    .prpos {
        width:0%;
        height:30px;
        background-color:#3399ff;
        border-right:1px solid #bbbbbb;
        /* CSS3 进度条渐变 */
        transition: width 2s ease;
        -webkit-transition: width 0s ease;
        -o-transition: width 0s ease;
        -moz-transition: width 0s ease;
        -ms-transition: width 0s ease;
        /* CSS3 Stripes */
        background-image: linear-gradient(135deg,#3399ff 25%,#99ccff 25%,#99ccff 50%, #3399ff 50%, #3399ff 75%,#99ccff 75%,#99ccff 100%);
        background-image: -moz-linear-gradient(135deg,#3399ff 25%,#99ccff 25%,#99ccff 50%, #3399ff 50%, #3399ff 75%,#99ccff 75%,#99ccff 100%);
        background-image: -ms-linear-gradient(135deg,#3399ff 25%,#99ccff 25%,#99ccff 50%, #3399ff 50%, #3399ff 75%,#99ccff 75%,#99ccff 100%);
        background-image: -o-linear-gradient(135deg,#3399ff 25%,#99ccff 25%,#99ccff 50%, #3399ff 50%, #3399ff 75%,#99ccff 75%,#99ccff 100%);
        background-image: -webkit-gradient(linear, 100% 100%, 0 0,color-stop(.25, #99ccff), color-stop(.25, #3399ff),color-stop(.5, #3399ff),color-stop(.5, #99ccff),color-stop(.75, #99ccff),color-stop(.75, #3399ff),color-stop(1, #3399ff));
        background-image: -webkit-linear-gradient(135deg,#3399ff 25%,#99ccff 25%,#99ccff 50%, #3399ff 50%, #3399ff 75%,#99ccff 75%,#99ccff 100%);
        background-size: 40px 40px;
        /* Background stripes animation */
        animation: bganim 3s linear 2s infinite;
        -moz-animation: bganim 3s linear 2s infinite;
        -webkit-animation: bganim 3s linear 2s infinite;
        -o-animation: bganim 3s linear 2s infinite;
        -ms-animation: bganim 3s linear 2s infinite;
    }
    @keyframes bganim {
        from {background-position:0px;} to { background-position:40px;}
    }
    @-moz-keyframes bganim {
        from {background-position:0px;} to { background-position:40px;}
    }
    @-webkit-keyframes bganim {
        from {background-position:0px;} to { background-position:40px;}
    }
    @-o-keyframes bganim {
        from {background-position:0px;} to { background-position:40px;}
    }
    @-ms-keyframes bganim {
        from {background-position:0px;} to { background-position:40px;}
    }
</style>

