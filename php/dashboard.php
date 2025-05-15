<?php
include("header.php");
include("sidebar.php");

$role = $_SESSION['role'];
?>
<html>
<head><link rel="stylesheet" href="../css/dashboard.css"></head>

<body>
<div class="content">
    <h2>
        <?= $role === 'admin' ? 'PANELI I ADMINISTRATORIT' : 'PANELI I KLIENTIT'; ?>
    </h2>
    <p>
        <?= $role === 'admin'
            ? 'Mirësevini në panelin e administrimit. Nga këtu mund të menaxhoni të gjitha aspektet e sistemit, duke përfshirë përdoruesit, oraret e trajnerëve dhe abonimet.'
            : 'Mirësevini në panelin tuaj personal. Këtu mund të shikoni oraret e stërvitjeve, të menaxhoni rezervimet tuaja dhe të ndiqni progresin tuaj.' ?>
    </p>
</div>

<?php include("footer.php"); ?>
</body>
</html>