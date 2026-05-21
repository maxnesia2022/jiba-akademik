<?
 ?>
<?
function GetCbActivity($aktif)
{
    $depList = getDepartemenStringList(SI_USER_ACCESS());
    
    $sql = "SELECT replid, kegiatan, departemen
              FROM frkegiatan k
             WHERE aktif = $aktif
               AND departemen IN ($depList)
             ORDER BY departemen, kegiatan";
    $res = QueryDb($sql);
    echo "<select id='cbKegiatan' style='width: 380px;' onchange='clearContent()'>";
    while($row = mysqli_fetch_row($res))
    {
        echo "<option value=$row[0]>($row[2]) $row[1]</option>";
    }
    echo "</select>";
}

function GetPegawai($idkegiatan, $bulan, $tahun, $bagian)
{
    $sql = "SELECT p.nip, p.nama
              FROM pegawai p
             WHERE p.bagian = '$bagian'
               AND p.aktif = 1
             ORDER BY p.nama";
    $res = QueryDb($sql);
    
    $table  = "<table border='1' id='table' class='tab' style='border-width: 1px'  cellpadding='2' cellspacing='2' width='99%'>\r\n";
    $table .= "<tr height='25'>\r\n";
    $table .= "<td width='10%' align='center' class='header'>No</td>\r\n";
    $table .= "<td width='*' align='left' class='header'>Nama</td>\r\n";
    $table .= "<td width='12%' class='header'>&nbsp;</td>\r\n";
    $table .= "</tr>\r\n";
    $cnt = 0;
    while($row = mysqli_fetch_row($res))
    {
        $cnt += 1;
        $table .= "<tr>\r\n";
        $table .= "<td align='center'>$cnt</td>\r\n";
        $table .= "<td align='left'><font style='font-size: 8px; color: green;'>$row[0]</font><br>$row[1]</td>\r\n";
        $table .= "<td align='center'><input type='button' class='but' value=' > ' onclick=\"showReport($idkegiatan, $bulan, $tahun, '$row[0]')\"></td>\r\n";
        $table .= "</tr>\r\n";
    }
    $table .= "</table>\r\n";
    
    return $table;
}

function SearchPegawai($idkegiatan, $bulan, $tahun, $filter, $keyword)
{
    $sql = "SELECT p.nip, p.nama
              FROM pegawai p
             WHERE p.$filter LIKE '%$keyword%'
               AND p.aktif = 1
             ORDER BY p.nama";
    $res = QueryDb($sql);
    
    $table  = "<table border='1' id='table' class='tab' style='border-width: 1px'  cellpadding='2' cellspacing='2' width='99%'>\r\n";
    $table .= "<tr height='25'>\r\n";
    $table .= "<td width='10%' align='center' class='header'>No</td>\r\n";
    $table .= "<td width='*' align='left' class='header'>Nama</td>\r\n";
    $table .= "<td width='12%' class='header'>&nbsp;</td>\r\n";
    $table .= "</tr>\r\n";
    $cnt = 0;
    while($row = mysqli_fetch_row($res))
    {
        $cnt += 1;
        $table .= "<tr>\r\n";
        $table .= "<td align='center'>$cnt</td>\r\n";
        $table .= "<td align='left'><font style='font-size: 8px; color: green;'>$row[0]</font><br>$row[1]</td>\r\n";
        $table .= "<td align='center'><input type='button' class='but' value=' > ' onclick=\"showReport($idkegiatan, $bulan, $tahun, '$row[0]')\"></td>\r\n";
        $table .= "</tr>\r\n";
    }
    $table .= "</table>\r\n";
    
    return $table;
}
?>