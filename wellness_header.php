<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Wellness Report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url('css/hpv.css') ?>">
</head>

<body>
    <?php
    $json_data = $data;
    $patientDetails = $json_data['patientdetails'];
    $setaddressflag = $json_data['addressflag'];
    $companyname =  $json_data['companyname'];
    $companyaddress = $json_data['companyaddress'];
    ?>
    <div class="resultDetails" style="page-break-after: always;padding-top:50px;">
    <div style="width: 22%;margin-right: 12px;" class="header-sample">
        <table class="border-collapse">
            <tr>
                <td class="header-report">Sample Collected</td>
                <td style="padding-left: 4px;">27/02/2024 (10:00 AM)</td>
            </tr>
        </table>
    </div>
    <div style="width: 19%;margin-right: 12px;" class="header-sample">
        <table class="border-collapse">
            <tr>
                <td class="header-report">Reported</td>
                <td style=" padding-left: 4px;">28/02/2024 (10:00 AM)</td>
            </tr>
        </table>
    </div>
    <div style="width: 10%;" class="header-sample">
        <table class="border-collapse">
            <tr>
                <td class="header-report">Basic Info</td>
                <td style="     padding-left: 4px;">M/33</td>
            </tr>
        </table>
    </div>
    <div class="header-report-img">
        <table class="border-collapse">
            <tr>
                <td><img src="https://staging-cloud.lifecell.in/media/newsletter/medias/media/Group_4647.png" alt=""
                        class="w-30"></td>
            </tr>
        </table>
    </div>
</div>
</body>

</html>