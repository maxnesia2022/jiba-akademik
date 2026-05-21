<?
 ?>
<br><br>
<table border='0' cellspacing='5' width='100%' style='background-color: #eee;'>
<tr>
    <td width='120' align='right'>&nbsp;</td>
    <td width='300' align='left'>
        <font style='font-size: 14px; color: #666'>UPLOAD GAMBAR</font>
    </td>
</tr>
<tr>
    <td align='right'>Gambar:</td>
    <td align='left'>
        <input type='file' id='gambar' name='gambar' style='width: 320px'>
    </td>
</tr>
<tr>
    <td align='right'>Deskripsi:</td>
    <td align='left'>
        <textarea rows='3' cols='40' id='deskripsi'></textarea>
    </td>
</tr>
<tr>
    <td width='120' align='right'>&nbsp;</td>
    <td width='300' align='left'>
        <input type='button' value='Upload' id='btUpload' class='but' onclick='uploadPict()'>
        <span id='lbInfo'></span>    
    </td>
</tr>    
</table>