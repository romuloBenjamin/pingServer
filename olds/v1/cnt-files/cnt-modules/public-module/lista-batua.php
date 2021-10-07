<h2 class="text-center">Site Batuá</h2>
<!-- TABLES 172 -->
<table class="table">
<thead>
<tr>
    <th scope="col">IP</th>
    <th scope="col">SERVIDOR</th>
    <th scope="col">STATUS</th>
</tr>
</thead>
<tbody>
<?php call_SubFolder('public', 'class', 'pingServerMods-class'); 
$server172 = new pingServer_modules(); echo $server172->ping_compound("listar-servidores-batua"); ?>
</table>
<!-- TABLES 172 -->
<script src="<?=DIR_PATH;?>cnt-js/PS-config-js.js"></script>