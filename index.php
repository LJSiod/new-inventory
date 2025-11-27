<?php
date_default_timezone_set('Asia/Manila');
include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/v/bs4/dt-2.2.2/sc-2.4.3/datatables.min.css" rel="stylesheet"
        integrity="sha384-CMEq2N2G7R4+EycxmPw6yNcPvSdUSaqF6a9t2CJSDxm1J0dVlOpZksuJwROd5KYo" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="assets/css/styles.css" rel="stylesheet">
    <link href="assets/css/loader.css" rel="stylesheet">
    <style>
        .br-pagebody {
            margin-top: 10px;
            margin-left: auto;
            margin-right: auto;
            max-width: 1400px;
        }

        .br-section-wrapper {
            padding: 20px;
            height: auto;
            box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.21);
            opacity: 95%;
        }

        .loader-div {
            position: absolute;
            top: 50%;
            left: 46%;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        #tablecontainer {
            height: 81vh;
            max-height: 81vh;
            overflow-y: auto;
            overflow-x: hidden;
            border: 1px solid gray;
            padding: 5px;
        }
    </style>
</head>

<body>

    <div id="overlay" class="d-none">
        <div class="loader-div d-flex">
            <img src="assets/image/Neologo.png" alt=""
                style="animation: spin 1s linear infinite; width: 60px; height: 60px;">
            <div class="loader ms-1 mt-3"></div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="br-pagebody">
            <div class="br-section-wrapper bg-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="fw-bold text-uppercase"><span id="typelabel">DEPLOYED
                        </span> EQUIPMENTS <button class="btn btn-sm btn-outline-secondary refresh"><i class=" fa
                            fa-refresh" aria-hidden="true"></i></button></div>
                    <div class="d-flex align-items-center">
                        <span class="fw-bold me-2">View: </span>
                        <select name="view" id="view" class="form-select form-select-sm me-2">
                            <option class="text-primary" value="Deployed">Deployed</option>
                            <option class="text-secondary" value="All">All</option>
                            <option class="text-success" value="In Stock">In Stock</option>
                            <option class="text-danger" value="Damaged">Damaged</option>
                        </select>
                        <span class="fw-bold me-2">Branch: </span>
                        <select name="branchfilter" id="branchfilter" class="form-select form-select-sm">
                        </select>
                    </div>
                </div>
                <hr>
                <div id="tablecontainer">
                </div>
            </div>
        </div>
    </div>

    <!-- Add Unit Modal -->
    <div class="modal fade" id="unitmodal" tabindex="-1" aria-labelledby="unitmodallabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Unit Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="unitform">
                        <input type="hidden" id="unitid" name="unitid">
                        <input type="hidden" id="type" name="type">
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="unitname" class="form-label small">Unit Name</label>
                                <input type="text" class="form-control form-control-sm" id="unitname" name="unitname"
                                    required>
                            </div>
                            <div class="mb-3 col">
                                <label for="branch" class="form-label small">Branch</label>
                                <select class="form-select form-select-sm branchselect" name="branch"
                                    id="branch"></select required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="department" class="form-label small">Department</label>
                                <input type="text" name="department" id="department"
                                    class="form-control form-control-sm" readonly>
                                <!-- <select class="form-select form-select-sm departmentselect" name="department"
                                    id="department">
                                    <option></option>
                                    <option>Administration</option>
                                    <option>Credit and Collection</option>
                                    <option>Accounting</option>
                                    <option>IT Department</option>
                                    <option>Executive</option>
                                </select> -->
                            </div>
                            <div class="mb-3 col">
                                <label for="position" class="form-label small">Position</label>
                                <input type="text" name="position" id="position" class="form-control form-control-sm"
                                    readonly>
                                <!-- <select class="form-select form-select-sm positionselect" name="position" id="position">
                                    <option></option>
                                </select> -->
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="assignedto" class="form-label small">Assigned to</label>
                            <select class="form-select form-select-sm" id="assignedto" name="assignedto">
                            </select>
                            <!-- <input type="text" class="form-control form-control-sm" id="assignedto" name="assignedto"> -->
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" value="Save Changes" class="btn btn-sm btn-primary">Save Changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Equipment Modal -->
    <div class="modal fade" id="equipmentmodal" tabindex="-1" aria-labelledby="equipmentmodallabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Equipment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="equipmentform">
                        <input type="hidden" id="type1" name="type">
                        <input type="hidden" id="unitid1" name="unitid">
                        <input type="hidden" id="branchid1" name="branchid">
                        <input type="hidden" id="equipmentid1" name="equipmentid">
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="itemtype" class="form-label small">Item Type</label>
                                <select class="form-select form-select-sm" name="itemtype" id="itemtype">
                                    <option>CPU</option>
                                    <option>GRAPHICS CARD</option>
                                    <option>HDD</option>
                                    <option>HEADSET</option>
                                    <option>KEYBOARD</option>
                                    <option>LAMINATOR</option>
                                    <option>MONEY DETECTOR</option>
                                    <option>MOTHERBOARD</option>
                                    <option>MOUSE</option>
                                    <option>MONITOR</option>
                                    <option>POWER SUPPLY</option>
                                    <option>PRINTER</option>
                                    <option>RAM</option>
                                    <option>SCANNER</option>
                                    <option>SSD</option>
                                    <option>UPS</option>
                                    <option>AVR</option>
                                    <option>WEB CAMERA</option>
                                </select>
                            </div>
                            <div class="mb-3 col">
                                <label for="make" class="form-label small">Make</label>
                                <input type="text" class="form-control form-control-sm" id="make" name="make" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="model" class="form-label small">Model</label>
                                <input type="text" class="form-control form-control-sm" id="model" name="model"
                                    required>
                            </div>
                            <div class="mb-3 col">
                                <label for="serialnumber" class="form-label small">Serial Number</label>
                                <input type="text" class="form-control form-control-sm" id="serialnumber"
                                    name="serialnumber">
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col">
                                <label for="datepurchased" class="form-label small">Date Purchased</label>
                                <input type="date" class="form-select form-select-sm" name="datepurchased"
                                    id="datepurchased">
                            </div>
                            <div class="mb-3 col">
                                <label for="dateacquired" class="form-label small">Date Acquired</label>
                                <input type="date" class="form-select form-select-sm" name="dateacquired"
                                    id="dateacquired">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" value="Save Changes" class="btn btn-sm btn-primary">Save Changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Deploy Equipment Modal -->
    <div class="modal fade" id="deploymodal" tabindex="-1" aria-labelledby="deploymodallabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Deploy Equipment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Item Details</h6>
                    <hr>
                    <table class="table table-sm small">
                        <tbody>
                            <tr>
                                <td class="fw-bold">Type</td>
                                <td id="itemtype1"></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Make</td>
                                <td id="make1"></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Model</td>
                                <td id="model1"></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Serial Number</td>
                                <td id="serialnumber1"></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Date Purchased</td>
                                <td id="datepurchased1"></td>
                            </tr>
                        </tbody>
                    </table>
                    <h6>Deploy to</h6>
                    <hr>
                    <form action="" method="POST" id="deployform">
                        <input type="hidden" id="equipmentid2" name="equipmentid">
                        <input type="hidden" id="type2" name="type">
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="branch" class="form-label small">Branch</label>
                                <select class="form-select form-select-sm branchselect" name="branchid"
                                    id="deploybranch"></select required>
                            </div>
                            <div class="mb-3 col">
                                <label for="unit" class="form-label small">Unit</label>
                                <select class="form-select form-select-sm unitselect" name="unitid" id="unitid"></select
                                    required>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" value="Save Changes" class="btn btn-sm btn-primary">Save Changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/bs4/dt-2.2.2/sc-2.4.3/datatables.min.js"
        integrity="sha384-Axj01h5eDJyWVXqLtDiRNOjhaWBelga9RSnAFsuOD9x+40MK77FVvLxTihwPnt6B"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script>
        $(document).ready(function () {
            let branch = 'All';
            let view = 'Deployed';
            let cachedData = null;
            let currentBranch = null;
            load(branch, view)

            function load(branch, view) {
                $('#tablecontainer').empty();

                if (branch !== currentBranch) {
                    cachedData = null;
                    currentBranch = branch;
                }

                if (cachedData !== null) {
                    renderTable(view, cachedData);
                    return;
                }

                $.ajax({
                    url: 'load/load.php',
                    type: 'POST',
                    data: { branch: branch },
                    success: function (result) {
                        cachedData = JSON.parse(result);
                        renderTable(view, cachedData);
                    }
                });
            }

            function refreshData() {
                $('#overlay').removeClass('d-none').fadeIn();
                cachedData = null;
                load(currentBranch, view);
                $('#overlay').fadeOut();
            }

            function getPosition(department) {
                $.ajax({
                    url: 'load/getposition.php',
                    type: 'POST',
                    data: { department: department },
                    success: function (result) {
                        $('.positionselect').empty();
                        $.each(result.position, function (j, pos) {
                            $('.positionselect').append('<option>' + pos + '</option>');
                        });
                    }
                })
            }

            function getUnit(branch) {
                $.ajax({
                    url: 'load/getunit.php',
                    type: 'POST',
                    data: { branch: branch },
                    success: function (result) {
                        $('.unitselect').empty();
                        $.each(result.unit, function (j, unit) {
                            $('.unitselect').append('<option value="' + unit.id + '">' + unit.unitname + '</option>');
                        });
                    }
                })
            }

            function renderTable(view, data) {

                if (view === 'Deployed') {
                    loadDeployed(data);
                } else {
                    var html = '';
                    html += `
                    <table id="table" class="table table-sm table-hover table-striped">
                        <thead class="table-secondary sticky-top">
                            <tr>
                                <th style="width: 5%" scope="col">No.</th>
                                <th scope="col">Branch</th>
                                <th scope="col">Item type</th>
                                <th scope="col">Make</th>
                                <th scope="col">Model</th>
                                <th scope="col">Serial Number</th>
                                <th scope="col">Date Purchased</th>
                                <th scope="col">Date Acquired</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                    `;
                    $.each(data, function (j, item) {
                        if (view === 'All') {
                            $.each(item.equipments, function (k, equipment) {
                                html += `
                                <tr class="small">
                                    <td>${equipment.equipmentid}</td>
                                    <td class="fw-bold">${equipment.branch}</td>
                                    <td>${equipment.type}</td>
                                    <td>${equipment.make}</td>
                                    <td>${equipment.model}</td>
                                    <td>${equipment.serialnumber}</td>
                                    <td>${equipment.datepurchased}</td>
                                    <td>${equipment.dateacquired}</td>
                                    <td>
                                        <span class="badge rounded-pill ${equipment.status === 'Damaged' ? 'bg-danger' : (equipment.status === 'In Stock' ? 'bg-success' : 'bg-primary')}">${equipment.status}</span>
                                    </td>
                                </tr>
                                `;
                            });
                        } else if (view === 'In Stock') {
                            $.each(item.instock, function (k, equipment) {
                                html += `
                                <tr class="small">
                                    <td>${equipment.equipmentid}</td>
                                    <td class="fw-bold"></td>
                                    <td>${equipment.type}</td>
                                    <td>${equipment.make}</td>
                                    <td>${equipment.model}</td>
                                    <td>${equipment.serialnumber}</td>
                                    <td>${equipment.datepurchased}</td>
                                    <td>${equipment.dateacquired}</td>
                                    <td>
                                        <span class="badge rounded-pill ${equipment.status === 'Damaged' ? 'bg-danger' : (equipment.status === 'In Stock' ? 'bg-success' : 'bg-primary')}">${equipment.status}</span>
                                    </td>
                                </tr>
                                `;
                            });
                        } else {
                            $.each(item.equipments, function (k, equipment) {
                                if (equipment.status == view) {
                                    html += `
                                <tr class="small">
                                    <td>${equipment.equipmentid}</td>
                                    <td class="fw-bold">${equipment.branch}</td>
                                    <td>${equipment.type}</td>
                                    <td>${equipment.make}</td>
                                    <td>${equipment.model}</td>
                                    <td>${equipment.serialnumber}</td>
                                    <td>${equipment.datepurchased}</td>
                                    <td>${equipment.dateacquired}</td>
                                    <td>
                                        <span class="badge rounded-pill ${equipment.status === 'Damaged' ? 'bg-danger' : (equipment.status === 'In Stock' ? 'bg-success' : 'bg-primary')}">${equipment.status}</span>
                                    </td>
                                </tr>
                                `;
                                }
                            });
                        }
                    });
                    html += '</tbody>';
                    html += '</table>';
                    html += '</div>';
                    $('#tablecontainer').html(html);
                    var table = $('#table').DataTable({
                        layout: {
                            topStart: false,
                            bottomEnd: false
                        },
                        order: [0, 'desc'],
                        deferRender: true,
                        scrollY: '68vh', //67vh
                        scroller: true,
                        drawCallback: function () {
                            $('.dts_label').hide();
                            $('.dt-scroll-body').css('background-image', 'none');
                            $('.dt-layout-start').css({
                                'font-size': '13px',
                                'font-weight': 'bold',
                                'font-family': 'Raleway, sans-serif'
                            });
                        },
                    });
                }
            }

            function loadDeployed(data) {
                var html = '';
                $.each(data, function (i, item) {
                    if (item.name !== undefined) {
                        html += `
                            <div>
                                <div class="d-flex"> 
                                    <h4 class="fw-bold">${item.unitname}</h4>
                                    <button class="btn btn-sm btn-outline-secondary mb-2 ms-2" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><button class="dropdown-item small showunitmodal" 
                                        data-type="update" 
                                        data-unitid="${item.unitid}" 
                                        data-unitname="${item.unitname}" 
                                        data-branch="${item.branchid}" 
                                        data-assignedto="${item.name}"
                                        data-department="${item.department}"
                                        data-position="${item.position}">
                                            <i class="fa fa-pencil"></i> Update
                                        </button></li>
                                        <li><button class="dropdown-item small showequipmentmodal" 
                                        data-type="deploy"
                                        data-unitid="${item.unitid}"
                                        data-branchid="${item.branchid}">
                                            <i class="fa fa-plus"></i> Add Equipment
                                        </button></li>
                                    </ul>
                                </div>
                                <div class="d-flex small">
                                    <span class="me-2 text-uppercase"><b>Branch: </b>${item.branch}</span>
                                    <span class="me-2 text-uppercase"><b>Assigned to: </b>${item.name}</span>
                                    <span class="me-2 text-uppercase"><b>Department: </b>${item.department}</span>
                                    <span class="me-2 text-uppercase"><b>Position: </b>${item.position}</span>
                                </div>
                            `;
                        html += `
                            <table class="table table-sm table-striped table-hover">
                                <thead class="table-secondary">
                                    <tr>
                                        <th style="width: 5%" scope="col">No.</th>
                                        <th class="d-none" scope="col"></th>
                                        <th scope="col">Item type</th>
                                        <th scope="col">Make</th>
                                        <th scope="col">Model</th>
                                        <th scope="col">Serial Number</th>
                                        <th scope="col">Date Purchased</th>
                                        <th scope="col">Date Acquired</th>
                                        <th class="d-none" scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                            `;
                        $.each(item.equipments, function (j, equipment) {
                            html += `
                                <tr class="small">
                                    <td>${equipment.equipmentid}</td>
                                    <td class="d-none">${equipment.branch}</td>
                                    <td>${equipment.type}</td>
                                    <td>${equipment.make}</td>
                                    <td>${equipment.model}</td>
                                    <td>${equipment.serialnumber}</td>
                                    <td>${equipment.datepurchased}</td>
                                    <td>${equipment.dateacquired}</td>
                                    <td class="d-none">${equipment.status}</td>
                                </tr>
                                `;
                        });
                        html += '</tbody>';
                        html += '</table>';
                        html += '</div>';
                    }
                });
                $('#tablecontainer').html(html);
            }

            $('#branchfilter, #view').on('change', function () {
                branch = $('#branchfilter').val();
                view = $('#view').val();
                $('#typelabel').text(view);
                load(branch, view);
            });

            $('.departmentselect').on('change', function () {
                var department = $(this).val();
                getPosition(department);
            });

            $('.branchselect').on('change', function () {
                var branch = $(this).val();
                getEmployee(branch);
            });

            $('#deploybranch').on('change', function () {
                var branch = $(this).val();
                getUnit(branch);
            });

            $('.refresh').on('click', function () {
                refreshData();
            });

            $.ajax({
                url: 'load/getbranch.php',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    var branchfilter = $('#branchfilter');
                    var branchselect = $('.branchselect');
                    branchselect.empty();
                    branchfilter.append('<option value="All">All Branch</option>');
                    data.branch.forEach(function (branch) {
                        branchfilter.append('<option value="' + branch.id + '">' + branch.name + '</option>');
                        branchselect.append('<option value="' + branch.id + '">' + branch.name + '</option>');
                    });
                }
            });

            function getEmployee(branch, selectedName) {
                $.ajax({
                    url: 'load/getemployee.php',
                    type: 'POST',
                    data: {
                        branch: branch
                    },
                    success: function (data) {
                        var employeeselect = $('#assignedto');
                        var department = $('#department');
                        var position = $('#position');
                        employeeselect.off('change');
                        employeeselect.empty();
                        employeeselect.append('<option></option>');
                        data.employee.forEach(function (employee) {
                            employeeselect.append('<option value="' + employee.fullname + '" data-department="' + employee.department + '" data-position="' + employee.position + '">' + employee.fullname + '</option>');
                        });
                        if (selectedName) {
                            employeeselect.val(selectedName);
                            var selDept = employeeselect.find(':selected').data('department') || '';
                            var selPos = employeeselect.find(':selected').data('position') || '';
                            department.val(selDept);
                            position.val(selPos);
                        }
                        employeeselect.on('change', function () {
                            var selectedDepartment = $(this).find(':selected').data('department');
                            var selectedPosition = $(this).find(':selected').data('position');
                            department.val(selectedDepartment);
                            position.val(selectedPosition);
                        });
                    }
                });
            }

            $(document).on('click', '.showequipmentmodal', function () {
                var equipmentid = $(this).data('equipmentid');
                var itemtype = $(this).data('itemtype');
                var type = $(this).data('type');
                var unitid = $(this).data('unitid');
                var branchid = $(this).data('branchid');
                var make = $(this).data('make');
                var model = $(this).data('model');
                var serialnumber = $(this).data('serialnumber');
                var datepurchased = $(this).data('datepurchased');
                var dateacquired = $(this).data('dateacquired');
                $('#equipmentid1').val(equipmentid);
                $('#itemtype').val(itemtype).prop('disabled', type === 'edit');
                $('#make').val(make).prop('disabled', type === 'edit');
                $('#model').val(model);
                $('#serialnumber').val(serialnumber);
                $('#datepurchased').val(datepurchased);
                $('#dateacquired').val(dateacquired);
                $('#type1').val(type);
                $('#unitid1').val(unitid);
                $('#branchid1').val(branchid);
                $('#equipmentmodal').modal('show');
                $('#equipmentform').off('submit').on('submit', function (e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    var formDataObj = Object.fromEntries(formData.entries());
                    console.log(formDataObj);
                    $.ajax({
                        url: 'actions/equipment.php',
                        type: 'POST',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            var data = JSON.parse(response);
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: data.status,
                                    showConfirmButton: false,
                                    timer: 1500,
                                    timerProgressBar: true
                                }).then(function () {
                                    $('#equipmentform')[0].reset();
                                    refreshData();
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.status,
                                    showConfirmButton: false,
                                    timer: 2500,
                                    timerProgressBar: true
                                });
                            }
                        }
                    });
                });
            });

            $(document).on('click', '.showunitmodal', function () {
                var assignedto = $(this).data('assignedto');
                var branch = $(this).data('branch');
                var type = $(this).data('type');
                var unitid = $(this).data('unitid');
                var unitname = $(this).data('unitname');
                var department = $(this).data('department');
                var position = $(this).data('position');
                $('#branch').val(branch);
                getEmployee(branch, assignedto);
                $('#type').val(type);
                $('#unitid').val(unitid);
                $('#unitname').val(unitname);
                $('#department').val(department);
                $('#position').val(position) ?? '';
                $('#unitmodal').modal('show');
                $('#unitform').off('submit').on('submit', function (e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    var formDataObj = Object.fromEntries(formData.entries());
                    $.ajax({
                        url: 'actions/unit.php',
                        type: 'POST',
                        data: formDataObj,
                        success: function (response) {
                            var data = JSON.parse(response);
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: data.status,
                                    showConfirmButton: false,
                                    timer: 1500,
                                    timerProgressBar: true
                                }).then(function () {
                                    // $('#unitform')[0].reset();
                                    $('#unitform')[0].reset();
                                    $('#unitmodal').modal('hide');
                                    // refreshData();
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.status,
                                    showConfirmButton: false,
                                    timer: 2500,
                                    timerProgressBar: true
                                });
                            }
                        }
                    });
                });
            });

            $(document).on('click', '.showdeploymodal', function () {
                var equipmentid = $(this).data('equipmentid');
                var type = $(this).data('type');
                var itemtype = $(this).data('itemtype');
                var make = $(this).data('make');
                var model = $(this).data('model');
                var serialnumber = $(this).data('serialnumber');
                var datepurchased = $(this).data('datepurchased');
                $('#equipmentid2').val(equipmentid);
                $('#type2').val(type);
                $('#itemtype1').text(itemtype);
                $('#make1').text(make);
                $('#model1').text(model);
                $('#serialnumber1').text(serialnumber);
                $('#datepurchased1').text(datepurchased);
                getUnit(1);
                $('#deploymodal').modal('show');
                $('#deployform').off('submit').on('submit', function (e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    var formDataObj = Object.fromEntries(formData.entries());
                    $.ajax({
                        url: 'actions/equipment.php',
                        type: 'POST',
                        data: formDataObj,
                        success: function (response) {
                            var data = JSON.parse(response);
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: data.status,
                                    showConfirmButton: false,
                                    timer: 1500,
                                    timerProgressBar: true
                                }).then(function () {
                                    $('#deployform')[0].reset();
                                    $('#deploymodal').modal('hide');
                                    refreshData();
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.status,
                                    showConfirmButton: false,
                                    timer: 2500,
                                    timerProgressBar: true
                                });
                            }
                        }
                    });
                });
            });

            $(document).on('contextmenu', function (e) {
                e.preventDefault();
            });

            $(document).on('click', function (e) {
                $('.removedrop').remove();
            })

            $(document).on('contextmenu', '.table tbody tr', function (e) {
                e.preventDefault();
                $('.removedrop').remove();
                var tablerow = $(this).closest('tr');
                var rowdata = tablerow.children('td').map(function () {
                    return $(this).text();
                }).get();
                var equipmentid = rowdata[0];
                var itemtype = rowdata[2];
                var make = rowdata[3];
                var model = rowdata[4];
                var serialnumber = rowdata[5];
                var datepurchased = rowdata[6];
                var dateacquired = rowdata[7];
                var status = rowdata[8].replace(/^\s+|\s+$/g, '').replace(/[^\w\s]/gi, '');
                var menu = $('<div class="dropdown-menu removedrop" id="actiondropdown" style="display:block; position:absolute; z-index:1000;">'
                    + (status != 'Damaged' ? '<a href="#" id="damaged" class="dropdown-item small"><i class="fa fa-chain-broken"></i> Mark as Damaged</a>' : '')
                    + (status != 'In Stock' ? '<a href="#" id="return" class="dropdown-item small"><i class="fa fa-share"></i> Return to Stock</a>' : '')
                    + (status === 'In Stock' ? '<a href="#" class="dropdown-item small showequipmentmodal" data-type="edit" data-equipmentid="' + equipmentid + '" data-itemtype="' + itemtype + '" data-make="' + make + '" data-model="' + model + '" data-serialnumber="' + serialnumber + '" data-datepurchased="' + datepurchased + '" data-dateacquired="' + dateacquired + '"><i class="fa fa-edit"></i> Edit Row</a>' : '')
                    + (status === 'In Stock' ? '<a href="#" class="dropdown-item small showdeploymodal" data-type="assign" data-equipmentid="' + equipmentid + '" data-itemtype="' + itemtype + '" data-make="' + make + '" data-model="' + model + '" data-serialnumber="' + serialnumber + '" data-datepurchased="' + datepurchased + '" data-dateacquired="' + dateacquired + '"><i class="fa fa-refresh"></i> Deploy Equipment</a>' : '')
                    + (status === 'In Stock' ? '<a href="#" id="delete" class="dropdown-item text-danger small" ><i class="fa fa-trash"></i> Delete Equipment</a>' : '')
                    + '</div>').appendTo('body');
                menu.css({ top: e.pageY + 'px', left: e.pageX + 'px' });

                $('#damaged, #return, #delete').on('click', function () {
                    var action = $(this).attr('id');
                    if (action === 'delete') {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: 'actions/setstatus.php',
                                    type: 'POST',
                                    data:
                                    {
                                        action: action,
                                        equipmentid: equipmentid,
                                    },
                                    success: function (response) {
                                        var data = JSON.parse(response);
                                        if (data.success) {
                                            menu.remove();
                                            refreshData();
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Error',
                                                text: data.status,
                                                showConfirmButton: false,
                                                timer: 2500,
                                                timerProgressBar: true
                                            });
                                        }
                                    }
                                });
                            }
                        });
                    } else {
                        $.ajax({
                            url: 'actions/setstatus.php',
                            type: 'POST',
                            data:
                            {
                                action: action,
                                equipmentid: equipmentid,
                            },
                            success: function (response) {
                                var data = JSON.parse(response);
                                if (data.success) {
                                    menu.remove();
                                    refreshData();
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: data.status,
                                        showConfirmButton: false,
                                        timer: 2500,
                                        timerProgressBar: true
                                    });
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>