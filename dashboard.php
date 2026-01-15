<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="">
  <title>iBentos - Event Concierge Dashboard (ROI Edition)</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- DataTables -->
  <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- html2canvas & jsPDF for export -->
  <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root{ --brand:#003399; }
    body{ font-family: Inter,system-ui,Segoe UI,Roboto,Arial; background: #0a1551; }
    .bg-grad{
      background: radial-gradient(1200px 700px at -10% -10%, #1a2b6a 0%, rgba(26,43,106,0) 60%),
                  radial-gradient(1000px 500px at 110% 0%, #2b6fff 0%, rgba(43,111,255,0) 60%),
                  linear-gradient(180deg, #0a1551 0%, #0c1b63 60%, #0d216f 100%);
      min-height: 100vh;
      color: #fff !important;
    }
    .card-glass{
      background: linear-gradient(180deg, rgba(255,255,255,.16), rgba(255,255,255,.06));
      border: 1px solid rgba(255,255,255,.18);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      box-shadow: 0 10px 30px rgba(0,0,0,.25), inset 0 1px 0 rgba(255,255,255,.15);
      transition: transform .2s ease, box-shadow .2s ease;
      border-radius: 1rem;
    }
    .card-glass:hover{ transform: translateY(-2px); box-shadow: 0 14px 36px rgba(0,0,0,.28), inset 0 1px 0 rgba(255,255,255,.18); }
    .chip{
      display:inline-block;
      background: rgba(255,255,255,.14);
      padding: 0.35rem 0.75rem;
      border-radius: 50rem;
    }
    .btn-custom{
      background: linear-gradient(180deg, #2f7bff, #1d3fbf);
      box-shadow: 0 8px 20px rgba(47,123,255,.35);
      color:#fff;
      font-weight:600;
    }
    .btn-custom:active{ transform: translateY(1px); }
    .kpi{ font-variant-numeric: tabular-nums; }

    .table.dataTable > :not(caption) > * > * {
      background-color: transparent;
      color: #fff;
      border-color: rgba(255, 255, 255, 0.12);
    }

    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
      background: rgba(255,255,255,0.08);
      color: #fff;
      border: 1px solid rgba(255,255,255,0.2);
    }
  </style>
</head>
<body class="bg-grad p-4">

    <!-- Header -->
    <header class="row mt-3 mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0">AI Calling Dashboard</h2>
            <p class="text-white-50 mb-0">Voice Assistant Performance Overview</p>
        </div>
    </header>

    <!-- KPI CARDS -->
    <section class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card-glass p-3 text-center">
                <div class="text-white-50 small">Total Calls</div>
                <div class="display-6 fw-bold kpi">128</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-glass p-3 text-center">
                <div class="text-white-50 small">Positive</div>
                <div class="display-6 fw-bold kpi">79</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-glass p-3 text-center">
                <div class="text-white-50 small">Agent Hangup</div>
                <div class="display-6 fw-bold kpi">11</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-glass p-3 text-center">
                <div class="text-white-50 small">User Hangup</div>
                <div class="display-6 fw-bold kpi">18</div>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <section class="row g-4">

        <!-- RIGHT: Lists -->
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-striped border data-table align-middle">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Time</th>
                            <th scope="col">Duration</th>
                            <th scope="col">Channel Type</th>
                            <th scope="col">End Reason</th>
                            <th scope="col">Session Status</th>
                            <th scope="col">User Sentiment</th>
                            <th scope="col">From</th>
                            <th scope="col">Summary</th>
                            <th scope="col">Recording</th>
                        </tr>
                    </thead>
                    <tbody id="sortableTableBody" data-module="users">
                        <tr>
                            <td>1</td>
                            <td>12 Jan 2024, 09:12 AM</td>
                            <td>03:41</td>
                            <td>inbound</td>
                            <td>completed</td>
                            <td><span class="badge bg-success">Ended</span></td>
                            <td><span class="badge bg-success">Positive</span></td>
                            <td>+1 415-555-0123</td>
                            <td style="max-width: 300px;">
                                Quick qualification, scheduled follow-up...
                                <br>
                                <a href="#" onclick="getSummary('sample-1'); return false;" class="bi bi-info-square-fill ai-instructions">View</a>
                            </td>
                            <td style="max-width: 300px;">
                                <audio controls>
                                    <source src="https://www2.cs.uic.edu/~i101/SoundFiles/StarWars60.wav" type="audio/wav">
                                    Your browser does not support the audio element.
                                </audio>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>12 Jan 2024, 10:05 AM</td>
                            <td>02:18</td>
                            <td>outbound</td>
                            <td>user_hangup</td>
                            <td><span class="badge bg-success">Ended</span></td>
                            <td><span class="badge bg-secondary">Neutral</span></td>
                            <td>+1 212-555-0198</td>
                            <td style="max-width: 300px;">
                                Asked for pricing and left voicemail...
                                <br>
                                <a href="#" onclick="getSummary('sample-2'); return false;" class="bi bi-info-square-fill ai-instructions">View</a>
                            </td>
                            <td style="max-width: 300px;">
                                <audio controls>
                                    <source src="https://www2.cs.uic.edu/~i101/SoundFiles/CantinaBand3.wav" type="audio/wav">
                                    Your browser does not support the audio element.
                                </audio>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>13 Jan 2024, 01:42 PM</td>
                            <td>05:02</td>
                            <td>inbound</td>
                            <td>completed</td>
                            <td><span class="badge bg-success">Ended</span></td>
                            <td><span class="badge bg-danger">Negative</span></td>
                            <td>+44 20 7946 0958</td>
                            <td style="max-width: 300px;">
                                Escalated to human agent for refund...
                                <br>
                                <a href="#" onclick="getSummary('sample-3'); return false;" class="bi bi-info-square-fill ai-instructions">View</a>
                            </td>
                            <td style="max-width: 300px;">
                                <audio controls>
                                    <source src="https://www2.cs.uic.edu/~i101/SoundFiles/ImperialMarch60.wav" type="audio/wav">
                                    Your browser does not support the audio element.
                                </audio>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>14 Jan 2024, 08:25 AM</td>
                            <td>04:10</td>
                            <td>outbound</td>
                            <td>agent_hangup</td>
                            <td><span class="badge bg-success">Ended</span></td>
                            <td><span class="badge bg-success">Positive</span></td>
                            <td>+61 2 9374 4000</td>
                            <td style="max-width: 300px;">
                                Confirmed demo attendance and budget...
                                <br>
                                <a href="#" onclick="getSummary('sample-4'); return false;" class="bi bi-info-square-fill ai-instructions">View</a>
                            </td>
                            <td style="max-width: 300px;">
                                <audio controls>
                                    <source src="https://www2.cs.uic.edu/~i101/SoundFiles/PinkPanther30.wav" type="audio/wav">
                                    Your browser does not support the audio element.
                                </audio>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
  <script>
    $(document).ready(function() {
        $('.data-table').DataTable({
            pageLength: 50,
            lengthMenu: [[50, 100, 150, 200, 250, 300], [50, 100, 150, 200, 250, 300]],
            columnDefs: [
                { orderable: true, targets: 3 },
                { targets: '_all', className: 'bg-grad' }
            ],
            order: function() {
                var orderCol = $('[data-order-by="order-col"]');
                if (orderCol.length > 0) {
                    return [[orderCol.index(), 'desc']];
                } else {
                    return [[0, 'desc']];
                }
            }(),
            rowCallback: function (row) {
                $(row).addClass('bg-grad');
            },
            dom: "<'row'<'col-sm-6'l><'col-sm-6 text-end'f>>" +
                  "<'row'<'col-sm-12'tr>>" +
                  "<'row'<'col-sm-5'i><'col-sm-7 text-end d-flex justify-content-end'p>>"
        });
    });

    function getSummary(callId) {
        alert('Summary placeholder for ' + callId + '.');
        return false;
    }
  </script>
</body>
</html>
