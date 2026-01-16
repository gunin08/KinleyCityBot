<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Kinley's insights</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- html2canvas & jsPDF for export -->
  <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>

  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Fraunces:wght@600;700;800&display=swap" rel="stylesheet">
  <style>
    :root{
      --ink: #0a1022;
      --navy: #0b1b3a;
      --midnight: #0e244f;
      --teal: #1f8a7a;
      --aqua: #63d6c1;
      --amber: #f3b34b;
      --cloud: #eef2f7;
      --card: rgba(255,255,255,0.9);
      --glass: rgba(255,255,255,0.12);
      --stroke: rgba(255,255,255,0.2);
      --shadow: 0 18px 40px rgba(8,14,28,0.35);
    }

    body{
      font-family: "Space Grotesk", system-ui, -apple-system, "Segoe UI", Arial;
      background: radial-gradient(1000px 700px at 10% -10%, #1c2f61 0%, rgba(28,47,97,0) 60%),
                  radial-gradient(1200px 800px at 110% 0%, #0f3a6b 0%, rgba(15,58,107,0) 60%),
                  linear-gradient(180deg, #081225 0%, #0d1f43 55%, #0a1938 100%);
      position: relative;
      color: #f7f9fc;
      min-height: 100vh;
    }
    body::before{
      content: "";
      position: fixed;
      inset: -20%;
      background: radial-gradient(1100px 720px at 10% 10%, rgba(99,214,193,0.35), transparent 62%),
                  radial-gradient(900px 600px at 90% 15%, rgba(243,179,75,0.3), transparent 64%),
                  radial-gradient(900px 640px at 60% 95%, rgba(46,109,255,0.3), transparent 62%),
                  radial-gradient(700px 520px at 40% 60%, rgba(255,255,255,0.08), transparent 60%);
      filter: blur(4px);
      opacity: 1;
      animation: driftGlow 14s ease-in-out infinite alternate;
      z-index: 0;
      pointer-events: none;
    }
    body::after{
      content: "";
      position: fixed;
      inset: 0;
      background-image:
        radial-gradient(rgba(255,255,255,0.08) 1px, transparent 1px),
        radial-gradient(rgba(255,255,255,0.05) 1px, transparent 1px),
        linear-gradient(120deg, rgba(31,138,122,0.14), rgba(11,27,58,0.05), rgba(243,179,75,0.12));
      background-size: 120px 120px, 220px 220px, 200% 200%;
      background-position: 0 0, 40px 60px, 0% 50%;
      opacity: 0.45;
      animation: floatNoise 28s linear infinite, hueFlow 16s ease-in-out infinite alternate;
      z-index: 0;
      pointer-events: none;
    }

    .bg-canvas{
      position: relative;
      overflow: hidden;
      padding: 2rem 1.5rem 3rem;
      z-index: 1;
    }
    .bg-canvas::before{
      content: "";
      position: absolute;
      inset: -20% -10% auto -10%;
      height: 55%;
      background: radial-gradient(600px 260px at 20% 20%, rgba(99,214,193,0.22), rgba(99,214,193,0)),
                  radial-gradient(700px 320px at 80% 40%, rgba(243,179,75,0.22), rgba(243,179,75,0));
      pointer-events: none;
      z-index: 0;
    }
    .bg-canvas::after{
      content: "";
      position: absolute;
      inset: auto 5% -12% auto;
      width: 420px;
      height: 420px;
      border-radius: 50%;
      background: linear-gradient(145deg, rgba(99,214,193,0.15), rgba(99,214,193,0));
      filter: blur(6px);
      pointer-events: none;
      z-index: 0;
    }
    .page-wrap{ position: relative; z-index: 1; }

    .hero{
      margin-bottom: 2rem;
    }
    .hero-card{
      background: var(--glass);
      border: 1px solid var(--stroke);
      border-radius: 20px;
      padding: 1.8rem;
      backdrop-filter: blur(14px);
      box-shadow: var(--shadow);
    }
    .hero-head{
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 1.5rem;
      flex-wrap: wrap;
    }
    .hero h1{
      font-family: "Fraunces", serif;
      font-weight: 800;
      letter-spacing: 0.2px;
      margin-bottom: 0.4rem;
    }
    .hero p{
      color: rgba(247,249,252,0.75);
      margin-bottom: 0;
    }
    .hero-meta{
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
      margin-top: 1.2rem;
    }
    .chip{
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      background: rgba(255,255,255,0.15);
      padding: 0.35rem 0.75rem;
      border-radius: 999px;
      font-size: 0.85rem;
      color: rgba(255,255,255,0.9);
    }
    .chip-dot{
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: var(--aqua);
    }
    .hero-actions{
      display: flex;
      gap: 0.75rem;
      align-items: center;
    }
    .btn-glow{
      background: linear-gradient(180deg, #2aa69a, #177b6f);
      color: #fff;
      font-weight: 600;
      border: none;
      box-shadow: 0 10px 24px rgba(31,138,122,0.35);
    }
    .btn-outline-glass{
      background: transparent;
      border: 1px solid rgba(255,255,255,0.3);
      color: #fff;
    }

    .kpi-grid{
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 1.2rem;
      margin-bottom: 2rem;
    }
    .kpi-card{
      background: var(--card);
      color: var(--ink);
      border-radius: 18px;
      padding: 1.2rem 1.4rem;
      box-shadow: 0 12px 26px rgba(5,15,35,0.2);
      border: 1px solid rgba(255,255,255,0.7);
      position: relative;
      overflow: hidden;
    }
    .kpi-card::after{
      content: "";
      position: absolute;
      inset: auto -20% -30% auto;
      width: 160px;
      height: 160px;
      border-radius: 50%;
      background: rgba(99,214,193,0.18);
    }
    .kpi-label{
      text-transform: uppercase;
      letter-spacing: 1.6px;
      font-size: 0.7rem;
      color: rgba(10,16,34,0.55);
    }
    .kpi-value{
      font-size: 2rem;
      font-weight: 700;
      margin-top: 0.2rem;
      font-variant-numeric: tabular-nums;
    }
    .kpi-trend{
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      margin-top: 0.6rem;
      font-size: 0.85rem;
      color: rgba(10,16,34,0.7);
    }

    .table-shell{
      background: rgba(255,255,255,0.92);
      border-radius: 22px;
      padding: 1.2rem;
      box-shadow: 0 20px 48px rgba(6,14,28,0.25);
      color: var(--ink);
      border: 1px solid rgba(255,255,255,0.7);
    }
    .table-header{
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 1rem;
      padding: 0.4rem 0.6rem 1rem;
    }
    .table-title{
      font-weight: 700;
      font-size: 1.1rem;
    }
    .table-subtitle{
      color: rgba(10,16,34,0.55);
      font-size: 0.9rem;
    }
    .table-responsive{
      border-radius: 16px;
      overflow: hidden;
    }
    .table.data-table{
      margin-bottom: 0;
      background: #fff;
    }
    .table.data-table thead th{
      background: var(--navy);
      color: #fff;
      border: none;
      font-weight: 600;
      font-size: 0.9rem;
      vertical-align: middle;
      padding: 0.9rem 0.75rem;
    }
    .table.data-table tbody td{
      border-color: #eef2f7;
      vertical-align: middle;
      font-size: 0.92rem;
      padding: 0.85rem 0.75rem;
    }
    .table-striped>tbody>tr:nth-of-type(odd){
      --bs-table-accent-bg: #f7f9fd;
    }
    .badge-soft{
      background: rgba(31,138,122,0.15);
      color: #0f5f55;
      border: 1px solid rgba(31,138,122,0.2);
      font-weight: 600;
    }
    .summary-scroll{
      max-height: 120px;
      overflow-y: auto;
      padding-right: 6px;
      line-height: 1.4;
    }
    .summary-scroll::-webkit-scrollbar{
      width: 6px;
    }
    .summary-scroll::-webkit-scrollbar-thumb{
      background: rgba(11,27,58,0.3);
      border-radius: 8px;
    }
    .dataTables_wrapper .dataTables_filter{
      text-align: right;
    }
    .dataTables_wrapper .dataTables_filter label{
      font-weight: 600;
      color: rgba(10,16,34,0.6);
      font-size: 0.9rem;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }
    .dataTables_wrapper .dataTables_filter input{
      border: 1px solid #d8e1ef;
      border-radius: 999px;
      padding: 0.45rem 0.9rem;
      background: #fff;
      box-shadow: inset 0 1px 2px rgba(12,24,48,0.08);
      min-width: 220px;
    }
    .dataTables_wrapper .dataTables_filter input:focus{
      outline: none;
      border-color: rgba(31,138,122,0.6);
      box-shadow: 0 0 0 3px rgba(31,138,122,0.15);
    }
    .dataTables_wrapper .dataTables_length label{
      font-weight: 600;
      color: rgba(10,16,34,0.6);
      font-size: 0.9rem;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }
    .dataTables_wrapper .dataTables_length select{
      border: 1px solid #d8e1ef;
      border-radius: 999px;
      padding: 0.35rem 1.6rem 0.35rem 0.8rem;
      background: #fff;
      box-shadow: inset 0 1px 2px rgba(12,24,48,0.08);
      width: auto;
      min-width: 78px;
    }
    .dataTables_wrapper .dataTables_length{
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .footer-bar{
      margin-top: 2rem;
      text-align: center;
      color: rgba(247,249,252,0.7);
      font-size: 0.9rem;
    }
    .footer-bar a{
      color: #ffffff;
      text-decoration: none;
      font-weight: 600;
      border-bottom: 1px solid rgba(255,255,255,0.4);
    }
    .footer-bar a:hover{
      border-bottom-color: rgba(255,255,255,0.8);
    }
    audio{
      width: 180px;
      height: 32px;
    }

    @media (max-width: 1199px){
      .kpi-grid{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 767px){
      .bg-canvas{ padding: 1.5rem 1rem 2rem; }
      .kpi-grid{ grid-template-columns: 1fr; }
      .table-header{ flex-direction: column; align-items: flex-start; }
      audio{ width: 140px; }
    }

    @keyframes driftGlow{
      0%{
        transform: translate3d(-4%, -2%, 0) scale(1);
      }
      50%{
        transform: translate3d(3%, 2%, 0) scale(1.08);
      }
      100%{
        transform: translate3d(-2%, 3%, 0) scale(1.12);
      }
    }
    @keyframes floatNoise{
      0%{
        background-position: 0 0, 40px 60px, 0% 50%;
      }
      100%{
        background-position: 240px 240px, 120px 180px, 100% 50%;
      }
    }
    @keyframes hueFlow{
      0%{
        filter: hue-rotate(0deg) saturate(110%);
      }
      100%{
        filter: hue-rotate(18deg) saturate(140%);
      }
    }
  </style>
</head>
<body>
  <div class="bg-canvas">
    <div class="page-wrap container-xxl">

      {{-- Header --}}
      <section class="hero">
        <div class="hero-card">
          <div class="hero-head">
            <div>
              <h1 class="mb-2">Kinley's Insights</h1>
              <p>City Bot's calling performance and outcome overview</p>
            </div>
            <div class="hero-actions">
              <button class="btn btn-glow px-4" id="downloadReportBtn">Download Report</button>
            </div>
          </div>
          <div class="hero-meta">
            <span class="chip"><span class="chip-dot"></span> Live queue monitoring</span>
            <span class="chip">Timezone: Kingston/Canada</span>
          </div>
        </div>
      </section>

      {{-- KPI CARDS --}}
      <section class="kpi-grid">
        <div class="kpi-card">
          <div class="kpi-label">Total Calls</div>
          <div class="kpi-value">{{ $total_calls ?? 0 }}</div>
          <div class="kpi-trend">All sessions tracked</div>
        </div>
        <div class="kpi-card">
          <div class="kpi-label">Agent Hangup</div>
          <div class="kpi-value">{{ $agentHangup ?? 0 }}</div>
          <div class="kpi-trend">Agent-side ends</div>
        </div>
        <div class="kpi-card">
          <div class="kpi-label">User Hangup</div>
          <div class="kpi-value">{{ $userHangup ?? 0 }}</div>
          <div class="kpi-trend">User-side ends</div>
        </div>
      </section>

      {{-- MAIN CONTENT --}}
      <section class="table-shell">
        <div class="table-header">
          <div>
            <div class="table-title">Call Sessions</div>
            <div class="table-subtitle">Sortable, filterable list of all recorded interactions.</div>
          </div>
          <span class="badge badge-soft">Updated moments ago</span>
        </div>

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
              @forelse($leads as $leadKey => $lead)
                <tr data-id="{{ $lead->id }}">
                  <td>{{ $leadKey+1 }}</td>
                  <td>{{ \Carbon\Carbon::createFromTimestampMs($lead->start_timestamp)->setTimezone('Asia/Kolkata')->format('d M Y, h:i A') }}</td>
                  <td>{{ gmdate('i:s', $lead->duration_ms / 1000) }}</td>
                  <td class="text-capitalize">{{ str_replace('_', ' ', $lead->call_type) }}</td>
                  <td class="text-capitalize">{{ str_replace('_', ' ', $lead->disconnection_reason) }}</td>
                  <td>
                    @if($lead->call_status === 'ended')
                      <span class="badge bg-success">Ended</span>
                    @else
                      <span class="badge bg-warning">{{ ucfirst($lead->call_status) }}</span>
                    @endif
                  </td>
                  <td>
                    @php
                      $sentimentColors = [
                        'Positive' => 'success',
                        'Neutral'  => 'secondary',
                        'Negative' => 'danger',
                      ];
                    @endphp
                    <span class="badge bg-{{ $sentimentColors[$lead->user_sentiment] ?? 'dark' }}">
                      {{ $lead->user_sentiment ?? 'N/A' }}
                    </span>
                  </td>
                  <td>{{ $lead->from_number }}</td>
                  <td style="max-width: 320px;">
                    <div class="summary-scroll" title="{{ $lead->call_summary }}">
                      {!! $lead->call_summary !!}
                      <div class="mt-1">
                        <a href="" onclick="getSummary('{{$lead->id}}'); return false;" class="bi bi-info-square-fill ai-instructions"></a>
                      </div>
                    </div>
                  </td>
                  <td style="max-width: 300px;">
                    @if($lead->recording_url)
                      <audio controls>
                        <source src="{{ $lead->recording_url }}" type="audio/wav">
                        Your browser does not support the audio element.
                      </audio>
                    @else
                      <span>No recording available</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="10" class="text-center text-muted">
                    No call records found
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </section>

      <footer class="footer-bar">
        Made by
        <a href="https://www.linkedin.com/in/gunin-singh-415426226/" target="_blank" rel="noopener noreferrer">Gunin Singh Bhatia</a>
        and
        <a href="https://www.linkedin.com/in/niketkakkar/" target="_blank" rel="noopener noreferrer">Niket Kakkar</a>
      </footer>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://www.ibentos.ai/public/admin/admin/js/jquery-3.6.0.min.js"></script>
  <script src="https://www.ibentos.ai/public/admin/admin/js/jquery.dataTables.min.js"></script>
  <script src="https://www.ibentos.ai/public/admin/admin/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.data-table').DataTable({
        pageLength: 50,
        lengthMenu: [[50, 100, 150, 200, 250, 300], [50, 100, 150, 200, 250, 300]],
        columnDefs: [
          { orderable: true, targets: 3 }
        ],
        order: function() {
          var orderCol = $('[data-order-by="order-col"]');
          if (orderCol.length > 0) {
            return [[orderCol.index(), 'desc']];
          } else {
            return [[0, 'desc']];
          }
        }(),
        dom: "<'row'<'col-sm-6'l><'col-sm-6 text-end'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7 text-end d-flex justify-content-end'p>>"
      });
    });

    document.getElementById('downloadReportBtn').addEventListener('click', function () {
      var tableShell = document.querySelector('.table-shell');
      if (!tableShell) {
        return;
      }

      html2canvas(tableShell, { scale: 2 }).then(function (canvas) {
        var imgData = canvas.toDataURL('image/png');
        var pdf = new window.jspdf.jsPDF('p', 'pt', 'a4');
        var pageWidth = pdf.internal.pageSize.getWidth();
        var pageHeight = pdf.internal.pageSize.getHeight();
        var imgWidth = pageWidth - 48;
        var imgHeight = canvas.height * (imgWidth / canvas.width);
        var yPos = 24;

        if (imgHeight <= pageHeight - 48) {
          pdf.addImage(imgData, 'PNG', 24, yPos, imgWidth, imgHeight);
        } else {
          var remainingHeight = imgHeight;
          var position = 0;

          while (remainingHeight > 0) {
            pdf.addImage(imgData, 'PNG', 24, yPos - position, imgWidth, imgHeight);
            remainingHeight -= pageHeight - 48;
            position += pageHeight - 48;
            if (remainingHeight > 0) {
              pdf.addPage();
            }
          }
        }

        pdf.save('call_sessions_table.pdf');
      });
    });

    function getSummary(callId="") {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "post",
        url: "{{route('get-calling-summary')}}",
        data: {
          callId: callId
        },
        success: function (data) {
          $('#addEditContent').html(data);
          $('#editModal').modal('show');
        }
      });
      return false;
    }
  </script>
</body>
</html>
