<?= $this->include('load/select2') ?>
<?= $this->include('load/datatables') ?>
<!-- Extend from layout index -->
<?= $this->extend('layout/index') ?>

<!-- Section content -->
<?= $this->section('content') ?>
<!-- SELECT2 EXAMPLE -->
<div class="card card-default">
    <div class="card-body">
        <div id="cover-spin"></div>
        <button class="btn-sm btn-primary" style="float: right;margin-bottom:1%;" onclick="showFilters()"><i class="fas fa-filter"></i></button>
        <div class="row">
            <div class="card-header" id="filter-div" style="margin-bottom: 2%;display:none">
                <form action="#" method="post" enctype="multipart/form-data" id="form-filter">
                    <div class="form-row align-items-center" style="font-size: 10px;">
                    <label for="colFormLabelSm" class="col-sm-1 col-form-label col-form-label-sm">From Date</label>
                        <div class="col-sm-3">
                            <input type="date" name="min" id="min" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d') . " -1 month")); ?>" class="form-control form-control-sm" />
                        </div>
                        <label for="colFormLabelSm" class="col-sm-1 col-form-label col-form-label-sm">To Date</label>
                        <div class="col-sm-3">
                            <input type="date" name="max" id="max" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-sm" />
                        </div>
                        <label for="colFormLabelSm" class="col-sm-1 col-form-label col-form-label-sm">LAB ID</label>
                        <div class="col-sm-3">
                            <input type="text" name="lab_id" class="form-control form-control-sm" id="lab_id">
                        </div>
                        <label for="colFormLabelSm" class="col-sm-1 col-form-label col-form-label-sm">Test GroupCode</label>
                        <div class="col-sm-3 py-3">
                            <input type="text" name="testgroupcode" class="form-control form-control-sm" id="testgroupcode">
                        </div>
                        <label for="colFormLabelSm" class="col-sm-1 col-form-label col-form-label-sm">Status</label>
                        <div class="col-sm-3">
                            <select id="status" class="form-control form-control-sm" name="status">
                                <option value="">All</option>
                                <option value="done">Done</option>
                                <option value="failed">Failed</option>
                            </select>
                        </div>
                        <div class="col-sm-2 py-2" style="float:right">
                            <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="table-reg_service_data" class="table table-striped table-hover va-middle">
                        <thead>
                            <tr>
                                <th><?= lang('Lab Id') ?></th>
                                <th><?= lang('Test GroupCode') ?></th>
                                <th><?= lang('Status') ?></th>
                                <th><?= lang('View Payload') ?></th>
                                <th><?= lang('View Response') ?></th>
                                <th><?= lang('Created Date') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.card -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    var tableUser = $('#table-reg_service_data').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        order: [
            [4, 'desc']
        ],

        ajax: {
            url: '<?= route_to('admin/user/wellness-lims-logs') ?>',
            method: 'GET',
            data: function(data) {
                // Read values
                var min = $('#min').val();
                var max = $('#max').val();
                var status = $('#status').val();
                // Append to data
                data.fromdate = min;
                data.todate = max;
                data.status = status;
            }
        },
        columnDefs: [{
            orderable: false,
            targets: []
        }],
        columns: [{
                'data': 'lab_id'
            },

            {
                'data': 'testgroupcode'

            },
            {
                "data": function(data) {
                    if (data.status == "done") {

                        return `<td class="text-right py-0 align-middle">
                            <div class="btn-group btn-group-sm">
                                <p style="color:#33df27">Done</p>
                            </div>
                            </td>`
                    }
                    if (data.status == "failed") {
                        return `<td class="text-right py-0 align-middle">
                            <div class="btn-group btn-group-sm">
                                <p style="color:red">Failed</p>
                            </div>
                            </td>`
                    }
                    return "-"
                }
            },
            {
                "data": function(data) {
                    return `<td class="text-right py-0 align-middle">
                            <div class="btn-group btn-group-sm">
                                <a href="<?= route_to('admin/user/wellness-lims-logs') ?>/${data.reg_id}/viewpayload" target="_blank" class="btn btn-primary btn-edit"><i class="far fa-eye"></i></a>
                               
                            </div>
                            </td>`
                }
            },
            {
                "data": function(data) {
                    return `<td class="text-right py-0 align-middle">
                            <div class="btn-group btn-group-sm">
                                <a href="<?= route_to('admin/user/wellness-lims-logs') ?>/${data.reg_id}/edit" target="_blank" class="btn btn-primary btn-edit"><i class="far fa-eye"></i></a>
                               
                            </div>
                            </td>`
                }
            },
            {
                'data': 'created_at'
            },

        ]
    });


    $(function() {
        $("#min").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            yearRange: new Date().getFullYear().toString() + ':' + new Date().getFullYear().toString(),
            onClose: function(selectedDate) {
                $("#max").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#min").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            yearRange: new Date().getFullYear().toString() + ':' + new Date().getFullYear().toString(),
            onClose: function(selectedDate) {
                $("#min").datepicker("option", "maxDate", selectedDate);
            }
        });
    });


    $(document).ready(function() {
        $("#min").datepicker({
            dateFormat: 'yy-mm-dd'
        });
        $("#max").datepicker({
            dateFormat: 'yy-mm-dd'
        });

        $('#min, #max,#status').change(function() {
            $("#cover-spin").show();
            tableUser.draw();
            setTimeout(removeLoader, 500);
        });

        function removeLoader() {
            $("#cover-spin").fadeOut(500, function() {
                $("#cover-spin").hide();
            });
        }
    });
    
    table - reg_service_data.on('draw.dt', function() {
        var PageInfo = $('#table-reg_service_data').DataTable().page.info();
        table - reg_service_data.column(0, {
            page: 'current'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });

    $(document).on('click', '.btn-delete', function(e) {
        Swal.fire({
                title: '<?= lang('boilerplate.global.sweet.title') ?>',
                text: "<?= lang('boilerplate.global.sweet.text') ?>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<?= lang('boilerplate.global.sweet.confirm_delete') ?>'
            })
            .then((result) => {
                if (result.value) {
                    $.ajax({
                        url: `<?= route_to('admin/user/wellness-lims-logs') ?>/${$(this).attr('data-id')}`,
                        method: 'DELETE',
                    }).done((data, textStatus, jqXHR) => {
                        Toast.fire({
                            icon: 'success',
                            title: jqXHR.statusText,
                        });
                        tableUser.ajax.reload();
                    }).fail((error) => {
                        Toast.fire({
                            icon: 'error',
                            title: error.responseJSON.messages.error,
                        });
                    })
                }
            })
    });

    table - reg_service_data.on('order.dt search.dt', () => {
        tableUser.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
</script>

<script>
    var table = $('#table-reg_service_data').DataTable();
    $('#lab_id,#testgroupcode').on('keyup', function() {
        table.search(this.value).draw();
    });
    $('#status').on('keyup', function() {
        table.search(this.value).draw();
    });


    $('#btn-reset').click(function() { //button reset event click
        $('#form-filter')[0].reset();
        tableUser.ajax.reload(); //just reload table
        tableUser.search(this.value).reset();
    });

    function showFilters() {
        var x = document.getElementById("filter-div");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>

<link href="<?php echo base_url('css/jquery-ui.css') ?>" rel="stylesheet">
<link href="<?php echo base_url('css/loader.css') ?>" rel="stylesheet">
<script src="<?php echo base_url('js/jquery-3.6.0.js') ?>"></script>
<script src="<?php echo base_url('js/jquery-ui.js') ?>"></script>
<?= $this->endSection() ?>