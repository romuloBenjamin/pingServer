<h2 class="text-center">Site HASEGAWA</h2>
<!-- TABLES 192 -->
<table class="table">
<thead>
    <tr>
        <th scope="col">IP</th>
        <th scope="col">SERVIDOR</th>
        <th scope="col">STATUS</th>
    </tr>
</thead>
<tbody>
<?php if(!class_exists("pingServer_modules")){ call_SubFolder('public', 'class', 'pingServerMods-class');  }
$server192 = new pingServer_modules(); echo $server192->arrayListServers("hasegawa"); ?>
</table>
<!-- TABLES 192 -->
<script src="<?=DIR_PATH;?>cnt-js/PS-config2-js.js"></script>