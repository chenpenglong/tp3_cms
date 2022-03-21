<?
//防止sql注入脚本
function sqlInj($value) {
    //过滤参数
    if (is_string($value)) {
        $arr = explode('|', 'UPDATEXML|UPDATE|WHERE|EXEC|INSERT|SELECT|DELETE|COUNT|CHR|MID|MASTER|TRUNCATE|DECLARE|BIND|DROP|CREATE| EXP |EXP%| OR |XOR| LIKE |NOTLIKE|NOT BETWEEN|NOTBETWEEN|BETWEEN|NOTIN|NOT IN|EXTRACTVALUE|LOAD_FILE|INFORMATION_SCHEMA|outfile|%20|into|union');
        foreach ($arr as $a) {
            //判断参数值中是否含有SQL关键字，如果有则跳出
            //if (stripos($value, $a) !== false) exit(json_encode(array('status' => -1, 'info' => '对不起，您提交的内容含有特殊字符：' . $a, 'data' => array($a)), 0));
            if (stripos($value, $a) !== false)
                die("<meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><script>alert('对不起，您提交的内容含有特殊字符：$a ，请联系网站管理员确认')</script>");
        }
    } elseif (is_array($value)) {
        //如果参数值是数组则递归遍历判断
        foreach ($value as $v) {
            sqlInj($v);
        }
    }
}

foreach ($_GET as $value) {
    sqlInj($value);
}

foreach ($_POST as $value) {
    sqlInj($value);
}
