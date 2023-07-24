<?php
require_once 'modules/protect.php';
Protect\with('modules/protect_form.php','Admin');
?>
<!DOCTYPE html>
<html>
<head>
    <?php
    // 配置设置，请根据需要编辑 config.php 中的设置
    include('config.php');

    // 设置时区
    if (!ini_get('date.timezone')) {
        date_default_timezone_set('GMT');
    }

    function ago($time)
    {
        // https://css-tricks.com/snippets/php/time-ago-function/
        $periods = array("秒", "分钟", "小时", "天", "周", "个月", "年", "十年");
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");
        $now = time();
        $difference = $now - $time;
        $tense = "前";

        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if ($difference != 1) {
            $periods[$j] .= "s";
        }

        return "$difference$periods[$j]$tense";
    }

    function human_filesize($bytes, $decimals = 2)
    {
        // 来自用户在 phpfilesize 页面上的贡献
        $sz = 'bkMGTP';
        $szWords = array('字节', 'KB', 'MB', 'GB', 'TB', 'PB');
        $factor = floor((strlen($bytes) - 1) / 3);

        if (@$sz[$factor] == 'b') {
            $decimals = 0;
        }

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . '' . @$szWords[$factor];
    }
    ?>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>便签列表</title>
    <script src="js/notelist.min.js"></script>
    <link rel="shortcut icon" href="favicon.ico"/>
    <style>
        body {
            margin-left: 20px;
            margin-top: 20px;
            font-family: sans-serif;
        }

        th {
            display: table-cell;
            vertical-align: inherit;
            font-weight: bold;
            text-align: left;
        }

        th, td {
            padding-right: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        input[type=text] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: none;
            background-color: #f2f2f2;
            font-size: 16px;
        }
    </style>
</head>
<body>
<a href="<?php print $base_url; ?>">新建便签</a><br><br>
<table id="filterTable">
    <tr>
        <th><input type="text" id="filterNotes" onkeyup="filterTable()" placeholder="按便签标题筛选.."
                   style="background:transparent;border:none;"></th>
    </tr>
</table>
<table id="notelistTable">
    <th onclick="sortTable(0)">名称</th>
    <th onclick="sortTable(1)"><small>最后修改时间</small></th>
    <th><small>文件大小</small></th>

    <?php
    $files = array_diff(scandir($data_directory), array('.', '..', '.htaccess'));
    $counter = 0;
    $counterMax = 500; // 最多显示的便签数

    foreach ($files as &$value) {
        if ($counter > $counterMax) {
            echo "<tr><td>达到最大显示便签数（" . $counterMax . "）</td><td></td>";
            break; // 有一个最大显示的便签数
        }

        echo "<tr><td style='padding-right:20px;'><a href='" . $value . "'>" . $value . "</a></td>";
        echo "<td><small>" . ago(filemtime($data_directory . '/' . $value)) . "</small></td>";
        echo "<td><small>" . human_filesize(filesize($data_directory . '/' . $value)) . "</small></td>";
        echo "</tr>";

        $counter++;
    }
    ?>
</table>
</body>
</html>
