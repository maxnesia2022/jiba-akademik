<?
require_once("include/sessioninfo.php"); 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JIBAS Akademik - Bottom Frame</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script language="javascript" src="script/clock.js"></script>
    <script type="text/javascript" language="JavaScript">
    function get_fresh(){
        document.location.reload();
    }
    function BlinkText(Current){
        if (Current=='')
            Current=0;
        Current = parseInt(Current);
        var Txt = "DEMO Version";

        if (Current==(Txt.length+10)){
            Current=0;
            document.getElementById('TxtDemo').innerHTML = '';
        }
        var	x   = Txt.charAt(Current);
        Current = parseInt(Current);
        setTimeout("BlinkText2('"+x+"','"+Current+"')",100);
    }
    function BlinkText2(x,Current){
        var y = document.getElementById('TxtDemo').innerHTML;
        document.getElementById('TxtDemo').innerHTML = y+x;
        Current = parseInt(Current);
        BlinkText(Current+1);
    }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<!-- Menggunakan background green-950 yang solid agar menyatu penuh -->
<body class="bg-green-950 text-white overflow-hidden m-0 p-0 select-none">
    <!-- Bottom Bar Container - Gradasi dari green-950 ke green-950 -->
    <div class="w-full h-[40px] bg-gradient-to-r from-green-950 to-green-950 px-4 flex items-center justify-between border-t border-green-800 shadow-inner">
        <!-- User Session Indicator -->
        <div class="flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
            <span class="text-xs text-green-300 font-medium">Pengguna Aktif:</span>
            <!-- Menggunakan emerald-900 sebagai background badge informasi pengguna -->
            <div class="bg-emerald-900 border border-emerald-700/50 px-3 py-1 rounded-md text-xs font-semibold text-emerald-100 flex items-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-user-tie text-emerald-400"></i>
                <span>
                    <?
                    if ($_SESSION['namasimaka']=="landlord"){
                        echo "Administrator JIBAS [Akademik]";
                    } else {
                        echo $_SESSION['namasimaka'];
                    }
                    ?>
                </span>
            </div>
        </div>

        <!-- Right Side: Demo Marker & App Status -->
        <div class="flex items-center gap-4">
            <!-- Demo Text Target Element -->
            <div id="TxtDemo" class="text-rose-400 font-bold text-xs tracking-wider uppercase animate-pulse"></div>
            
            <div class="text-[11px] text-green-400/80 font-medium flex items-center gap-1">
                <i class="fa-solid fa-shield-halved text-emerald-400"></i> Secured Connection
            </div>
        </div>
    </div>
</body>
</html>